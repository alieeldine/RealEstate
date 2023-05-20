<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Property;
use App\Models\MultiImages;
use App\Models\Facility;
use App\Models\Amenities;
use App\Models\PropertyType;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PropertyController extends Controller
{
    public function AllProperties() {
        $properties = Property::latest()->get();
        return view('backend.properties.all_properties', compact('properties'));
    } // end method

    public function AddProperty() {
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();
        return view ('backend.properties.add_property',compact('propertytype','amenities','activeAgent'));
    } // end method

    public function StoreProperty(Request $request) {
        
        $amen = $request->amenities_id;
        $amenites = implode(",", $amen);
        //dd($amenites);

        $pcode = IdGenerator::generate(['table'=>'properties', 'field'=>'property_code', 'length'=>5, 'prefix'=>'PC' ]);

        $image = $request->file('property_thumbnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        image::make($image)->resize(370,250)->save('upload/property/thumbnail/'.$name_gen);
        $save_url = 'upload/property/thumbnail/'.$name_gen;

        $property_id = Property::insertGetId([
            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenites,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
            'property_code' => $pcode,
            'property_status' => $request->property_status,

            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,

            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,

            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => $request->agent_id,
            'status' => 1,
            'property_thumbnail' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        /// Multiple Image Upload From Here ////

        $images = $request->file('multi_img');
        foreach($images as $img){

        $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        Image::make($img)->resize(770,520)->save('upload/property/multi-image/'.$make_name);
        $uploadPath = 'upload/property/multi-image/'.$make_name;

        MultiImages::insert([

            'property_id' => $property_id,
            'photo_name' => $uploadPath,
            'created_at' => Carbon::now(), 

        ]); 
        } // End Foreach
         /// End Multiple Image Upload From Here ////

        /// Facilities Add From Here ////
        $facilities = Count($request->facility_name);

        if ($facilities != NULL) {
           for ($i=0; $i < $facilities; $i++) { 
               $fcount = new Facility();
               $fcount->property_id = $property_id;
               $fcount->facility_name = $request->facility_name[$i];
               $fcount->distance = $request->distance[$i];
               $fcount->save();
           }
        }
        /// End Facilities  ////

            $notification = array(
            'message' => 'Property Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.properties')->with($notification);

    } // end method

    public function EditProperty($id) {        

        $facilities = Facility::where('property_id',$id)->get();
        $property = Property::findOrFail($id);

        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        $multiImage = MultiImages::where('property_id',$id)->get();

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();
        return view('backend.properties.edit_property',compact('property','propertytype','amenities','activeAgent', 'property_ami', 'multiImage', 'facilities'));
    }

    public function UpdateProperty(Request $request) {
        
        $amen = $request->amenities_id;
        $amenites = implode(",", $amen);

        $property_id = $request->id;

        Property::findOrFail($property_id)->update([
            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenites,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
            'property_status' => $request->property_status,

            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,

            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,

            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => $request->agent_id,            
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Property Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.properties')->with($notification);

    } // end method

    public function UpdatePropertyThumbnail(Request $request) {
        
        $pro_id = $request->id;
        $old_img = $request->old_img;

        $image = $request->file('property_thumbnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        image::make($image)->resize(370,250)->save('upload/property/thumbnail/'.$name_gen);
        $save_url = 'upload/property/thumbnail/'.$name_gen;

        if (file_exists($old_img)) { unlink($old_img); }

        Property::findOrFail($pro_id)->update([
            'property_thumbnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Property Thumbnail Image Is Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // end method

    public function UpdatePropertyMultiimage(Request $request) {

        $imgs = $request->multi_img;

        foreach($imgs as $id => $img){
            $imgDel = MultiImages::findOrFail($id);
            unlink($imgDel->photo_name);

            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(770,520)->save('upload/property/multi-image/'.$make_name);
            $uploadPath = 'upload/property/multi-image/'.$make_name;

        MultiImages::where('id',$id)->update([

            'photo_name' => $uploadPath,
            'updated_at' => Carbon::now(),

        ]);

        } // End Foreach 


        $notification = array(
            'message' => 'Property Multi Image is Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    } // end method

    public function DeletePropertyMultiimage($id) {

        $oldImg = MultiImages::findOrFail($id);
        unlink($oldImg->photo_name);

        MultiImages::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Property Thumbnail Image Is Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // end method

    public function StoreNewMultiimage(Request $request){

        $new_multi = $request->imageid;
        $image = $request->file('multi_img');

        $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(770,520)->save('upload/property/multi-image/'.$make_name);
        $uploadPath = 'upload/property/multi-image/'.$make_name;

        MultiImages::insert([
            'property_id' => $new_multi,
            'photo_name' => $uploadPath,
            'created_at' => Carbon::now(), 
        ]);

        $notification = array(
            'message' => 'Property Multi Image Is Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 
    } // end method

    public function UpdatePropertyFacilities(Request $request){

        $pid = $request->id;

        if ($request->facility_name == NULL) {
            return redirect()->back();
        } else {
            Facility::where('property_id', $pid)->delete();

            $facilities = Count($request->facility_name); 

            for ($i=0; $i < $facilities; $i++) { 
                $fcount = new Facility();
                $fcount->property_id = $pid;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->distance = $request->distance[$i];
                $fcount->save();
            } // end for 
        }

        $notification = array(
            'message' => 'Property Facility Is Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    } // end method

    public function DeleteProperty($id) {

        $property = Property::findOrFail($id);
        unlink($property->property_thumbnail);

        Property::findOrFail($id)->delete();

        $image = MultiImages::where('property_id',$id)->get();

        foreach($image as $img){
            unlink($img->photo_name);
            MultiImages::where('property_id',$id)->delete();
        }

        $facilitiesData = Facility::where('property_id',$id)->get();
        foreach($facilitiesData as $item){
            //$item->facility_name;
            Facility::where('property_id',$id)->delete();
        }

        $notification = array(
            'message' => 'Property Is Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 
    } // end method

    public function DetailsProperty($id) {        

        $facilities = Facility::where('property_id',$id)->get();
        $property = Property::findOrFail($id);

        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        $multiImage = MultiImages::where('property_id',$id)->get();

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();
        return view('backend.properties.details_property',compact('property','propertytype','amenities','activeAgent', 'property_ami', 'multiImage', 'facilities'));
    } // end method

    public function InactiveProperty(Request $request){

        $pid = $request->id;
        Property::findOrFail($pid)->update([
            'status' => 0,
        ]);

        $notification = array(
            'message' => 'Property Inactive Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.properties')->with($notification);
    } // end method


    public function ActiveProperty(Request $request){

        $pid = $request->id;
        Property::findOrFail($pid)->update([
            'status' => 1,
        ]);

        $notification = array(
            'message' => 'Property Active Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.properties')->with($notification); 
    } // end method

}
