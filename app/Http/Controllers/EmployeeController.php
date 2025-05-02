<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function showIDCard()
    {
        $employee = [
            'photo' => asset('storage/employees/photo.jpg'),
            'full_name' => 'John Doe',
            'id_number' => 'ACME-2024-5678',
            'department' => 'Engineering',
            'valid_from' => now()->format('M Y'),
            'valid_to' => now()->addYears(2)->format('M Y'),
            'barcode' => '| 12345 67890 |',
            'qr_code' => asset('storage/employees/qrcode.png')
        ];

        return view('print-id-card', compact('employee'));
    }
}
