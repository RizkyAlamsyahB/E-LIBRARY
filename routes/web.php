<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DivisionCOntroller;
use App\Http\Controllers\DocumentStatusController;
use App\Http\Controllers\EmployeeController;

use App\Http\Controllers\PersonInChargeController;
use App\Models\DocumentStatus;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $userCount = User::count();
    return view('dashboard', ['userCount' => $userCount]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('employees', EmployeeController::class);
    Route::resource('divisions', DivisionCOntroller::class);
  Route::resource('document_status', DocumentStatusController::class);

 Route::resource('person_in_charge', PersonInChargeController::class);



});

require __DIR__ . '/auth.php';
