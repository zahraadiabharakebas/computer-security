<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class PatientController extends Controller
{
   
    public function index()
    {
        $patient =  Role::where('key', env('PATIENT'))->first();
        $patientId = $patient->id ;
        $patients = User::whereHas('getRoles', function ($query) use ($patientId) {
            $query->where('role_id', $patientId);
        })->get();

        return view('pages.patient.List')->with('patients',$patients);

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
        'username' => ['required', 'string', 'max:15', 'forbiddenUsername', 'regex:/^[a-zA-Z\s]+$/'],
        'name' => ['required', 'string', 'max:15', 'forbiddenUsername', 'regex:/^[a-zA-Z\s]+$/'],
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).*$/',
        ],
        'rpassword' => 'required',
        'telephone' => [
            'required',
            'unique:users,telephone',
            'regex:/^[0-9]{1,15}$/',
        ],
        'image' => 'required',
        'email' => [
            'required',
            'unique:users,email',
            'forbiddenEmail',
        ],
    ], [
        'password.regex' => 'The password must include at least one digit, one lowercase letter, one uppercase letter, and one special character among @#$%^&+=.',
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'username' => ['required','regex:/^[a-zA-Z\s]+$/'],
        //     'name' => ['required','regex:/^[a-zA-Z\s]+$/'],
        //     'password' => [
        //         'min:8',
        //         'required_with:rpassword',
        //         'same:rpassword',
        //         'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).*$/',
        //     ],
        //     'rpassword' => 'required',
        //     'telephone' => [
        //         'required',
        //         'unique:users,telephone',
        //         'regex:/^[0-9+]+$/'
        //     ],
        //     'image' => 'required',
        //     'email' => ['required', 'unique:users,email'],
        // ], [
        //     'password.regex' => 'The password must include at least one digit, one lowercase letter, one uppercase letter, and one special character among @#$%^&+=.',
        // ]);        
        $this->validator($request->all())->validate();
        $patient = new User();
        $patient->username = $request->username;
        $patient->name = $request->name;
        $patient->address = $request->address;
        $patient->email = $request->email;
        $patient->password = $request->password;
        $patient->telephone = $request->telephone;
        $patient->date_birth = \DateTime::createFromFormat('d/m/Y', $request->date_of_birth)->format('Y-m-d');
        $patient->is_active = $request->status == 'active'? 1 : 0 ;
        $patient->gender = $request->gender == 'male' ? 'male' : 'female';
        if ($request->hasFile('image')) {
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            $fileNameWithExt = str_replace(' ', '', $fileNameWithExt);
            if (strpos($fileNameWithExt, '(') !== false || strpos($fileNameWithExt, ')') !== false) {
                $fileNameWithExt = str_replace(['(', ')'], '', $fileNameWithExt);
            }
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
            $patient->image = 'storage/images/' . $fileNameToStore;
        }
        $patient->save();
        $patients = Role::where('key', env('PATIENT'))->first();
        $patientId = $patients->id;
        $role = new UserRole();
        $role->user_id = $patient->id;
        $role->role_id = $patientId;
        $role->save();
        return redirect()->route('patient.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctorUserIds = UserRole::whereHas('role', function ($query) {
            $query->where('key', env('DOCTOR')); 
        })->pluck('user_id');
    
        $doctors = User::whereIn('id', $doctorUserIds)->pluck('name', 'id');
    
        return view('pages.Patient.Add');
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
       
      
        $patient = User::find($id);
        return view('pages.patient.Add')->with('data',$patient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $patient = User::find($id);
        $request->validate([
            'username' => ['required','regex:/^[a-zA-Z\s]+$/'],
            'name' => ['required','regex:/^[a-zA-Z\s]+$/'],
            'password' => 'min:6|required_with:rpassword|same:rpassword',
            'rpassword' => 'required',
            'telephone' => [
                'required',
                'unique:users,telephone',
                'regex:/^[0-9+]+$/'
            ],
            'telephone' => ['unique:users,telephone,' . $patient->id, 'regex:/^[0-9+]+$/'],
            'email'=>['unique:users,email,' . $patient->id]
        ]);

        $patient->username = $request->username;
        $patient->name = $request->name;
        $patient->address = $request->address;
        $patient->email = $request->email;
        $patient->telephone = $request->telephone;

        if($request->password) {
            $patient->password = $request->password;
        }
        $patient->date_birth = \DateTime::createFromFormat('d/m/Y', $request->date_of_birth)->format('Y-m-d');
        $patient->is_active = $request->status == 'active'? 1 : 0 ;
        $patient->gender = $request->gender == 'male' ? 'male' : 'female';
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
                $patient->image = 'storage/images/' . $fileNameToStore;
            }
        }
        $patient->save();
        return redirect()->route('patient.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = User::find($id);
        if (!$patient) {
            return response()->json([
                'code' => 404,
                'msg' => 'Doctor not found.'
            ]);
        }
            $patient->delete();
            $code = 200;
            $msg = 'The selected doctor has been successfully deleted!';

        return response()->json([
            'code' => $code,
            'msg'=>$msg
        ]);
    }
}
