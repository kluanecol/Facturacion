<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Modules\Admin\Country\Models\Country;
use Session;

class LanguageController extends Controller

{

public function swap($lang)
{
    session()->put('locale', $lang);
    return redirect()->back();
}

public function swapcountry($idCountry)
{
    $country = Country::Where('id',$idCountry)->first();
    Session::put('country', $country);

    return view('home');
}


}
