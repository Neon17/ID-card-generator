<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IDCardController extends Controller
{
    //
    //
    public function printIDCard()
    {
        $user = User::where('id', Auth::user()->id)->first();

        if ($user->name == null || $user->department == null || $user->dob == null || $user->address == null) {
            session()->flash('flash_notification', [
                [
                    'level' => 'error',
                    'message' => 'Please fill all details in profile except photo to get ID Card!',
                    'title' => 'Incomplete Profile',
                ]
            ]);
            return back();
        }

        $id = 'ACME-2025-'.strval($user->id);

        $employee = [
            'photo' => asset(`storage/employees/` + $user->photo),
            'full_name' => $user->name,
            'id_number' => $id,
            'department' => $user->department,
            'dob' => $user->dob->format('d/m/Y'),
            'address' => $user->address,
            'valid_from' => now()->format('M Y'),
            'valid_to' => now()->addYears(2)->format('M Y'),
            'barcode' => 'EMP-0567-2024',
            'qr_code' => asset('storage/employees/qr-codes/john.png')
        ];

        return view('print-id-card', ['employee' => $employee]);
    }
}
