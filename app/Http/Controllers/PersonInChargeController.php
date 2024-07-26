<?php

namespace App\Http\Controllers;

use App\Models\PersonInCharge;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class PersonInChargeController extends Controller
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
            $data = PersonInCharge::query(); // Use query() for better performance
            return DataTables::of($data)
                ->addIndexColumn() // This adds the DT_RowIndex column
                ->addColumn('action', function ($row) {
                    $editUrl = route('person_in_charge.edit', $row->id);
                    $deleteUrl = route('person_in_charge.destroy', $row->id);

                    return '
                    <a href="' . $editUrl . '" class="btn btn-warning btn-sm me-2 mt-2 mb-2 btn-hover-warning" data-toggle="tooltip" data-placement="top" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm mt-2 mb-2 btn-hover-danger" data-bs-toggle="modal" data-bs-target="#deleteModal' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.persons-in-charge.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.pages.persons-in-charge.create');
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
            'name' => 'required|string|max:255',
        ]);

        PersonInCharge::create($request->all());

        return redirect()->route('person_in_charge.index')
            ->with('success', 'Person In Charge created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonInCharge $personInCharge)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return view('person_in_charge.show', compact('personInCharge'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonInCharge $personInCharge)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.pages.persons-in-charge.edit', compact('personInCharge'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonInCharge $personInCharge)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $personInCharge->update($request->all());

        return redirect()->route('person_in_charge.index')
            ->with('success', 'Person In Charge updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonInCharge $personInCharge)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $personInCharge->delete();

        return redirect()->route('person_in_charge.index')
            ->with('success', 'Person In Charge deleted successfully.');
    }
}
