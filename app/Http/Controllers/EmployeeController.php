<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\Document;
use App\Models\Subsection;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class EmployeeController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $data = User::with(['division', 'subsections'])->get();

            return DataTables::of($data)
                ->addIndexColumn() // Adds the DT_RowIndex column
                ->addColumn('subsections', function ($row) {
                    return $row->subsections->pluck('name')->implode(', ');
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('employees.edit', $row->id);
                    $deleteUrl = route('employees.destroy', $row->id);

                    return '
                <div class="dropdown dropup">
                    <button class="btn btn-secondary dropdown-toggle btn-sm mt-2 mb-2 ms-2 me-2" type="button" id="dropdownMenuButton-' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row->id . '">
                        <li><a href="' . $editUrl . '" class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                            <i class="bi bi-pencil"></i> Edit
                        </a></li>
                        <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteModal"  data-bs-placement="top" title="Delete" data-id="' . $row->id . '" data-name="' . $row->name . '">
                            <i class="bi bi-trash"></i> Delete
                        </button></li>
                    </ul>
                </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.employees.index');
    }



    public function create()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $divisions = Division::all();
        $subsections = Subsection::all(); // Ambil semua subsections

        return view('admin.pages.employees.create', compact('divisions', 'subsections'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'role' => 'required|in:user,admin',
            'division_id' => 'required|exists:divisions,id',
            'subsections' => 'required|array',
            'subsections.*' => 'exists:subsections,id',
        ]);

        // Simpan data user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'role' => $request->role,
            'division_id' => $request->division_id,
        ]);

        // Hubungkan subsections dengan user
        $user->subsections()->sync($request->subsections);

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil ditambahkan.');

    }


    public function show(User $employee)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.pages.employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $divisions = Division::all();
        return view('admin.pages.employees.edit', compact('employee', 'divisions'));
    }

    public function update(Request $request, $id)
    {
        // Cek apakah pengguna yang sedang login adalah admin
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|confirmed|min:8',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'role' => 'required|in:user,admin',
            'division_id' => 'required|exists:divisions,id',
            'subsections' => 'required|array',
            'subsections.*' => 'exists:subsections,id',
        ]);

        // Temukan karyawan berdasarkan ID
        $employee = User::findOrFail($id);

        // Update data karyawan
        $employee->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'gender' => $validatedData['gender'],
            'role' => $validatedData['role'],
            'division_id' => $validatedData['division_id'],
            // Update password jika ada input password
            'password' => !empty($validatedData['password']) ? bcrypt($validatedData['password']) : $employee->password,
        ]);

        // Sinkronkan subsections
        $employee->subsections()->sync($validatedData['subsections']);

        // Update subsection_id pada dokumen yang diunggah oleh pengguna ini
        Document::where('uploaded_by', $employee->id)
            ->update(['subsection_id' => $validatedData['subsections'][0] ?? null]); // Pilih subseksi pertama atau null jika tidak ada subseksi

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil diperbarui.');

    }



    public function destroy(User $employee)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Delete the photo if exists
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil dihapus.');

    }

    public function getSubsectionsByDivision(Request $request)
    {
        if ($request->ajax()) {
            $divisionId = $request->input('division_id');
            $subsections = Subsection::whereHas('divisions', function ($query) use ($divisionId) {
                $query->where('division_id', $divisionId);
            })->get();

            return response()->json($subsections);
        }
    }
}
