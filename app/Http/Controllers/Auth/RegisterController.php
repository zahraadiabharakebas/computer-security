<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;


class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        $forbiddenUsernames = ['superuser', 'root', 'select', 'delete', 'update', 'and', 'where', 'sql', 'query', '/', '\\', ','];

        Validator::extend('forbiddenUsername', function ($attribute, $value, $parameters, $validator) use ($forbiddenUsernames) {
            foreach ($forbiddenUsernames as $username) {
                if (stripos($value, $username) !== false) {
                    return false;
                }
            }
            return true;
        }, 'The :attribute is forbidden.');

        return Validator::make($data, [
            'username' => ['required', 'string', 'max:15', 'forbiddenUsername','regex:/^[a-zA-Z\s]+$/'],
            'name' => ['required', 'string', 'max:15','forbiddenUsername','regex:/^[a-zA-Z\s]+$/'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                function ($attribute, $value, $fail) use ($forbiddenUsernames) {
                    foreach ($forbiddenUsernames as $username) {
                        if (stripos($value, $username) !== false) {
                            $fail('The email is forbidden.');
                            return;
                        }
                    }
                },
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).*$/',
            ],
            'gender' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:15', 'unique:users'],
            'address' => ['required', 'string', 'max:255'],
        ],
            [
                'password.regex' => 'The password must include at least one digit, one lowercase letter, one uppercase letter, and one special character among @#$%^&+=.',
            ]);
    }




    protected function create(array $data)
    {
        $patient = Role::where('key', env('PATIENT'))->first();
        $patientId = $patient->id;

        $user = User::create([
            'username' => $data['username'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'telephone' => $data['telephone'],
            'gender' => $data['gender'],
            'address' => $data['address'],
        ]);

        $role = new UserRole();
        $role->role_id = $patientId;
        $role->user_id = $user->id;
        $role->save();

        return $user;
    }
}
