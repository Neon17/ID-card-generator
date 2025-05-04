<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class IDCardController extends Controller
{
    //
    //
    public function generateIDCard(Request $request)
    {
        if ($request->name == null || $request->department == null || $request->dob == null || $request->address == null) {
            session()->flash('flash_notification', [
                [
                    'level' => 'error',
                    'message' => 'Please fill all details to get ID Card',
                    'title' => 'Incomplete Profile',
                ]
            ]);
            return back();
        }


        return "Currently working on this feature and will be available for admin only on next update!";
    }

    public function printIDCard()
    {
        $user = User::where('id', Auth::user()->id)->first();

        if (!$user->isAdmin) {
            if ($user->name == null || $user->department == null || $user->dob == null || $user->address == null) {
                session()->flash('flash_notification', [
                    [
                        'level' => 'error',
                        'message' => 'Please fill all details in profile except photo to get ID Card or contact admin!',
                        'title' => 'Incomplete Profile',
                    ]
                ]);
                return back();
            }
        }

        $id = 'ACME-2025-' . strval($user->id);

        $user = [
            'photo' => asset('storage/photos/' . $user->photo),
            'full_name' => $user->name,
            'id_number' => $id,
            'department' => $user->department,
            'dob' => $user->dob->format('d/m/Y'),
            'address' => $user->address,
            'valid_from' => now()->format('M Y'),
            'valid_to' => now()->addYears(2)->format('M Y'),
            'barcode' => 'EMP-0567-2024',
            'qr_code' => asset('storage/photos/qr-codes/john.png')
        ];

        return view('print-id-card', ['user' => $user]);
    }

    public function show(Request $request)
    {
        $type = $request->query('type');
        $data = [];

        switch ($type) {
            case 'wifi':
                $data = [
                    'ssid' => $request->query('ssid'),
                    'encryption' => $request->query('encryption'),
                    'password' => $request->query('password'),
                    'hidden' => $request->query('hidden'),
                ];
                break;

            case 'id-card':
                $jsonString = $request->query('data');
                $data = json_decode($jsonString, true);
                $user = User::select('id', 'name', 'email', 'address', 'photo', 'dob', 'department', 'isAdmin')
                    ->where('id', $data['user_id'])
                    ->first()
                    ->toArray();

                $data = $user;
                break;

            case 'json':
                $jsonString = $request->query('data');
                $data = json_decode($jsonString, true);
                break;

            case 'text':
            default:
                $data = ['text' => $request->query('data')];
                break;
        }

        return view('scan-card', compact('type', 'data'));
    }

    public function generateQR()
    {
        $user = Auth::user();
        $data = [
            'user_id' => $user->id,
            'message' => 'Scan this QR code for verification',
            'timestamp' => now()->toDateTimeString()
        ];

        $qrCode = QrCode::size(400)
            ->margin(4)
            ->errorCorrection('H') // High error correction
            ->backgroundColor(255, 255, 255)
            ->color(0, 0, 0)
            ->generate(json_encode($data));

        return view('generate-qrcode', compact('qrCode'));
    }
    public function scanQR()
    {
        return view('scan-qrcode');
    }

    private function parseWifiQr($qr)
    {
        $qr = trim(substr($qr, 5), ';');
        $segments = explode(';', $qr);
        $data = [];

        foreach ($segments as $segment) {
            if (strpos($segment, ':') !== false) {
                [$key, $value] = explode(':', $segment, 2);
                $data[$key] = $value;
            }
        }

        return [
            'ssid' => $data['S'] ?? '',
            'encryption' => $data['T'] ?? '',
            'password' => $data['P'] ?? '',
            'hidden' => $data['H'] ?? 'false'
        ];
    }

    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function validateQR(Request $request)
    {
        $qrRaw = $request->query('qr_data');

        // Case 1: WiFi QR
        if (Str::startsWith($qrRaw, 'WIFI:')) {
            $wifi = $this->parseWifiQr($qrRaw);
            return redirect()->route('card.details', [
                'type' => 'wifi',
                'ssid' => $wifi['ssid'],
                'encryption' => $wifi['encryption'],
                'password' => $wifi['password'],
                'hidden' => $wifi['hidden'],
            ]);
        }

        // Case 2: URL QR
        if (filter_var($qrRaw, FILTER_VALIDATE_URL)) {
            return redirect()->away($qrRaw); // open external link directly
        }

        // Case 3: JSON-based QR (our app's format, like id-card)
        if ($this->isJson($qrRaw)) {
            $json = json_decode($qrRaw, true);

            // You can add more custom matching rules here
            if (isset($json['user_id']) && isset($json['message'])) {
                return redirect()->route('card.details', [
                    'type' => 'id-card',
                    'data' => $qrRaw,
                ]);
            }

            return redirect()->route('card.details', [
                'type' => 'json',
                'data' => $qrRaw,
            ]);
        }

        // Case 4: Fallback - treat as plain text
        return redirect()->route('card.details', [
            'type' => 'text',
            'data' => $qrRaw,
        ]);
    }
}
