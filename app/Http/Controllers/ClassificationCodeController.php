<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ClassificationCode;
use Illuminate\Support\Facades\Cache;

class ClassificationCodeController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            // Menggunakan cache untuk data DocumentStatus
            $data = Cache::remember('classification_codes', 60, function () {
                return ClassificationCode::query()->get();
            });

            return DataTables::of($data)
                ->addIndexColumn() // Automatically adds DT_RowIndex column for indexing
                ->addColumn('action', function ($row) {
                    $editUrl = route('classification-codes.edit', $row->id);
                    $deleteUrl = route('classification-codes.destroy', $row->id);

                    return '
            <div class="dropdown dropup">
                <button class="btn btn-secondary dropdown-toggle btn-sm mt-2 mb-2 me-2" type="button" id="dropdownMenuButton-' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row->id . '">
                    <li><a href="' . $editUrl . '" class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                        <i class="bi bi-pencil"></i> Edit
                    </a></li>
                    <li><button type="button" class="dropdown-item" data-bs-toggle="modal"  data-bs-placement="top" title="Delete" data-bs-target="#deleteModal' . $row->id . '" data-id="' . $row->id . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                        <i class="bi bi-trash"></i> Delete
                    </button></li>
                </ul>
            </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Pass all classification codes to the view
        $classificationCodes = ClassificationCode::all();

        return view('admin.pages.classification_codes.index', compact('classificationCodes'));
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
        // Hapus cache ClassificationCode
        Cache::forget('classification_codes');


        return redirect()->route('classification-codes.index')->with('success', 'Kode Klasifikasi berhasil ditambahkan.');
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
        // Hapus cache ClassificationCode
        Cache::forget('classification_codes');


        return redirect()->route('classification-codes.index')->with('success', 'Kode Klasifikasi berhasil diperbarui.');
    }

    public function destroy(ClassificationCode $classificationCode)
    {
        $classificationCode->delete();
        // Hapus cache ClassificationCode
        Cache::forget('classification_codes');


        return redirect()->route('classification-codes.index')->with('success', 'Kode Klasifikasi berhasil dihapus.');
    }
}
