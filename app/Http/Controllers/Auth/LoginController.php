<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Symfony\Component\HttpFoundation\Cookie;
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
    // public function __construct()
    // {
    //     Auth::check();
    //     Auth::viaRemember();
    //     $this->middleware('guest')->except('logout');
    // }
    public function showLoginForm()
    {
        if (!empty(Auth::user())) {
            return redirect('my-account');
        } else {
            return view('front.user_login');
        }
    }
    public function login(Request $request)
    {

        $remember_me = $request->has('remember') ? true : false;
        $userrole = User::where('mobile',$request->email)->orwhere('email',$request->email)->pluck('role')->first();
        $this->validate($request, [
            'email'    => 'required',
            'password' => 'required',
        ]);
        $identity = $request->input("email");
        $password = $request->input("password");


        if($userrole=='0')
        {
            $check = $this->guard()->attempt([
                'email' => $identity,
                'password' => $password],
                $remember_me
            );
        }
        else
        {
            $check = $this->guard()->attempt([
                'mobile' => $identity,
                'password' => $password
            ]);
        }

        if($check)
        {
            if(Auth::user()->role == '0'){
                return redirect('adminHomePage');
            }else{
                return redirect()->intended($this->redirectPath());

            }
        }
        else{
            return redirect()->back()->with('login-random',"Mobile Number and Password doesn't Match .");

        }

    }
    public function logout(Request $request)
    {
         
        if (Auth::user()->role == '0') {
            $this->guard()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            if ($response = $this->loggedOut($request)) {
                return $response;
            }
            return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('admin/login');
        }
        else
        {
            $this->guard()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            if ($response = $this->loggedOut($request)) {
                return $response;
            }
            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect('login');
        }

    }
}
