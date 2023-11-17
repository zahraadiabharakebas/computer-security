<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Models\User;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctor = Role::where('key', env('DOCTOR'))->first();
        $doctorId = $doctor->id;

        $doctors = User::whereHas('getRoles', function ($query) use ($doctorId) {
            $query->where('role_id', $doctorId);
        })->get();

        return view('pages.doctor.List')->with('doctors',$doctors);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::pluck('name', 'id');
        return view('pages.doctor.Add')->with('departments',$departments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'department' => 'required',
            'password' => 'min:6|required_with:rpassword|same:rpassword',
            'rpassword' => 'required',
            'telephone' => [
                'required',
                'unique:users,telephone',
                'regex:/^[0-9+]+$/'
            ],
            'image'=>'required',
            'email'=>['required', 'unique:users,email',]
        ]);
        $doctor = new User();
        $doctor->name = $request->name;
        $doctor->address = $request->address;
        $doctor->email = $request->email;
        $doctor->password = $request->password;
        $doctor->telephone = $request->telephone;
        $doctor->date_birth = \DateTime::createFromFormat('d/m/Y', $request->date_of_birth)->format('Y-m-d');
        $doctor->department_id = $request->department;
        $doctor->is_active = $request->status == 'active'? 1 : 0 ;
        $doctor->gender = $request->gender == 'male' ? 'male' : 'female';
        if ($request->hasFile('image')) {
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            $fileNameWithExt = str_replace(' ', '', $fileNameWithExt);
            if (strpos($fileNameWithExt, '(') !== false || strpos($fileNameWithExt, ')') !== false) {
                $fileNameWithExt = str_replace(['(', ')'], '', $fileNameWithExt);
            }
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            // Upload image
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
            $doctor->image = 'storage/images/' . $fileNameToStore;
        }
        $doctor->save();
        $doctors = Role::where('key', env('DOCTOR'))->first();
        $doctorId = $doctors->id;
        $role = new UserRole();
        $role->user_id = $doctor->id;
        $role->role_id = $doctorId;
        $role->save();
        return redirect()->route('doctor.index');
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
        $departments = Department::pluck('name', 'id');
        $doctor = User::find($id);
        return view('pages.doctor.Add')->with('departments',$departments)->with('data',$doctor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $doctor = User::find($id);
        $request->validate([
            'name' => 'required',
            'department' => 'required',
            'password' => 'required_with:rPassword|same:rpassword',
            'telephone' => ['unique:users,telephone,' . $doctor->id, 'regex:/^[0-9+]+$/'],
            'email'=>['unique:users,email,' . $doctor->id]
        ]);

        $doctor->name = $request->name;
        $doctor->address = $request->address;
        $doctor->email = $request->email;
        $doctor->telephone = $request->telephone;

        if($request->password) {
            $doctor->password = $request->password;
        }
        $doctor->date_birth = \DateTime::createFromFormat('d/m/Y', $request->date_of_birth)->format('Y-m-d');
        $doctor->department_id = $request->department;
        $doctor->is_active = $request->status == 'active'? 1 : 0 ;
        $doctor->gender = $request->gender == 'male' ? 'male' : 'female';
        if($request->image) {
            if ($request->hasFile('image')) {
                $fileNameWithExt = $request->file('image')->getClientOriginalName();
                $fileNameWithExt = str_replace(' ', '', $fileNameWithExt);
                if (strpos($fileNameWithExt, '(') !== false || strpos($fileNameWithExt, ')') !== false) {
                    $fileNameWithExt = str_replace(['(', ')'], '', $fileNameWithExt);
                }
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('image')->getClientOriginalExtension();
                //Filename to store
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
                // Upload image
                $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
                $doctor->image = 'storage/images/' . $fileNameToStore;
            }
        }
        $doctor->save();
        return redirect()->route('doctor.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor = User::find($id);
        if (!$doctor) {
            return response()->json([
                'code' => 404,
                'msg' => 'Doctor not found.'
            ]);
        }
            $doctor->delete();
            $code = 200;
            $msg = 'The selected doctor has been successfully deleted!';

        return response()->json([
            'code' => $code,
            'msg'=>$msg
        ]);
    }
}