<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\driver;
use App\Models\travel_agent;
use App\Models\vehicle;
use App\Models\VehicleType;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Carbon;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            // 'email' => 'email|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile' => ['required'],
            'gender' => ['required'],
            'age' => ['required'],
            'license_number' => ['required'],
            'car_number' => ['required'],
            'rate' => ['required'],
            'registration_number' => ['required'],
            'number_of_vehicles' => ['required'],

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {


        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'mobile' => $data['mobile'],
            'gender' => $data['gender'],
            'role' => $data['role'],

        ]);

        return $user;
    }
    public function DriverTravelReg(Request $request)
    {
        
        if($request->email!=null)
        {
            $request->validate([
                'email' => 'email|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:7',             // must be at least 10 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                ],
            ]);
        }else{
            $request->validate([
                'password' => [
                    'required',
                    'string',
                    'min:7',             // must be at least 10 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                ],
            ]);
        }
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'role' => $request->role,
        ]);

        if ($user->role == 1) {
            $dob = Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->format('Y-m-d');
            $age = Carbon::parse($dob)->diff(Carbon::now())->y;
            $driver = new driver();
            $driver->user_id = $user->id;
            $driver->name = $request->name;
            $driver->age = $age;
            $driver->dob = $dob;
            $driver->gender = $request->gender;
            $driver->license_number = strtoupper($request->license_number);
            $driver->save();

            Session()->flash('status', 'Registration Successful ');
            Auth::login($user);
            return redirect("/my-account");
        } elseif ($user->role == 2) {
            $travel = new travel_agent();
            $travel->user_id = $user->id;
            $travel->agency_name = $request->agency_name;
            $travel->registration_number = $request->registration_number;
            $travel->number_of_vehicles = $request->number_of_vehicles;
            $travel->save();
            Session()->flash('status', 'Registration Successful ');
            Auth::login($user);
            return redirect("/my-account");
            return view('front.travel-agency-dashboard');
        }
    }
}
