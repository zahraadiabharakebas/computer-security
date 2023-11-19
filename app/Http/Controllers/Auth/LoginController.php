<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }

    // public function login(Request $request)
    // {
    //     $this->validateLogin($request);


    //     if ($this->hasTooManyLoginAttempts($request)) {
    //         $this->fireLockoutEvent($request);

    //         return $this->sendLockoutResponse($request);
    //     }

    //     if($this->guard()->validate($this->credentials($request))) {
    //         if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1])) {
    //             return redirect('/');
    //         }  else {
    //             $this->incrementLoginAttempts($request);
    //             abort(401, 'This action is unauthorized.');
    //         }
    //     } else {
    //         $this->incrementLoginAttempts($request);
    //         return back()->withErrors([
    //             'error' => 'Credentials do not match our database.'
    //         ])->withInput();
    //     }
    // }

    public function login(Request $request)
{
    try {
        $user = User::where('email', $request->email)->first();
        $check = false;

        if ($user) {
            $check = Hash::check($request->password, $user->password);
        }

        if (!$check) {
            if (RateLimiter::hit($request->ip(), 300) && RateLimiter::tooManyAttempts($request->ip(), 3)) {
                return back()->withErrors([
                    'error' => 'Too many failed login attempts. Your IP is restricted for 5 minutes.'
                ])->withInput();
            }
            return back()->withErrors([
                'error' => 'Credentials do not match our database.'
            ])->withInput();
        }

        // Clear rate limiter if login is successful
        RateLimiter::clear($request->ip());

        $accessToken = AccessToken::updateOrCreate(
            [ 'user_id' => $user->id ],
            [ 'access_token' => Str::random(255) ]
        );

        return response()->json([ 'access_token' =>  $accessToken->access_token ]);
    } catch (\Throwable $th) {
        throw $th;
    }
}

    

}
