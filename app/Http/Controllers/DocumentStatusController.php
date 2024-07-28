<?php

namespace App\Http\Controllers;

use App\Models\DocumentStatus;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

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
            $data = DocumentStatus::query();

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

        return view('admin.pages.documents-status.index');
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

        return redirect()->route('document_status.index')
            ->with('success', 'Document Status created successfully.');
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

        return redirect()->route('document_status.index')
            ->with('success', 'Document Status updated successfully.');
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

        return redirect()->route('document_status.index')
            ->with('success', 'Document Status deleted successfully.');
    }
}
