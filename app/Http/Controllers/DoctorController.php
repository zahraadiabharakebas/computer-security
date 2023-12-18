<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;


class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
        $this->middleware('checkrole:A|D|P');
    }
    public function index()
    {
        $doctor = Role::where('key', 'D')->first();
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
        $departments = Department::where('status',1)->pluck('name', 'id');
        return view('pages.doctor.Add')->with('departments',$departments);
    }
    protected function validator(array $data)
    {
        $forbiddenUsernames = ['superuser', 'root', 'select', 'delete', 'update', 'and', 'where', 'sql', 'query', '/', '\\', ','];
        $forbiddenEmails = ['superuser', 'root', 'select', 'delete', 'update', 'and', 'where', 'sql', 'query', '/', '\\', ','];

        Validator::extend('forbiddenUsername', function ($attribute, $value, $parameters, $validator) use ($forbiddenUsernames) {
            foreach ($forbiddenUsernames as $username) {
                if (stripos($value, $username) !== false) {
                    return false;
                }
            }
            return true;
        }, 'The :attribute is forbidden.');

        Validator::extend('forbiddenEmail', function ($attribute, $value, $parameters, $validator) use ($forbiddenEmails) {
            foreach ($forbiddenEmails as $email) {
                if (stripos($value, $email) !== false) {
                    return false;
                }
            }
            return true;
        }, 'The :attribute is forbidden.');

        return Validator::make($data, [
            'username' => [
                'required',
                'string',
                'max:25',
                'forbiddenUsername',
                'regex:/^[a-zA-Z\s]+$/',
                'unique:users' // Add the 'unique' rule and specify the table name
            ],
            'name' => ['required', 'string', 'max:25', 'forbiddenUsername', 'regex:/^[a-zA-Z\s]+$/'],
            'password' => 'min:6|required_with:rpassword|same:rpassword',
            'rpassword'=>'required',
            'telephone' => [
                'required',
                'unique:users,telephone', // Assuming 'telephone' is a unique field in the 'users' table
                'regex:/^[0-9]{1,15}$/',
            ],
            'image' => 'required',
            'email' => [
                'required',
                'unique:users,email', // Assuming 'email' is a unique field in the 'users' table
                'forbiddenEmail',
            ],
        ]);
    }
    /**
     * Store a newly created resource in storage.
     **/
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $doctor = new User();
            $doctor->username = $request->username;
            $doctor->name = $request->name;
            $doctor->address = $request->address;
            $doctor->email = $request->email;
            $doctor->password = Hash::make($request->password);
            $doctor->telephone = $request->telephone;
            $doctor->date_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->format('Y-m-d');
            $doctor->department_id = $request->department;
            $doctor->is_active = $request->status == 'active' ? 1 : 0;
            $doctor->gender = $request->gender == 'male' ? 'male' : 'female';
            if ($request->hasFile('image')) {
                $fileNameWithExt = $request->file('image')->hashName();
                $fileNameWithExt = str_replace(' ', '', $fileNameWithExt);
                if (strpos($fileNameWithExt, '(') !== false || strpos($fileNameWithExt, ')') !== false) {
                    $fileNameWithExt = str_replace(['(', ')'], '', $fileNameWithExt);
                }
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('image')->extension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
                $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
                $imageHash = hash_file('sha256', storage_path('app/public/images/' . $fileNameToStore));

                if (User::where('hashed_image', $imageHash)->exists()) {
                    return redirect()->route('doctor.index')->withErrors(['error' => 'Image already exists.']);
                }

                $doctor->image = 'storage/images/' . $fileNameToStore;
                $doctor->hashed_image = $imageHash;
            }


            $doctor->save();

            $doctors = Role::where('key', 'D')->first();
            $doctorId = $doctors->id;
            $role = new UserRole();
            $role->user_id = $doctor->id;
            $role->role_id = $doctorId;
            $role->save();

            DB::commit();
            return redirect()->route('doctor.index');
        } catch (\Exception $e) {
            Log::error('Caught exception: ' . $e->getMessage(), ['exception' => $e]);
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong.');
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
        $departments = Department::pluck('name', 'id');
        $doctor = User::find($id);
        return view('pages.doctor.Add')->with('departments',$departments)->with('data',$doctor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
        DB::beginTransaction();
        $doctor = User::find($id);
        $request->validate([
            'username' =>  ['required','regex:/^[a-zA-Z\s]+$/'],
            'name' => ['required','regex:/^[a-zA-Z\s]+$/'],
            'department' => 'required',
            'password' => 'required_with:rPassword|same:rpassword',
            'telephone' => ['unique:users,telephone,' . $doctor->id, 'regex:/^[0-9+]+$/'],
            'email'=>['unique:users,email,' . $doctor->id]
        ]);

        $doctor->username = $request->username;
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
                $fileNameWithExt = $request->file('image')->hashName();
                $fileNameWithExt = str_replace(' ', '', $fileNameWithExt);
                if (strpos($fileNameWithExt, '(') !== false || strpos($fileNameWithExt, ')') !== false) {
                    $fileNameWithExt = str_replace(['(', ')'], '', $fileNameWithExt);
                }
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('image')->extension();
                //Filename to store
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
                // Upload image
                $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
                $doctor->image = 'storage/images/' . $fileNameToStore;
            }
        }
            DB::commit();
            return redirect()->route('doctor.index');
        } catch (\Exception $e) {
            Log::error('Caught exception: ' . $e->getMessage(), ['exception' => $e]);
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong'], 500);
        }
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
    public function getDoctors($departmentId)
    {

        $doctors = Doctor::where('department_id', $departmentId)->get();
        return response()->json($doctors);
    }

}
