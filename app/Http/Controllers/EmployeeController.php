<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::all();
        $employees = User::paginate(10);
        $employees = User::with('division')->get();

        return view('admin.pages.employees.index' , compact('employees'));
    }

    public function create()
    {
        $divisions = Division::all();
        return view('admin.pages.employees.create', compact('divisions'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
       'division_id' => 'required|exists:divisions,id',
        'role' => 'required|in:user,admin',
        'marital_status' => 'required|in:single,married',
        'date_of_birth' => 'required|date',
        'phone' => 'nullable|string|max:255',
        'address' => 'nullable|string',
        'gender' => 'nullable|in:male,female,other',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png',
    ]);

    // Hash the password before saving
    $validatedData['password'] = Hash::make($validatedData['password']);

    // Handle the photo upload if there is one
    if ($request->hasFile('photo')) {
        $validatedData['photo'] = $request->file('photo')->store('profile_photos', 'public');
    }

    User::create($validatedData);

    return Redirect::route('employees.index')->with('success', 'Employee created successfully.');
}


    public function show(User $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
         $divisions = Division::all();
        return view('admin.pages.employees.edit', compact('employee', 'divisions'))->with('success', 'Employee updated successfully.');
    }

    public function update(Request $request, User $employee)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $employee->id,
        'password' => 'nullable|string|min:8|confirmed',
       'division_id' => 'required|exists:divisions,id',
        'role' => 'required|string',
        'marital_status' => 'required|string',
        'date_of_birth' => 'required|date',
        'phone' => 'nullable|string|max:255',
        'address' => 'nullable|string',
        'gender' => 'nullable|string',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png',
    ]);

    if ($request->filled('password')) {
        $validatedData['password'] = bcrypt($validatedData['password']);
    } else {
        unset($validatedData['password']);
    }

    if ($request->hasFile('photo')) {
        // Hapus foto lama jika ada
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }
        // Simpan foto baru dan simpan jalur relatif ke database
        $validatedData['photo'] = $request->file('photo')->store('profile_photos', 'public');
    }

    $employee->update($validatedData);

    return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
}


    public function destroy(User $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }


}
