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
        $userCount = number_format(User::count(), 0, ',', '.');
        $divisionCount = number_format(Division::count(), 0, ',', '.');
        $picCount = number_format(PersonInCharge::count(), 0, ',', '.');
        $documentStatusCount = number_format(DocumentStatus::count(), 0, ',', '.');
        $documentCount = number_format(Document::count(), 0, ',', '.');

        $subsectionCount = number_format(Subsection::count(), 0, ',', '.');
        $classificationCodeCount = number_format(ClassificationCode::count(), 0, ',', '.');
        $subsectionsWithDocumentCount = Subsection::withCount('documents')->get();
        $documentsWithoutSubsectionCount = number_format(Document::whereNull('subsection_id')->count(), 0, ',', '.');

        return view('dashboard', [
            'userCount' => $userCount,
            'divisionCount' => $divisionCount,
            'picCount' => $picCount,
            'documentStatusCount' => $documentStatusCount,
            'documentCount' => $documentCount,
            'subsectionsWithDocumentCount' => $subsectionsWithDocumentCount,
            'uploadedDocumentsCount' => number_format(Document::where('uploaded_by', Auth::id())->count(), 0, ',', '.'),
            'subsectionCount' => $subsectionCount,
            'classificationCodeCount' => $classificationCodeCount,
            'documentsWithoutSubsectionCount' => $documentsWithoutSubsectionCount,
        ]);
    }

}
