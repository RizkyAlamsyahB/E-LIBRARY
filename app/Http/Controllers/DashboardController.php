<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\PersonInCharge;
use App\Models\DocumentStatus;
use App\Models\Document;
use App\Models\Subsection;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $divisionCount = Division::count();
        $picCount = PersonInCharge::count();
        $documentStatusCount = DocumentStatus::count();
        $documentCount = Document::count();

        // Hitung total dokumen per subseksi
        $subsectionsWithDocumentCount = Subsection::withCount('documents')->get();

        // Hitung total dokumen yang diunggah oleh pengguna yang sedang login
        $uploadedDocumentsCount = Document::where('uploaded_by', Auth::id())->count();

        return view('dashboard', [
            'userCount' => $userCount,
            'divisionCount' => $divisionCount,
            'picCount' => $picCount,
            'documentStatusCount' => $documentStatusCount,
            'documentCount' => $documentCount,
            'subsectionsWithDocumentCount' => $subsectionsWithDocumentCount,
            'uploadedDocumentsCount' => $uploadedDocumentsCount,
        ]);
    }
}
