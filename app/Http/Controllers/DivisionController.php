<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Subsection;
use Illuminate\Http\Request;

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
        $divisions = Division::with('subsections')->get(); // Mengambil semua divisi dengan subsections
        return view('admin.pages.divisions.index', compact('divisions'));
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
