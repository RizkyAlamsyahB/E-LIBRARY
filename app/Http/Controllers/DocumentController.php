<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Document;
use App\Models\Subsection;
use Illuminate\Http\Request;
use App\Models\DocumentStatus;
use App\Models\PersonInCharge;
use App\Models\ClassificationCode;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        // Mengambil semua dokumen dengan eager loading untuk relasi classification_code
        $documents = Document::with(['classificationCode', 'personInCharge', 'documentStatus', 'division', 'subsection'])->get();


        return view('admin.pages.documents.index', compact('documents'));
    }

    public function create()
    {
        $personsInCharge = PersonInCharge::all();
        $documentStatuses = DocumentStatus::all();
        $classificationCodes = ClassificationCode::all();
        $divisions = Division::all();

        return view('admin.pages.documents.create', compact('documentStatuses', 'personsInCharge', 'classificationCodes', 'divisions'));
    }

    // app/Http/Controllers/DocumentController.php
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        $divisions = Division::all();
        $subsections = Subsection::all();
        $documentStatuses = DocumentStatus::all();
        $classificationCodes = ClassificationCode::all();
        $personsInCharge = PersonInCharge::all();

        return view('admin.pages.documents.edit', compact(
            'document',
            'divisions',
            'subsections',
            'documentStatuses',
            'classificationCodes',
            'personsInCharge'
        ));
    }


    public function show(Request $request, $id)
    {
        $request->validate([
            'id' => 'required|integer|exists:documents,id',
        ]);

        $document = Document::findOrFail($id);

        return view('documents.show', compact('document'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file',
            'document_creation_date' => 'required|date',
            'person_in_charge_id' => 'required|exists:persons_in_charge,id',
            'document_status_id' => 'required|exists:document_status,id',
            'classification_code_id' => 'required|exists:classification_codes,id',
            'subsection_id' => 'nullable|exists:subsections,id',
            'division_id' => 'required|exists:divisions,id', // Add validation for division_id
        ]);

        // Handle file upload
        $file = $request->file('file');
        $filename = $file->getClientOriginalName(); // Get the original file name
        $path = $file->storeAs('documents', $filename, 'public'); // Store file with original name

        // Create a new document record
        $document = Document::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'file_path' => $path, // Store path to file
            'original_file_name' => $filename, // Optional: Store original file name
            'document_creation_date' => $validatedData['document_creation_date'],
            'uploaded_by' => auth()->user()->id,
            'person_in_charge_id' => $validatedData['person_in_charge_id'],
            'document_status_id' => $validatedData['document_status_id'],
            'classification_code_id' => $validatedData['classification_code_id'],
            'subsection_id' => $validatedData['subsection_id'],
            'division_id' => $validatedData['division_id'], // Use the division_id from the request
        ]);

        return redirect()->route('documents.index')->with('success', 'Document created successfully.');
    }






    public function update(Request $request, Document $document)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|file',
            'document_status_id' => 'required|exists:document_status,id',
            'document_creation_date' => 'required|date',
            'division_id' => 'required|exists:divisions,id',
            'subsection_id' => 'required|exists:subsections,id',
            'classification_code_id' => 'required|exists:classification_codes,id',
            'person_in_charge_id' => 'nullable|exists:persons_in_charge,id',
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
            $validatedData['file_path'] = $filePath;
        } else {
            $validatedData['file_path'] = $document->file_path;
        }

        $document->update($validatedData);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy(Document $document)
    {
        Storage::delete($document->file_path);
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document deleted successfully.');
    }

    public function preview($filename)
    {
        $filePath = storage_path('app/public/documents/' . $filename);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->file($filePath);
    }

    public function download($filename)
    {
        $filePath = storage_path('app/public/documents/' . $filename);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath);
    }
}
