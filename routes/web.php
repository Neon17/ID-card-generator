<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IDCardController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/id-card', function () {
    return view('id-card');
})->name('id-card');

Route::get('/manage-user', [UserController::class, 'manageUser'])->name('manage-user');

Route::get('/print-id-card', [IDCardController::class, 'printIDCard'])->name('print-id-card');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::patch('/profile/update-department', [UserController::class, 'updateDepartment'])->name('profile.updateDepartment');
    Route::patch('/profile/update-address', [UserController::class, 'updateAddress'])->name('profile.updateAddress');
    Route::patch('/profile/update-dob', [UserController::class, 'updateDOB'])->name('profile.updateDOB');
    Route::patch('/profile/update-photo', [UserController::class, 'updatePhoto'])->name('profile.updatePhoto');

    // Generate QR Code
    Route::get('/generate-qrcode', [IDCardController::class, 'generateQR'])->name('generate.qrcode');

    // Scan QR Code
    Route::get('/scan-qrcode', [IDCardController::class, 'scanQR'])->name('scan.qrcode');
    Route::get('/validate-qrcode', [IDCardController::class, 'validateQR'])->name('validate.qrcode');

    Route::get('/cards', [IDCardController::class, 'show'])->name('card.details');
});

require __DIR__ . '/auth.php';
