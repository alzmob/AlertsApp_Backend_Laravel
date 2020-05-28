<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use File;

class ProfileController extends Controller
{
    public function index()
    {
        return response()->json(auth('api')->user());
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:20|unique:users,phone_number,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image'
        ]);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->save();

        // upload images
        if ($request->hasFile('avatar')) {
            $user->addMedia($request->avatar)->toMediaCollection('avatar');
        }
        // return with success msg
        return response()->json(auth('api')->user());
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);
        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->current_password, $hashedPassword)) {
            if (!Hash::check($request->password, $hashedPassword)) {
                $user = Auth::user();
                $user->password = Hash::make($request->password);
                $user->save();
                auth('api')->logout();
                return response()->json(['message' => 'Password Successfully Changed']);
            } else {
                return response()->json(['message' => 'New password cannot be the same as old password.']);
            }
        } else {
            return response()->json(['message' => 'Current password not match.']);
        }
    }

    /**
     * updateProfilePicture
     *
     * @param Request $request
     * @return void
     */
    public function updateProfilePicture(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'profile_picture' => 'required|image'
        ]);

        // upload images
        if ($request->hasFile('profile_picture')) {
            // Update profile picture
            $file = $request->profile_picture;
            $target_location = 'images/users/';
            $full_image_url = url('/') . '/' . $target_location . $user->profile_picture;
            $image_url = explode("/", $full_image_url)[5];

            if (File::exists($target_location . $image_url)) {
                File::delete($target_location . $image_url);
            }

            $filename = $user->id . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($target_location, $filename);
            $user->profile_picture = url('/') . '/' . $target_location . $filename;
            $user->save();
        }

        // return with success msg
        return response()->json(auth('api')->user());
    }
}
