<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\EmployeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index()
    {
        return Employee::with('detail')->paginate(20);
    }

    public function store(StoreEmployeeRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $uuid = Str::uuid();

            $employee = Employee::create([
                'id' => $uuid,
                'name' => $request->name,
                'email' => $request->email,
                'department_id' => $request->department_id,
            ]);

            $employee->detail()->create([
                'employee_id' => $uuid,
                'designation' => $request->designation,
                'salary' => $request->salary,
                'address' => $request->address,
                'joined_date' => $request->joined_date,
            ]);

            return response()->json($employee->load('detail'), 201);
        });
    }

    public function show($id)
    {
        return Employee::with('detail')->findOrFail($id);
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $employee = Employee::findOrFail($id);
            $employee->update($request->only('name', 'email', 'department_id'));

            $employee->detail()->update($request->only('designation', 'salary', 'address', 'joined_date'));

            return response()->json($employee->load('detail'));
        });
    }

    public function destroy($id)
    {
        Employee::findOrFail($id)->delete();
        return response()->noContent();
    }
}
