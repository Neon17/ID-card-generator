<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CardInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class CardController extends Controller
{
    //
    //
    public function generateCard(Request $request)
    {
        //This function is used to generate the card for any person by admin

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'dob' => 'required|date',
            'photo' => 'required|max:2048', // 2MB max
        ]);

        $photo = $request->file('photo');
        $extension = $photo->getClientOriginalExtension();
        $randomName = Str::random(10) . '_' . time() . '.' . $extension;

        $photo->storeAs('tmp', $randomName, 'public'); 

        return $this->printCardAnonymous([
            'name' => $request->name,
            'address' => $request->address,
            'department' => $request->department,
            'dob' => $request->dob,
            'photo' => asset('storage/tmp/' . $randomName),
        ]);

        return view('currently_working');
    }

    public function updateCard(Request $request)
    {
        $request->validate([
            'card_company_name' => 'required|string|max:255',
            'card_company_type' => 'required|string|max:255',
            'card_company_logo' => 'required|max:2048', // 2MB max
            'card_duration' => 'required|integer|min:1|max:10',
        ]);

        $cardInfo = CardInfo::orderBy('created_at', 'desc')->first();

        $companyName = $request->card_company_name;
        $firstName = explode(' ', trim($companyName))[0];

        $minutesSinceMidnight = (int) now()->diffInMinutes(now()->copy()->startOfDay());
        $minutesSinceMidnight = ($minutesSinceMidnight < 0) ? (-1) * $minutesSinceMidnight : $minutesSinceMidnight;

        $fileExtension = $request->file('card_company_logo')->extension();
        $newFilename = strtolower("{$firstName}_{$minutesSinceMidnight}.{$fileExtension}");

        $cardInfo = CardInfo::first();
        if ($cardInfo && $cardInfo->company_logo) {
            $oldLogoPath = str_replace('/storage', 'public', $cardInfo->company_logo);
            Storage::delete($oldLogoPath);
        }

        $request->file('card_company_logo')->storeAs(
            'public/logos',
            $newFilename
        );

        $cardInfo = new CardInfo();
        $cardInfo->company_name = $request->card_company_name;
        $cardInfo->company_type = $request->card_company_type;
        $cardInfo->company_logo = $newFilename;
        $cardInfo->card_duration = $request->card_duration;
        $cardInfo->save();
        session()->flash('flash_notification', [
            [
                'level' => 'success',
                'message' => 'Successfully updated card information!',
                'title' => 'Done!',
            ]
        ]);
        return redirect()->route('id-card');
    }

    public function basicCardDetails()
    {
        //This function is used to show basic card information
        //Like Company Name, Company Type, Card Duration, Company Logo

        $cardInfo = CardInfo::orderBy('created_at', 'desc')->first();
        if ($cardInfo) {
            return [
                'company_name' => $cardInfo->company_name,
                'company_type' => $cardInfo->company_type,
                'card_duration' => $cardInfo->card_duration,
                'company_logo' => ($cardInfo->company_logo != null) ? $cardInfo->company_logo : null,
            ];
        } else {
            $newCardInfo = new CardInfo();
            $newCardInfo->company_name = 'ACME CORPORATION';
            $newCardInfo->company_type = 'Authorized Employee Identification';
            $newCardInfo->card_duration = 5;
            $newCardInfo->save();

            return [
                'company_name' => 'ACME CORPORATION',
                'company_type' => 'Authorized Employee Identification',
                'card_duration' => 5,
                'company_logo' => null,
            ];
        }
        return $cardInfo;
    }

    public function printCardAnonymous($user)
    {
        //It is used for printing others card by admin
        //Id is provided as Guest+Timestamp

        $cardDetails =  $this->basicCardDetails();


        // Convert QR code to base64 for embedding in HTML
        $rawQRCode = $this->generateQR();
        $qrCode = $this->transformQR($rawQRCode);

        $id = 'ACME-2025' . (int) now()->diffInMinutes(now()->copy()->startOfDay());
        $duration = ($cardDetails['card_duration']) ? $cardDetails['card_duration'] : 5;

        $user = [
            'name' => $user['name'],
            'company_name' => $cardDetails['company_name'],
            'company_type' => $cardDetails['company_type'],
            'company_logo' => $cardDetails['company_logo'],
            'photo' => $user['photo'],
            'full_name' => $user['name'],
            'id_number' => $id,
            'department' => $user['department'],
            'dob' => $user['dob'],
            'address' => $user['address'],
            'valid_from' => now()->format('M Y'),
            'valid_to' => now()->addYears($duration)->format('M Y'),
            'barcode' => 'EMP-0567-2024',
            'qr_code' => $qrCode,
        ];

        return view('print-id-card', ['user' => $user]);
    }

    public function applyForCard()
    {
        //it works for current user only

        $this->saveCurrentUserCard();

        session()->flash('flash_notification', [
            [
                'level' => 'success',
                'message' => 'Successfully applied for ID Card!',
                'title' => 'Done!',
            ]
        ]);

        return redirect()->route('id-card');
    }

    public function getCardRequests()
    {
        //Here list of all card requests waiting for admin to approve are shown
        $cards = Card::where('approve_status', 'pending')->get();

        // Format dates for each card
        $cards->transform(function ($card) {
            $card->formatted_created_at = $card->created_at->format('Y m d');
            $card->formatted_dob = $card->dob->format('Y m d');
            return $card;
        });

        return view('card-requests', ['cards' => $cards]);
    }

    public function approveCard(Request $request)
    {
        $card = Card::where('id', $request->id)->first();
        $card->approve_status = 'approved';
        $card->approve_date = now();
        $card->approve_by = Auth::user()->name;
        $card->save();

        $user = User::where('id', $card->user_id)->first();
        $user->card_approve_status = 'approved';
        $user->update();

        session()->flash('flash_notification', [
            [
                'level' => 'success',
                'message' => 'Successfully approved ID Card!',
                'title' => 'Done!',
            ]
        ]);
        return redirect()->route('manage-user');
    }
    public function rejectCard(Request $request)
    {
        $card = Card::where('id', $request->id)->first();
        $card->approve_status = 'rejected';
        $card->approve_date = now();
        $card->approve_by = Auth::user()->name;
        $card->message_by_admin = $request->message;
        $card->message = 'Your ID Card has been rejected by ' . Auth::user()->name . ' with message: ' . $request->message;
        $card->qr_code = null; // Clear the QR code if rejected 
        $card->save();

        $user = User::where('id', $request->id)->first();
        $user->card_approve_status = 'approved';
        $user->update();

        session()->flash('flash_notification', [
            [
                'level' => 'error',
                'message' => 'Successfully rejected ID Card!',
                'title' => 'Done!',
            ]
        ]);
        return redirect()->route('manage-user');
    }

    public function saveCurrentUserCard($approve_status = 'pending', $duration_in_years = 3)
    {
        //store new card for current user
        $user = User::where('id', Auth::user()->id)->first();
        $user->card_approve_status = $approve_status;
        $user->card_apply_status = 'applied';
        $user->update();

        $card = Card::where('user_id', Auth::user()->id)->delete();

        $card = new Card();
        $card->name = Auth::user()->name;
        $card->company_name = 'ACME';
        $card->company_type = 'Authorized User Identification';
        $card->department = Auth::user()->department;
        $card->dob = Auth::user()->dob;
        $card->address = Auth::user()->address;
        $card->user_id = Auth::user()->id;
        $card->photo = Auth::user()->photo;
        $card->approve_status = $approve_status;
        $card->approve_date = null;
        $card->approve_by = null;
        $card->duration_in_years = $duration_in_years;
        $card->message = 'Scan this QR code for verification';
        $card->message_by_admin = null;
        $card->save();
    }

    public function verifyStoreCard($id)
    {
        //This function is used to verify the card approval status for user and store card for admin if he/she want to print card for first time

        //$id is user ID
        $card = Card::where('user_id', $id)->first();
        $user = User::where('id', $id)->first();

        if ($user->isAdmin) {
            //Admin stores his card in database
            $this->saveCurrentUserCard('approved');
            return true;
        }

        if (!$card) {
            session()->flash('flash_notification', [
                [
                    'level' => 'error',
                    'message' => 'Please apply for ID card first on ID Card of navigation menu!',
                    'title' => 'Unapplied User',
                ]
            ]);
            return false;
        }

        if ($card->approve_status != "approved") {
            session()->flash('flash_notification', [
                [
                    'level' => 'error',
                    'message' => 'Your card has not been approved. Please contact!',
                    'title' => 'Unapproved Card',
                ]
            ]);
            return false;
        }
        return true;
    }

    public function printCard()
    {
        //It is used for printing own card
        //User goes through approval status but admin can directly print card without needing approval

        $user = User::where('id', Auth::user()->id)->first();

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

        if (!$this->verifyStoreCard(Auth::user()->id)) {
            return redirect(route('id-card'));
        }

        $card = Card::where('user_id', Auth::user()->id)->first();

        // Convert QR code to base64 for embedding in HTML
        $rawQRCode = $this->generateQR();
        $qrCode = $this->transformQR($rawQRCode);

        $id = 'ACME-2025-' . strval($user->id);

        $user = [
            'name' => $user->name,
            'company_name' => $card->company_name,
            'company_type' => $card->company_type,
            'company_logo' => $card->company_logo,
            'photo' => asset('storage/photos/' . $user->photo),
            'full_name' => $user->name,
            'id_number' => $id,
            'department' => $user->department,
            'dob' => $user->dob->format('d/m/Y'),
            'address' => $user->address,
            'valid_from' => now()->format('M Y'),
            'valid_to' => now()->addYears(2)->format('M Y'),
            'barcode' => 'EMP-0567-2024',
            'qr_code' => $qrCode,
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

    public function transformQR($qr)
    {
        //this transform the QR code to a string that can be embedded in html code
        return base64_encode($qr);
    }

    public function generateQR($user = null)
    {
        //if $user == null, then it will generate QR code for current user
        //if $user != null, then it will generate QR code for that user

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

        return $qrCode;
        // return view('generate-qrcode', compact('qrCode'));
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
