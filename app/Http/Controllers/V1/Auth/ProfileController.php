<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function viewProfile(Request $request)
    {
        $viewProfile = $request->user();

        return response()->json([
            'viewProfile' => $viewProfile
        ]);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'address1' => 'required',
            'address2' => 'required',
        ]);

        $profile = $request->user();

        $profile->name = $request->input('name');
        $profile->phone1 = $request->input('phone1');
        $profile->phone2 = $request->input('phone2');
        $profile->address1 = $request->input('address1');
        $profile->address2 = $request->input('address2');
        $profile->update();

        return response()->json([
            'status' => 'Profile Updated Successfully',
            'profile' => $profile
        ]);
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'old_password' => 'required',
            'password' => 'required',
            'confirm_password' => 'required'
        ]);


        $user = $request->user();

        if(Hash::check($data['old_password'], $user->password))
        {
            $user->update([
                'password' => Hash::make($data['password'])
            ]);

            return response()->json([
                'message' => 'Password Updated Successfully !',
            ], 400);

        } else {
            return response()->json([
                'message' => 'Old Password Does Not Matches !'
            ]);
        }
        
    }
}
