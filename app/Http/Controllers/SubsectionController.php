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
                    <a href="' . $editUrl . '" class="btn btn-warning btn-sm me-2 mt-2 mb-2 btn-hover-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm mt-2 mb-2 btn-hover-danger btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-id="' . $row->id . '" data-name="' . $row->name . '" data-url="' . $deleteUrl . '">
                        <i class="bi bi-trash"></i>
                    </button>
                    ';
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

        return redirect()->route('subsections.index')->with('success', 'Subsection created successfully.');
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

        return redirect()->route('subsections.index')->with('success', 'Subsection updated successfully.');
    }

    public function destroy(Subsection $subsection)
    {
        $subsection->delete();

        return redirect()->route('subsections.index')->with('success', 'Subsection deleted successfully.');
    }
}
