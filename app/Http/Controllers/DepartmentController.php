<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $departments = Department::orderBy('created_at')->get();
        return view('pages.department.List')->with('departments',$departments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.department.Add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'department_name' => 'required',
            'department_description' => 'required',
            'status' =>'required',
        ]);
        $department = new Department();
        $department->name = $request->department_name;
        $department->key = strtolower(str_replace(' ', '', $request->department_name));
        $department->description = $request->department_description;
        $department->status = $request->status == 'active'? 1 : 0 ;
        $department->save();
        return redirect()->route('department.index');

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
        return view('pages.department.Add')->with('data',$department);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'department_name' => 'required',
            'department_description' => 'required',
            'status' =>'required',
        ]);
        $department = Department::find($id);
        $department->name = $request->department_name;
        $department->key = strtolower(str_replace(' ', '', $request->department_name));
        $department->description = $request->department_description;
        $department->status = $request->status == 'active'? 1 : 0 ;
        $department->save();
        return redirect()->route('department.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json([
                'code' => 404,
                'msg' => 'Department not found.'
            ]);
        }
        $relatedDoctors = $department->getDoctors()->count();
        if ($relatedDoctors > 0) {
            $code = 500;
            $msg = "The department can't be deleted, as it is related to doctors.";
        }
        else {
            $department->delete();
            $code = 200;
            $msg = 'The selected department has been successfully deleted!';
        }
        return response()->json([
            'code' => $code,
            'msg'=>$msg
        ]);
    }
}
