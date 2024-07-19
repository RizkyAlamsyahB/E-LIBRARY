<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DivisionCOntroller;
use App\Http\Controllers\DocumentStatusController;
use App\Http\Controllers\EmployeeController;

use App\Http\Controllers\PersonInChargeController;

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
});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('person_in_charge', PersonInChargeController::class);
    Route::resource('document_status', DocumentStatusController::class);
});


require __DIR__ . '/auth.php';
