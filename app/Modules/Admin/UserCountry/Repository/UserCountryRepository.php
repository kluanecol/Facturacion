<?php

namespace App\Modules\Admin\UserCountry\Repository;

use App\Modules\Admin\UserCountry\Models\UserCountry;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class UserCountryRepository implements UserCountryInterface{

    public function getCountriesByUser()
    {
        return $userCountries = UserCountry::join('countries','countries.id','=','users_by_countries.id_country')
        ->Where('users_by_countries.id_user',Auth()->user()->id)
        ->where('countries.state',1)
        ->get();
    }

}
