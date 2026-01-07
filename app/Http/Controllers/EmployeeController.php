<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data departemen
        $departments = \App\Models\Department::all(); 

        // 2. Query karyawan
        $query = \App\Models\Employee::with(['department', 'position']);

        // ... (logika filter lainnya)

        $employees = $query->latest()->paginate(12);

        // 3. PASTIKAN 'departments' ada di dalam compact()
        return view('welcome', compact('employees', 'departments'));
    }

    public function show(Employee $employee)
    {
        // Cek apakah user yang login memiliki data employee ini
        // Kita membandingkan ID user yang login dengan user_id di tabel employees
        if (Auth::user()->id !== $employee->user_id) {
            // Jika tidak cocok, lempar error 403 (Forbidden)
            abort(403, 'Maaf, Anda hanya diperbolehkan melihat profil Anda sendiri.');
        }

        return view('employees.show', compact('employee'));
    }
}