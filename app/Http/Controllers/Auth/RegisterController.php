<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

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
            'name' => ['required', 'regex:/^[a-zA-Z .]*$/', 'max:100'],
            'gender' => ['required'],
            'dob' => ['required', 'date', 'before:-18 years', 'after:-60 years'],
            'nic' => ['required', 'unique:users', 'max:12', 'min:10'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'mobile_no' => ['required', 'size:10', 'regex:/^[0-9]*$/'],
            'designation' => ['required'],
            'branch' => ['required'],
            'service' => ['required'],
            'class' => ['required'],
            'workplace_type' => ['required'],
            'workplace' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required'],
        ],
    
        ['gender.required' => 'Please select your gender',
        'dob.before' => 'You must be 18 Years or older',
        'dob.after' => 'You must be less than 60 years old',
        'terms.required' => 'You must agree to terms of usage',
        ]);

        
    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        

        return User::create([
            'name' => $data['name'],
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'nic' => $data['nic'],
            'email' => $data['email'],
            'mobile_no' => $data['mobile_no'],
            'designation' => $data['designation'],
            'branch' => $data['branch'],
            'service' => $data['service'],
            'class' => $data['class'],
            'workplace' => $data['workplace'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
