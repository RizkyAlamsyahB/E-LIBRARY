<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Subsection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;

class DivisionController extends Controller
{
    public function getSubsections($divisionId)
    {
        $subsections = Subsection::whereHas('divisions', function ($query) use ($divisionId) {
            $query->where('division_id', $divisionId);
        })->get();

        return response()->json($subsections);
    }

    public function index()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $data = Division::with('subsections');


            return DataTables::of($data)
                ->addIndexColumn() // Adds the DT_RowIndex column
                ->addColumn('subsections', function ($row) {
                    return $row->subsections->pluck('name')->map(function ($name) {
                        return '<span class="badge bg-secondary">' . $name . '</span>';
                    })->implode(' ');
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('divisions.edit', $row->id);
                    $deleteUrl = route('divisions.destroy', $row->id);

                    return '
                <div class="dropdown dropup">
                    <button class="btn btn-secondary dropdown-toggle btn-sm mt-2 mb-2 me-2" type="button" id="dropdownMenuButton-' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row->id . '">
                        <li><a href="' . $editUrl . '" class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="bi bi-pencil"></i> Edit
                        </a></li>
                        <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-placement="top" title="Delete" data-bs-target="#deleteModal' . $row->id . '" data-id="' . $row->id . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                            <i class="bi bi-trash"></i> Delete
                        </button></li>
                    </ul>
                </div>';
                })
                ->rawColumns(['subsections', 'action'])
                ->make(true);
        }

        $divisions = Division::all(); // Pass all divisions to the view

        return view('admin.pages.divisions.index', compact('divisions'));
    }

    public function create()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $subsections = Subsection::all(); // Ambil semua subsections
        return view('admin.pages.divisions.create', compact('subsections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subsections' => 'required|array',
        ]);

        $division = Division::create([
            'name' => $request->name,
        ]);

        $division->subsections()->attach($request->subsections);


        return redirect()->route('divisions.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit(Division $division)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $subsections = Subsection::all(); // Ambil semua subsections

        $selectedSubsections = $division->subsections->pluck('id')->toArray(); // Ambil ID subsections yang sudah dipilih

        return view('admin.pages.divisions.edit', compact('division', 'subsections', 'selectedSubsections'));
    }

    public function update(Request $request, Division $division)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subsections' => 'nullable|array',
        ]);

        $division->update([
            'name' => $request->name,
        ]);

        $division->subsections()->sync($request->subsections);



        return redirect()->route('divisions.index')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy(Division $division)
    {
        $division->subsections()->detach();
        $division->delete();



        return redirect()->route('divisions.index')->with('success', 'Jabatan berhasil dihapus.');
    }
}
