<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\Document;
use App\Models\Subsection;
use App\Models\DocumentStatus;
use App\Models\PersonInCharge;
use App\Models\ClassificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = Cache::remember('userCount', 10080, function () {
            return User::count();
        });
        $divisionCount = Cache::remember('divisionCount', 10080, function () {
            return Division::count();
        });
        $picCount = Cache::remember('picCount', 10080, function () {
            return PersonInCharge::count();
        });
        $documentStatusCount = Cache::remember('documentStatusCount', 10080, function () {
            return DocumentStatus::count();
        });
        $documentCount = Document::count();

        $subsectionCount = Cache::remember('subsectionCount', 10080, function () {
            return Subsection::count();
        });
        $classificationCodeCount = Cache::remember('classificationCodeCount', 10080, function () {
            return ClassificationCode::count();
        });
        $subsectionsWithDocumentCount = Cache::remember('subsectionsWithDocumentCount', 2, function () {
            return Subsection::withCount('documents')->get();
        });
        $documentsWithoutSubsectionCount = Cache::remember('documentsWithoutSubsectionCount', 2, function () {
            return Document::whereNull('subsection_id')->count();
        });

        return view('dashboard', [
            'userCount' => $userCount,
            'divisionCount' => $divisionCount,
            'picCount' => $picCount,
            'documentStatusCount' => $documentStatusCount,
            'documentCount' => $documentCount,
            'subsectionsWithDocumentCount' => $subsectionsWithDocumentCount,
            'uploadedDocumentsCount' => Document::where('uploaded_by', Auth::id())->count(),
            'subsectionCount' => $subsectionCount,
            'classificationCodeCount' => $classificationCodeCount,
            'documentsWithoutSubsectionCount' => $documentsWithoutSubsectionCount,
        ]);
    }
}
