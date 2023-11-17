<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
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
        $patient = new User();
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
            //Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            // Upload image
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
            'name' => 'required',
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
