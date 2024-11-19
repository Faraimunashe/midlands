<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Exception;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $departments = Department::paginate(20);
        if(isset($search))
        {
            $departments = Department::where('name', 'like', '%'.$search.'%')
                ->paginate(20);
        }
        return inertia('Admin/DepartmentsPage', [
            'departments' => $departments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Department/CreatePage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250|unique:departments,name',
        ]);

        try {
            Department::create([
                'name' => $request->name
            ]);

            return back()->with(['success' => 'Department created successfully']);
        }catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $department = Department::find($id);
        return inertia('Admin/Department/UpdatePage', [
            'department' => $department
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:250|unique:departments,name',
        ]);

        try {
            Department::find($id)->update([
                'name' => $request->name
            ]);

            return back()->with(['success' => 'Department updated successfully']);
        }catch (Exception $e) {
            return back()->withErrors(['error' => 'An error occured please try again later!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{

            $department = Department::findOrFail($id);
            $department->delete();

            return back()->withErrors(['success' => 'Department deleted successfully.']);
        }catch(Exception $e)
        {
            return back()->withErrors(['error' => 'An error occured please try again later.']);
        }
    }
}
