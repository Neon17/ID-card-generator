<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function manageUser(Request $request)
    {
        $users = User::where('isAdmin', false)->get();
        return view('manage-user', compact('users'));
    }

    public function updateDepartment(Request $request)
    {
        if ($request->department == null) {
            return redirect()->route('profile.edit', ['#container_update_address'])->with('flash_notification', [
                [
                    'level' => 'error',
                    'message' => 'Please enter the department to update!',
                    'title' => 'Incomplete!'
                ]
            ]);
        }

        $user = User::where('id', Auth::user()->id)->first();
        $user->department = $request->department;
        $user->update();

        return redirect()->route('profile.edit')->with('flash_notification', [
            [
                'level' => 'success',
                'message' => 'Successfully updated department!',
                'title' => 'Done!'
            ]
        ]);
    }

    public function updateDOB(Request $request)
    {
        if ($request->dob == null){
            return redirect()->route('profile.edit', ['#container_update_dob'])->with('flash_notification', [
                [
                    'level' => 'error',
                    'message' => 'Please enter the date of birth to update!',
                    'title' => 'Incomplete!'
                ]
            ]);
        }
        $user = User::where('id', Auth::user()->id)->first();
        $user->dob = $request->dob;
        $user->update();

        return redirect()->route('profile.edit')->with('flash_notification', [
            [
                'level' => 'success',
                'message' => 'Successfully updated date of birth!',
                'title' => 'Done!'
            ]
        ]);
    }

    public function updatePhoto(Request $request)
    {
        // Custom validation
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'photo.required' => 'Please select a photo to upload',
            'photo.image' => 'The file must be an image',
            'photo.mimes' => 'Only JPEG, PNG, and JPG images are allowed',
            'photo.max' => 'The image must not exceed 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.edit', ['#container_update_photo'])->with('flash_notification', [
                [
                    'level' => 'error',
                    'message' => $validator->errors()->first('photo'),
                    'title' => 'Validation Failed!'
                ]
            ]);
        }

        $user = User::where('id', Auth::user()->id)->first();

        $extension = $request->file('photo')->extension();
        $filename = 'user_' . $user->id . '_' . time() . '.' . $extension;

        // Delete old photo if exists
        if ($user->photo && Storage::disk('public')->exists('photos/' . $user->photo)) {
            Storage::disk('public')->delete('photos/' . $user->photo);
        }

        // Store photo (in storage/app/public/photos) with explicit public visibility
        $path = $request->file('photo')->storeAs(
            'photos',
            $filename,
            ['disk' => 'public', 'visibility' => 'public']
        );

        // 4. Storage Verification
        if (!Storage::disk('public')->exists($path)) {
            throw new \Exception("Failed to store file at: $path");
        }

        $user->photo = $filename;
        $user->update();

        return redirect()->route('profile.edit')->with('flash_notification', [
            [
                'level' => 'success',
                'message' => 'Successfully updated profile picture!',
                'title' => 'Done!'
            ]
        ]);
    }

    public function updateAddress(Request $request)
    {
        if ($request->address == null)
            return redirect(route('profile.edit'), ['#container_update_department'])->with('flash_notification', [
                [
                    'level' => 'error',
                    'message' => 'Please enter the address to update!',
                    'title' => 'Incomplete!',
                ]
            ]);
        $user = User::where('id', Auth::user()->id)->first();
        $user->address = $request->address;
        $user->update();

        return redirect()->route('profile.edit')->with('flash_notification', [
            [
                'level' => 'success',
                'message' => 'Successfully updated address!',
                'title' => 'Done!'
            ]
        ]);
    }
}
