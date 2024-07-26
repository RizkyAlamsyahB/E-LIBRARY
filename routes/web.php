<?php

use App\Models\User;
use App\Models\Division;
use App\Models\Document;
use App\Models\Subsection;
use App\Models\DocumentStatus;
use App\Models\PersonInCharge;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SubsectionController;
use App\Http\Controllers\DocumentStatusController;
use App\Http\Controllers\PersonInChargeController;
use App\Http\Controllers\ClassificationCodeController;

Route::get('/', function () {
    return redirect('/login');
});

// Dashboard Route
Route::get('/dashboard', function () {
    $userCount = User::count();
    $divisionCount = Division::count();
    $picCount = PersonInCharge::count();
    $documentStatusCount = DocumentStatus::count();
    $documentCount = Document::count();

    // Hitung total dokumen per subseksi
    $subsectionsWithDocumentCount = Subsection::withCount('documents')->get();

    // Hitung total dokumen yang diunggah oleh pengguna yang sedang login
    $uploadedDocumentsCount = Document::where('uploaded_by', auth()->user()->id)->count();

    return view('dashboard', [
        'userCount' => $userCount,
        'divisionCount' => $divisionCount,
        'picCount' => $picCount,
        'documentStatusCount' => $documentStatusCount,
        'documentCount' => $documentCount,
        'subsectionsWithDocumentCount' => $subsectionsWithDocumentCount,
        'uploadedDocumentsCount' => $uploadedDocumentsCount,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('documents', DocumentController::class);
    Route::get('/documents/preview/{filename}', [DocumentController::class, 'preview'])->name('documents.preview');
    Route::get('/documents/download/{filename}', [DocumentController::class, 'download'])->name('documents.download');
});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('person_in_charge', PersonInChargeController::class);
    Route::resource('document_status', DocumentStatusController::class);
    Route::resource('subsections', SubsectionController::class);
    Route::resource('classification-codes', ClassificationCodeController::class);
    Route::get('/divisions/{division}/subsections', [DivisionController::class, 'getSubsections']);

    // web.php
    Route::get('/subsections-by-division', [EmployeeController::class, 'getSubsectionsByDivision'])->name('subsections.getByDivision');
});

require __DIR__ . '/auth.php';
