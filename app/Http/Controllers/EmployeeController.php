<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Import Validator
use Illuminate\Support\Facades\DB; // memanggil Facade DB

class EmployeeController extends Controller
{
    public function index()
    {
        $pageTitle = 'Employee List';

        // RAW SQL QUERY
        // $employees = DB::select('
        //     select *, employees.id as employee_id, positions.name as position_name
        //     from employees
        //     left join positions on employees.position_id = positions.id
        // ');

        // QUERY BUILDER
        $employees = DB::table('employees')
        ->select('*', 'employees.id as employee_id', 'positions.name as position_name')
        ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
        ->get();

        return view('employee.index', [
            'pageTitle' => $pageTitle,
            'employees' => $employees
        ]);
    }

    public function create()
    {
        $pageTitle = 'Create Employee';
        // RAW SQL Query
        // $positions = DB::select('select * from positions');

        // QUERY BUILDER
        $positions = DB::table('positions')->get();

        return view('employee.create', compact('pageTitle', 'positions'));
    }

    public function show(string $id)
    {
        $pageTitle = 'Employee Detail';

        // RAW SQL QUERY
        // $employee = collect(DB::select('
        //     select *, employees.id as employee_id, positions.name as position_name
        //     from employees
        //     left join positions on employees.position_id = positions.id
        //     where employees.id = ?
        // ', [$id]))->first();

        // QUERY BUILDER
        $employee = DB::table('employees')
            ->select('*', 'employees.id as employee_id', 'positions.name as position_name')
            ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
            ->where('employees.id', $id)
            ->first();

        return view('employee.show', compact('pageTitle', 'employee'));
    }

    public function destroy(string $id)
    {
        // QUERY BUILDER
        DB::table('employees')
            ->where('id', $id)
            ->delete();

        return redirect()->route('employees.index');
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka'
        ];

        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proses penyimpanan data ke dalam database bisa dilakukan di sini

        // Redirect ke halaman employee list
        return redirect()->route('employees.index')->with('success', 'Employee data has been saved successfully.');
    }

    // edit
    public function edit(string $id)
    {
        $pageTitle = 'Edit Employee';

        $employee = DB::table('employees')
            ->where('id', $id)
            ->first();

        $positions = DB::table('positions')->get();

        return view('employee.edit', compact('pageTitle', 'employee', 'positions'));
    }

    // update
    public function update(Request $request, string $id)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka'
        ];

        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('employees')
            ->where('id', $id)
            ->update([
                'firstname' => $request->firstName,
                'lastname' => $request->lastName,
                'email' => $request->email,
                'age' => $request->age,
                'position_id' => $request->position,
            ]);

        return redirect()->route('employees.index');
    }
}


