<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\PropertyType;
use App\Models\Amenities;

class PropertyTypeController extends Controller
{
    public function AllTypes() {
        $types = PropertyType::latest()->get();
        return view('backend.types.all_types', compact('types'));
    } // end method

    public function AddType() {
        return view ('backend.types.add_type');
    } // end method

    public function StoreType(Request $request) {
        
        // Validation
        $request->validate([
            'type_name' => 'required|unique:property_types|max:200',
            'type_icon' => 'required'
        ]);

        PropertyType::insert([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Property Type Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.types')->with($notification);

    } // end method

    public function EditType($id) {
        $types = PropertyType::findOrFail($id);
        return view('backend.types.edit_type', compact('types'));
    }

    public function UpdateType(Request $request) {
        
        $pid = $request->id;

        PropertyType::findOrFail($pid)->update([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Property Type Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.types')->with($notification);

    } // end method

    public function DeleteType($id) {
        PropertyType::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Property Type Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method

    //////////////// Amenities All Methods ////////////////

    public function AllAmenities() {
        $amenities = Amenities::latest()->get();
        return view('backend.amenities.all_amenities', compact('amenities'));
    } // end method

    public function AddAmenitie() {
        return view ('backend.amenities.add_amenitie');
    } // end method

    public function StoreAmenitie(Request $request) {

        Amenities::insert([
            'amenitie_name' => $request->amenitie_name,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Amenity Is Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.amenities')->with($notification);

    } // end method

    public function EditAmenitie($id) {
        $amenities = Amenities::findOrFail($id);
        return view('backend.amenities.edit_amenitie', compact('amenities'));
    }

    public function UpdateAmenitie(Request $request) {
        
        $ame_id = $request->id;

        Amenities::findOrFail($ame_id)->update([
            'amenitie_name' => $request->amenitie_name,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Amenity Is Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.amenities')->with($notification);

    } // end method

    public function DeleteAmenitie($id) {
        Amenities::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Amenity Is Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method
}