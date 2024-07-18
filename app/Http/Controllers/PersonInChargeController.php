<?php

namespace App\Http\Controllers;

use App\Models\PersonInCharge;
use Illuminate\Http\Request;

class PersonInChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personsInCharge = PersonInCharge::all();
        return view('admin.pages.persons-in-charge.index', compact('personsInCharge'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.persons-in-charge.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        return view('person_in_charge.show', compact('personInCharge'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonInCharge $personInCharge)
    {
        return view('admin.pages.persons-in-charge.edit', compact('personInCharge'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonInCharge $personInCharge)
    {
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
        $personInCharge->delete();

        return redirect()->route('person_in_charge.index')
                         ->with('success', 'Person In Charge deleted successfully.');
    }
}
