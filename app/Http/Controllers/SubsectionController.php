<?php

namespace App\Http\Controllers;

use App\Models\Subsection;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class SubsectionController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            $data = Subsection::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('subsections.edit', $row->id);
                    $deleteUrl = route('subsections.destroy', $row->id);

                    return '
                <div class="dropdown dropup">
                    <button class="btn btn-secondary dropdown-toggle btn-sm mt-2 mb-2 me-2" type="button" id="dropdownMenuButton-' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row->id . '">
                        <li><a href="' . $editUrl . '" class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="bi bi-pencil"></i> Edit
                        </a></li>
                        <li><button type="button" class="dropdown-item btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-id="' . $row->id . '" data-name="' . $row->name . '" data-url="' . $deleteUrl . '">
                            <i class="bi bi-trash"></i> Delete
                        </button></li>
                    </ul>
                </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.subsections.index');
    }


    public function create()
    {
        return view('admin.pages.subsections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Subsection::create($request->all());



        return redirect()->route('subsections.index')->with('success', 'Sub Bagian berhasil ditambahkan.');
    }

    public function edit(Subsection $subsection)
    {
        return view('admin.pages.subsections.edit', compact('subsection'));
    }

    public function update(Request $request, Subsection $subsection)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subsection->update($request->all());

        return redirect()->route('subsections.index')->with('success', 'Sub Bagian berhasil diperbarui.');
    }

    public function destroy(Subsection $subsection)
    {
        $subsection->delete();


        return redirect()->route('subsections.index')->with('success', 'Sub Bagian berhasil dihapus.');
    }
}
