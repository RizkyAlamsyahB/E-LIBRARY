<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Subsection;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DivisionController extends Controller
{
    // public function __construct()
    // {
    //     // Menambahkan pengecekan hak akses
    //     $this->middleware(function ($request, $next) {
    //         if (auth()->check() && auth()->user()->role !== 'admin') {
    //             abort(403, 'Unauthorized action.');
    //         }
    //         return $next($request);
    //     });
    // }
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
            $data = Division::with('subsections'); // Use eager loading for subsections

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
                    <a href="' . $editUrl . '" class="btn btn-warning btn-sm me-2 mt-2 mb-2 btn-hover-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm mt-2 mb-2 btn-hover-danger" data-bs-toggle="modal" data-bs-target="#deleteModal' . $row->id . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                ';
                })
                ->rawColumns(['subsections', 'action'])
                ->make(true);
        }

        return view('admin.pages.divisions.index');
    }

    public function create()
    {
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

        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil dibuat.');
    }

    public function edit(Division $division)
    {
        $subsections = Subsection::all(); // Ambil semua subsections
        $selectedSubsections = $division->subsections->pluck('id')->toArray(); // Ambil ID subsections yang sudah dipilih

        return view('admin.pages.divisions.edit', compact('division', 'subsections', 'selectedSubsections'));
    }


    public function update(Request $request, Division $division)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subsections' => 'required|array',
        ]);

        $division->update([
            'name' => $request->name,
        ]);

        $division->subsections()->sync($request->subsections);

        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy(Division $division)
    {
        $division->subsections()->detach();
        $division->delete();

        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil dihapus.');
    }
}
