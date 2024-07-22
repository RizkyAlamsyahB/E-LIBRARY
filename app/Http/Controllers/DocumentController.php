<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\DocumentStatus;
use App\Models\PersonInCharge;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::all();

        return view('admin.pages.documents.index', compact('documents'));
    }

    public function create()
    {
        // Fetch all persons in charge and document statuses
        $personsInCharge = PersonInCharge::all();
        $documentStatuses = DocumentStatus::all();
        $code = $this->generateCode(); // Generate code for new document

        return view('admin.pages.documents.create', compact('personsInCharge', 'documentStatuses', 'code'));
    }

    public function edit(Document $document)
    {
        // Fetch all persons in charge and document statuses
        $personsInCharge = PersonInCharge::all();
        $documentStatuses = DocumentStatus::all();
        $code = $document->code; // Use existing document code

        return view('admin.pages.documents.edit', compact('document', 'personsInCharge', 'documentStatuses', 'code'));
    }
    private function generateCode()
    {
        $latestDocument = Document::latest('id')->first();
        $latestCode = $latestDocument ? intval(substr($latestDocument->code, 4)) : 0;
        $newCode = str_pad($latestCode + 1, 2, '0', STR_PAD_LEFT);
        return 'DOC-' . $newCode;
    }
    public function show(Request $request, $id)
    {
        // Validasi ID jika diperlukan
        $request->validate([
            'id' => 'required|integer|exists:documents,id',
        ]);

        // Temukan dokumen berdasarkan ID
        $document = Document::findOrFail($id);

        // Kembalikan view dengan data dokumen
        return view('documents.show', compact('document'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'file' => 'required|file',
            'status_id' => 'required|exists:document_status,id',
            'year' => 'required|date',
            'person_in_charge_id' => 'nullable|exists:persons_in_charge,id',
        ]);

        // Handle file upload
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $path = $file->storeAs('documents', $filename, 'public');

        // Create new document
        Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'uploaded_by' => auth()->id(),
            'person_in_charge_id' => $request->person_in_charge_id,
            'document_status_id' => $request->status_id,
            'year' => $request->year,
            'code' => $this->generateCode(), // Generate code for new document
        ]);

        return redirect()->route('documents.index')->with('success', 'Document created successfully.');
    }

    public function update(Request $request, $id)
    {
        $document = Document::find($id);

        if (!$document) {
            return redirect()->route('documents.index')->with('error', 'Dokumen tidak ditemukan.');
        }

        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'document_status_id' => 'required|exists:document_status,id',
            'year' => 'required|date_format:Y-m-d',
            'person_in_charge_id' => 'nullable|exists:persons_in_charge,id',
            'file' => 'nullable|file|max:8192', // Sesuaikan dengan batas ukuran file yang Anda inginkan
        ]);

        // Update data
        $document->title = $validatedData['title'];
        $document->description = $validatedData['description'];
        $document->document_status_id = $validatedData['document_status_id'];
        $document->year = $validatedData['year'];
        $document->person_in_charge_id = $validatedData['person_in_charge_id'];

        // Proses upload file jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
            $document->file_path = $filePath;
        }

        $document->save();

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui.');
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
