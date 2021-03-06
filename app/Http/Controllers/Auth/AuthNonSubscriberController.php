<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Models\NonSubscriber;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;

class AuthNonSubscriberController extends Controller
{
    protected $loginPath = '/auth-nonsubs/login';
    protected $redirectPath = '/nonsubs';
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function postLogin(Request $request)
    {
        $rules = [
            'email' => 'required|min:5',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ];

        $validation = Validator::make($request->only('email', 'password','g-recaptcha-response'), $rules);

        if ($validation->fails()) {
            return redirect($this->loginPath())->withInput($request->only('email', 'remember'))->withErrors($validation);
        }
        
        if (Auth::nonsubs()->attempt(['pic_email' => $request->input('email'), 'password' => $request->input('password')], $request->has('remember'))) {
            return redirect()->intended($this->redirectPath());
        }

        return redirect($this->loginPath())
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => $this->getFailedLoginMessage(),
            ]);
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|min:5',
            'password' => 'required'
        ];

        $validation = Validator::make($request->only('email', 'password'), $rules);

        if ($validation->fails()) {
            return redirect($this->loginPath())->withInput($request->only('email', 'remember'))->withErrors($validation);
        }

        if (Auth::nonsubs()->attempt(['pic_email' => $request->input('email'), 'password' => $request->input('password')], $request->has('remember'))) {
            return redirect()->intended($this->redirectPath());
        }

        return redirect($this->loginPath())
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => $this->getFailedLoginMessage(),
            ]);
    }
}
