<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\DocumentStatus;

class DocumentStatusController extends Controller
{
    public function index()
    {
        $status = DocumentStatus::all();
        return view('admin.pages.documents-status.index', compact('status'));
    }

    public function create()
    {
        return view('admin.pages.documents-status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        DocumentStatus::create($request->all());

        return redirect()->route('documents-status.index')->with('success', 'Document status created successfully.');
    }

    public function edit(DocumentStatus $documentStatus)
    {
        return view('admin.pages.documents-status.edit', compact('documentStatus'));
    }

    public function update(Request $request, DocumentStatus $documentStatus)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $documentStatus->update($request->all());

        return redirect()->route('documents-status.update')->with('success', 'Document status updated successfully.');
    }

    public function destroy(DocumentStatus $documentStatus)
    {
        $documentStatus->delete();

        return redirect()->route('documents-status.destroy')->with('success', 'Document status deleted successfully.');
    }
}
