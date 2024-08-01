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
        $userCount = User::count();
        $divisionCount = Division::count();
        $picCount = PersonInCharge::count();
        $documentStatusCount = DocumentStatus::count();
        $documentCount = Document::count();

        $subsectionCount = Subsection::count();
        $classificationCodeCount = ClassificationCode::count();
        $subsectionsWithDocumentCount = Subsection::withCount('documents')->get();
        $documentsWithoutSubsectionCount = Document::whereNull('subsection_id')->count();

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
