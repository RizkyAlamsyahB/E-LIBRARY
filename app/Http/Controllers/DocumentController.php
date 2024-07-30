<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Division;
use App\Models\Document;
use App\Models\Subsection;
use Illuminate\Http\Request;
use App\Models\DocumentStatus;
use App\Models\PersonInCharge;
use Yajra\DataTables\DataTables;
use App\Models\ClassificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $data = Document::with([
                'classificationCode',
                'personInCharge',
                'documentStatus',
                'uploader',
            ])->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    return $row->title ?? 'N/A';
                })
                ->addColumn('combinedInfo', function ($row) {
                    $documentNumber = $row->number ?? 'N/A';
                    $classificationCode = $row->classificationCode->name ?? 'N/A';
                    $personInCharge = $row->personInCharge->name ?? 'N/A';
                    $creationDate = $row->document_creation_date ? Carbon::parse($row->document_creation_date)->format('m-Y') : 'N/A';

                    return "{$documentNumber} / {$classificationCode} / {$personInCharge} / {$creationDate}";
                })
                ->addColumn('documentStatus', function ($row) {
                    return $row->documentStatus->status ?? 'N/A';
                })
                ->addColumn('uploaderName', function ($row) {
                    return $row->uploader->name ?? 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('documents.edit', $row->id);
                    $deleteUrl = route('documents.destroy', $row->id);
                    $previewUrl = route('documents.preview', basename($row->file_path));
                    $downloadUrl = route('documents.download', basename($row->file_path));
                    $detailsUrl = route('documents.show', $row->id);

                    // Check if the user is an admin or the owner
                    $canDelete = auth()->user()->role === 'admin' || auth()->user()->id === $row->uploaded_by;

                    return '
<div class="dropdown dropup">
    <button class="btn btn-secondary dropdown-toggle btn-sm mt-2 mb-2" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
         <li><a href="#" class="dropdown-item btn-view-details" data-id="' . $row->id . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail Dokumen">
            <i class="bi bi-info-circle"></i> Detail
        </a></li>

    <li><a href="' . $previewUrl . '" class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Preview" target="_blank">
            <i class="bi bi-eye"></i> Preview
        </a></li>
        <li><a href="' . $downloadUrl . '" class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Download">
            <i class="bi bi-download"></i> Download
        </a></li>
        ' . ($canDelete ? '
        <li><a href="' . $editUrl . '" class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
            <i class="bi bi-pencil"></i> Edit
        </a></li>

        <li><button type="button" class="dropdown-item btn-delete" data-id="' . $row->id . '" data-title="' . $row->title . '" data-url="' . $deleteUrl . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
            <i class="bi bi-trash"></i> Delete
        </button></li>
        ' : '') . '
    </ul>
</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.documents.index'); // Adjust the view path as needed
    }




    public function create()
    {
        // Ambil data dari database
        $personsInCharge = PersonInCharge::all();
        $documentStatuses = DocumentStatus::all();
        $classificationCodes = ClassificationCode::all();
        $divisions = Division::all();
        $subsections = Subsection::all();

        // Ambil data pengguna yang sedang login
        $user = auth()->user();
        $userDivision = $user->division; // Asumsi bahwa user memiliki relasi `division`
        $userSubsections = $user->subsections; // Asumsi bahwa user memiliki relasi `subsections`

        // Cek apakah semua data relasi ada
        $allDataAvailable = [
            'Kode Klasifikasi' => $classificationCodes->count() > 0,
            'Sifat Dokumen' => $documentStatuses->count() > 0,
            'PIC (Person In Charge)' => $personsInCharge->count() > 0,
            'Divisi' => $userDivision !== null,
            'Sub Bagian' => $userSubsections->count() > 0
        ];

        foreach ($allDataAvailable as $key => $value) {
            if (!$value) {
                // Redirect ke halaman dokumen dengan pesan error jika data tidak ada
                return redirect()->route('documents.index')
                    ->with('error', "Belum ada $key. Pastikan semua data terkait tersedia sebelum membuat dokumen.");
            }
        }

        // Pass data ke view
        return view('admin.pages.documents.create', compact('documentStatuses', 'personsInCharge', 'classificationCodes', 'divisions', 'subsections'));
    }

    public function store(Request $request)
    {
        // Validasi input dari pengguna
        $validatedData = $request->validate([
            'number' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240000',
            'document_creation_date' => 'required|date_format:d-m-Y', // Validasi format d-m-Y
            'person_in_charge_id' => 'required|exists:persons_in_charge,id',
            'document_status_id' => 'nullable|exists:document_status,id',
            'classification_code_id' => 'nullable|exists:classification_codes,id',
        ]);

        // Konversi format tanggal dari d-m-Y ke Y-m-d
        $documentCreationDate = \Carbon\Carbon::createFromFormat('d-m-Y', $validatedData['document_creation_date'])->format('Y-m-d');

        // Handle file upload
        $file = $request->file('file');
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Get the original file name without extension
        $extension = $file->getClientOriginalExtension(); // Get the file extension

        // Generate a unique filename
        $filename = $originalFilename . '.' . $extension;
        $filePath = 'documents/' . $filename;

        // Check if the file already exists and modify filename if necessary
        $counter = 1;
        while (Storage::disk('public')->exists($filePath)) {
            $filename = $originalFilename . '(' . $counter . ').' . $extension;
            $filePath = 'documents/' . $filename;
            $counter++;
        }

        $path = $file->storeAs('documents', $filename, 'public'); // Store file with unique name

        // Get current user
        $user = auth()->user();

        // Retrieve the user's subsections and choose the first one or null if none exist
        $subsectionId = $user->subsections->first()->id ?? null;

        // Create a new document record
        $document = Document::create([
            'number' => $validatedData['number'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'file_path' => $path,
            'original_file_name' => $filename,
            'document_creation_date' => $documentCreationDate, // Simpan dengan format Y-m-d
            'uploaded_by' => $user->id,
            'person_in_charge_id' => $validatedData['person_in_charge_id'],
            'document_status_id' => $validatedData['document_status_id'],
            'classification_code_id' => $validatedData['classification_code_id'],
            'subsection_id' => $subsectionId,
        ]);

        return redirect()->route('documents.index')->with('success', 'Document created successfully.');
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


    public function show($id)
    {
        $document = Document::with([
            'classificationCode',
            'personInCharge',
            'uploader.division', // Memuat relasi division dari uploader
            'subsection',
            'documentStatus',
        ])->findOrFail($id);

        return response()->json([
            'title' => $document->title,
            'number' => $document->number,
            'classification' => $document->classificationCode->name ?? 'N/A',
            'personInCharge' => $document->personInCharge->name ?? 'N/A',
            'status' => $document->documentStatus->status ?? 'N/A',
            'uploader' => $document->uploader->name ?? 'N/A',
            'createdAt' => $document->created_at->format('d-m-Y'),
            'documentCreationDate' => $document->document_creation_date
                ? Carbon::parse($document->document_creation_date)->format('m-Y')
                : 'N/A',
            'description' => $document->description ?? 'N/A',
            'division' => $document->uploader->division->name ?? 'N/A', // Pastikan ada relasi `division` pada model `Uploader`
            'subsection' => $document->subsection->name ?? 'N/A', // Pastikan ada field `name` di model `Subsection`
        ]);
    }

    public function update(Request $request, Document $document)
    {
        // Validasi input dari pengguna
        $validatedData = $request->validate([
            'number' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file', // File bersifat opsional
            'document_status_id' => 'required|exists:document_status,id',
            'document_creation_date' => 'required|date_format:Y-m-d', // Validasi format tanggal
            'classification_code_id' => 'required|exists:classification_codes,id',
            'person_in_charge_id' => 'nullable|exists:persons_in_charge,id',
        ]);

        // Konversi format tanggal dari Y-m-d ke Y-m-d (tidak perlu jika format sudah sesuai)
        $documentCreationDate = \Carbon\Carbon::createFromFormat('Y-m-d', $validatedData['document_creation_date'])->format('Y-m-d');

        // Handle file upload jika ada file baru
        if ($request->hasFile('file')) {
            // Hapus file lama jika perlu
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Unggah file baru
            $file = $request->file('file');
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Dapatkan nama file tanpa ekstensi
            $extension = $file->getClientOriginalExtension(); // Dapatkan ekstensi file

            // Generate nama file unik
            $filename = $originalFilename . '.' . $extension;
            $filePath = 'documents/' . $filename;

            // Cek jika file dengan nama yang sama sudah ada dan modifikasi nama jika perlu
            $counter = 1;
            while (Storage::disk('public')->exists($filePath)) {
                $filename = $originalFilename . '(' . $counter . ').' . $extension;
                $filePath = 'documents/' . $filename;
                $counter++;
            }

            $path = $file->storeAs('documents', $filename, 'public'); // Simpan file dengan nama unik

            $validatedData['file_path'] = $path; // Simpan path file yang baru
            $validatedData['original_file_name'] = $filename; // Simpan nama file asli yang baru
        } else {
            // Jika tidak ada file baru, tetap gunakan file yang lama
            $validatedData['file_path'] = $document->file_path;
            $validatedData['original_file_name'] = $document->original_file_name; // Simpan nama file asli yang lama
        }

        // Perbarui dokumen dengan data yang divalidasi
        $document->update(array_merge($validatedData, [
            'document_creation_date' => $documentCreationDate,
        ]));

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui!');
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
