<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Modules\Admin\UserCountry\Models\UserCountry;
use Session;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request)
    {

        $userId = Auth()->user()->id;
        $userCountries = UserCountry::join('countries','countries.id','=','users_by_countries.id_country')
        ->Where('users_by_countries.id_user',$userId)
        ->where('countries.state',1)
        ->get();

        Session::put('countries', $userCountries);

        Session::put('country', $userCountries[0]->country);


    }
}
