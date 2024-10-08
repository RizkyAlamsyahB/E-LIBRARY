<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonInCharge;

use Yajra\DataTables\Facades\DataTables;

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
            // Menggunakan cache untuk data PersonInCharge
            $data = PersonInCharge::query();

            return DataTables::of($data)
                ->addIndexColumn() // This adds the DT_RowIndex column
                ->addColumn('action', function ($row) {
                    $editUrl = route('person_in_charge.edit', $row->id);
                    $deleteUrl = route('person_in_charge.destroy', $row->id);

                    return '
                <div class="dropdown dropup">
                    <button class="btn btn-secondary dropdown-toggle btn-sm mt-2 mb-2 me-2" type="button" id="dropdownMenuButton-' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row->id . '">
                        <li><a href="' . $editUrl . '" class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="bi bi-pencil"></i> Edit
                        </a></li>
                        <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-placement="top" title="Delete"  data-bs-target="#deleteModal' . $row->id . '" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-id="' . $row->id . '" data-name="' . $row->name . '" data-url="' . $deleteUrl . '">
                            <i class="bi bi-trash"></i> Delete
                        </button></li>
                    </ul>
                </div>';
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
            ->with('success', 'Penanggung Jawab berhasil ditambahkan.');
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
            ->with('success', 'Penanggung Jawab berhasil diperbarui.');
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
            ->with('success', 'Penanggung Jawab berhasil dihapus.');
    }
}
