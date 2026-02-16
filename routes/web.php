<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('doctors', DoctorController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('appointments', AppointmentController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Clinical History Routes
    Route::get('/patients/{patient}/history', [MedicalRecordController::class, 'index'])->name('patients.history');
    Route::get('/patients/{patient}/history/create', [MedicalRecordController::class, 'create'])->name('medical_records.create');
    Route::post('/patients/{patient}/history', [MedicalRecordController::class, 'store'])->name('medical_records.store');
    Route::get('/medical-records/{medicalRecord}/print', [MedicalRecordController::class, 'show'])->name('medical_records.print');
    Route::post('/medical-records/{medicalRecord}/email', [MedicalRecordController::class, 'email'])->name('medical_records.email');
});

require __DIR__.'/auth.php';
