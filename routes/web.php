<?php

use App\Models\User;
use App\Models\Division;
use App\Models\DocumentStatus;
use App\Models\PersonInCharge;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DocumentStatusController;
use App\Http\Controllers\PersonInChargeController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    $userCount = User::count();
    $divisionCount = Division::count();
    $picCount = PersonInCharge::count();
    $documentStatusCount = DocumentStatus::count();

    return view('dashboard', [
        'userCount' => $userCount,
        'divisionCount' => $divisionCount,
        'picCount' => $picCount,
        'documentStatusCount' => $documentStatusCount,
    ]);
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
