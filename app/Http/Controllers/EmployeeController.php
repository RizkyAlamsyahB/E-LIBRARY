<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\Subsection;
use Illuminate\Http\Request;
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

        $employees = User::with(['division', 'userSubsections'])->get();

        return view('admin.pages.employees.index', compact('employees'));
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
        $user->userSubsections()->sync($request->subsections);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully');
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
        $employee->name = $validatedData['name'];
        $employee->email = $validatedData['email'];

        // Update password jika ada input password
        if (!empty($validatedData['password'])) {
            $employee->password = bcrypt($validatedData['password']);
        }

        $employee->phone = $validatedData['phone'];
        $employee->date_of_birth = $validatedData['date_of_birth'];
        $employee->gender = $validatedData['gender'];
        $employee->role = $validatedData['role'];
        $employee->division_id = $validatedData['division_id'];
        $employee->save();

        // Sinkronkan subsections
        $employee->userSubsections()->sync($validatedData['subsections']);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
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

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
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
