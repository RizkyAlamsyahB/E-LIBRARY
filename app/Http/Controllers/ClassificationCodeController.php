<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ClassificationCode;

class ClassificationCodeController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $data = ClassificationCode::query();

            return DataTables::of($data)
                ->addIndexColumn() // Adds the DT_RowIndex column
                ->addColumn('action', function ($row) {
                    $editUrl = route('classification-codes.edit', $row->id);
                    $deleteUrl = route('classification-codes.destroy', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-warning btn-sm me-2 mt-2 mb-2 btn-hover-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm mt-2 mb-2 btn-hover-danger" data-bs-toggle="modal" data-bs-target="#deleteModal' . $row->id . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.classification_codes.index');
    }

    public function create()
    {
        return view('admin.pages.classification_codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ClassificationCode::create($request->all());

        return redirect()->route('classification-codes.index')->with('success', 'Classification Code created successfully.');
    }

    public function edit(ClassificationCode $classificationCode)
    {
        return view('admin.pages.classification_codes.edit', compact('classificationCode'));
    }

    public function update(Request $request, ClassificationCode $classificationCode)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $classificationCode->update($request->all());

        return redirect()->route('classification-codes.index')->with('success', 'Classification Code updated successfully.');
    }

    public function destroy(ClassificationCode $classificationCode)
    {
        $classificationCode->delete();

        return redirect()->route('classification-codes.index')->with('success', 'Classification Code deleted successfully.');
    }
}
