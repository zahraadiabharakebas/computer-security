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

//    public function login(Request $request){
//        $user = User::where('email', $request->email)->first();
//        $check = false;
//        if ($user) {
//            $check = Hash::check($request->password, $user->password);}
//        if ($this->guard()->validate($this->credentials($request))) {
//            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1])) {
//                return redirect('/');
//            } else {
//                $this->incrementLoginAttempts($request);
//                abort(401, 'This action is unauthorized.');}} else {
//            if (!$check) {
//                $identifier = $request->email . '_' . $request->input('device_id');
//                if (RateLimiter::hit($identifier, 60) && RateLimiter::tooManyAttempts($identifier, 3)) {
//                    \Log::info("Identifier: $identifier, Rate Limit Exceeded");
//                    return back()->withErrors([
//                        'error' => 'Too many failed login attempts. Your account is restricted for 1 minute.'
//                    ])->withInput();}
//                \Log::info("Identifier: $identifier, Credentials do not match our database.");
//                return back()->withErrors([
//                    'error' => 'Credentials do not match our database.'
//                ])->withInput();
//            }
//            $identifier = $request->email . '_' . $request->input('device_id');
//            RateLimiter::clear($identifier);
//        }
//    }
    public function login(Request $request)
    {
        $identifier = $request->email . '_' . $request->input('device_id');

        // Check rate limit before authentication
        if (RateLimiter::hit($identifier, 60) && RateLimiter::tooManyAttempts($identifier, 4)) {
            \Log::info("Identifier: $identifier, Rate Limit Exceeded");
            return back()->withErrors([
                'error' => 'Too many failed login attempts. Your account is restricted for 1 minute.'
            ])->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password) && $user->is_active) {
            // Clear rate limiter on successful login
            RateLimiter::clear($identifier);

            // Attempt authentication
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect('/');
            }
        }

        \Log::info("Identifier: $identifier, Credentials do not match our database.");

        // Increment rate limiter on failed login
        RateLimiter::hit($identifier, 60);

        return back()->withErrors([
            'error' => 'Credentials do not match our database.'
        ])->withInput();
    }



}
