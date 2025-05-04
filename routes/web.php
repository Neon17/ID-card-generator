<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/id-card', function () {
    return view('id-card');
})->name('id-card');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Regular User Routes
Route::middleware('auth')->group(function () {
    Route::patch('/profile/update-department', [UserController::class, 'updateDepartment'])->name('profile.updateDepartment');
    Route::patch('/profile/update-address', [UserController::class, 'updateAddress'])->name('profile.updateAddress');
    Route::patch('/profile/update-dob', [UserController::class, 'updateDOB'])->name('profile.updateDOB');
    Route::patch('/profile/update-photo', [UserController::class, 'updatePhoto'])->name('profile.updatePhoto');

    // Generate QR Code
    Route::get('/generate-qrcode', [CardController::class, 'generateQR'])->name('generate.qrcode');

    // Scan QR Code
    Route::get('/scan-qrcode', [CardController::class, 'scanQR'])->name('scan.qrcode');
    Route::get('/validate-qrcode', [CardController::class, 'validateQR'])->name('validate.qrcode');

    //Generate ID Card
    Route::post('/generate-id-card', [CardController::class, 'generateCard'])->name('generate-id-card');

    //Apply for Card
    Route::get('/apply-for-card', [CardController::class, 'applyForCard'])->name('apply-for-card');
    Route::get('/print-id-card', [CardController::class, 'printCard'])->name('print-id-card');
});

// admin routes
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/manage-user', [UserController::class, 'manageUser'])->name('manage-user');

    //Update Card Details
    Route::put('/update-card-details', [CardController::class, 'updateCard'])->name('update-card');

    //Get all requests for card
    Route::get('/card/requests', [CardController::class, 'getCardRequests'])->name('get-card-requests');

    //For scanning cards
    Route::get('/cards', [CardController::class, 'show'])->name('card.details');

    //For approving card requests
    Route::get('/approve-card/{id}', [CardController::class, 'approveCard'])->name('approve-card');
    Route::get('/reject-card/{id}', [CardController::class, 'rejectCard'])->name('reject-card');
});

require __DIR__ . '/auth.php';
