<?php

namespace App\Http\Controllers;

use App\Models\Subsection;
use Illuminate\Http\Request;

class SubsectionController extends Controller
{
    public function index()
    {
        $subsections = Subsection::all();
        return view('admin.pages.subsections.index', compact('subsections'));
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
