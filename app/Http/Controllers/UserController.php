<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function Index() {
        return view('frontend.index');
    } // end method

    public function UserProfile() {

        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('frontend.dashboard.edit_profile', compact('userData'));

    } // end method

    public function UserProfileStore(Request $request){

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address; 

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName(); 
            $file->move(public_path('upload/user_images'),$filename);
            $data['photo'] = $filename;  
        }

        $data->save();

        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // end method 

     public function UserLogout(Request $request) {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Logout Successfully',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    } // end method

    public function UserChangePassword() {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view ('frontend.user_change_password', compact('profileData'));
    } // end method

    public function UserUpdatePassword(Request $request) {

                // Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        // Match the old passowrd
        if (!Hash::check($request->old_password, Auth::user()->password)) {

        $notification = array (
            'message' => 'Old Password does not match!',
            'alert-type' => 'error'
        );
        return back()->with($notification);
        }

        // Update the new password
        User::whereId(Auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array (
                'message' => 'Password is changed successfully.',
                'alert-type' => 'success'
            );

        return back()->with($notification);

    } // end method
}
