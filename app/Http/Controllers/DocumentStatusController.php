<?php

namespace App\Http\Controllers;

use App\Models\DocumentStatus;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DocumentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            // Menggunakan cache untuk data DocumentStatus
            $data = Cache::remember('document_statuses', 60, function () {
                return DocumentStatus::query()->get();
            });

            // Menangani pengurutan berdasarkan parameter yang diterima dari DataTables
            $query = DocumentStatus::query();
            $query->when(request()->has('order'), function ($q) {
                $orderColumnIndex = request()->input('order.0.column');
                $orderDirection = request()->input('order.0.dir');

                // Kolom yang valid untuk pengurutan
                $columns = [
                    1 => 'status', // Sesuaikan index dengan kolom yang valid
                ];

                $columnName = $columns[$orderColumnIndex] ?? 'status'; // Default ke 'status' jika tidak ditemukan
                $q->orderBy($columnName, $orderDirection);
            });

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('document_status.edit', $row->id);
                    $deleteUrl = route('document_status.destroy', $row->id);

                    return '
                <div class="dropdown dropup">
                    <button class="btn btn-secondary dropdown-toggle btn-sm mt-2 mb-2 me-2" type="button" id="dropdownMenuButton-' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row->id . '">
                        <li><a href="' . $editUrl . '" class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="bi bi-pencil"></i> Edit
                        </a></li>
                        <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-id="' . $row->id . '" data-title="' . $row->status . '">
                            <i class="bi bi-trash"></i> Delete
                        </button></li>
                    </ul>
                </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.documents-status.index'); // Adjust the view path as needed
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.pages.documents-status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        DocumentStatus::create($request->all());

        // Hapus cache DocumentStatus
        Cache::forget('document_statuses');

        return redirect()->route('document_status.index')
            ->with('success', 'Sifat Dokumen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentStatus $documentStatus)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return view('document_status.show', compact('documentStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentStatus $documentStatus)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.pages.documents-status.edit', compact('documentStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentStatus $documentStatus)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $documentStatus->update($request->all());

        // Hapus cache DocumentStatus
        Cache::forget('document_statuses');

        return redirect()->route('document_status.index')
            ->with('success', 'Sifat Dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentStatus $documentStatus)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $documentStatus->delete();

        // Hapus cache DocumentStatus
        Cache::forget('document_statuses');

        return redirect()->route('document_status.index')
            ->with('success', 'Sifat Dokumen berhasil dihapus.');
    }
}
