<?php

namespace App\Http\Controllers;

use App\Models\DocumentStatus;
use Illuminate\Http\Request;

class DocumentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentStatuses = DocumentStatus::all();
        return view('admin.pages.documents-status.index', compact('documentStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.documents-status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        return view('document_status.show', compact('documentStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentStatus $documentStatus)
    {
        return view('admin.pages.documents-status.edit', compact('documentStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentStatus $documentStatus)
    {
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
        $documentStatus->delete();

        return redirect()->route('document_status.index')
                         ->with('success', 'Document Status deleted successfully.');
    }
}
