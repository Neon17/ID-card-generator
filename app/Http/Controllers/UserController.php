<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function manageUser(Request $request){
        $users = User::where('isAdmin', false)->get();

        return view('manage-user', compact('users'));
    }

    public function updateDepartment(Request $request)
    {
        if ($request->department == null)
            return redirect(route('profile.edit'));

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
        if ($request->dob == null)
            return redirect(route('profile.edit'));
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
        if ($request->photo == null){
            return redirect()->route('profile.edit')->with('flash_notification', [
                [
                    'level' => 'error',
                    'message' => 'Please put profile photo to update',
                    'title' => 'Failed!'
                ]
            ]);   
        }
        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048', //max 2MB
        ]);

        $user = User::where('id', Auth::user()->id)->first();

        $extension = $request->file('photo')->extension();
        $filename = 'user_' . $user->id . '_' . time() . '.' . $extension;

        // Store file (in storage/app/public/photos)
        $request->file('photo')->storeAs('photos', $filename, 'public');

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
            return redirect(route('profile.edit'));
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
