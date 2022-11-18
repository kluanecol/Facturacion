<?php

namespace App\Modules\Admin\Country\Repository;

use App\Modules\Admin\Country\Models\Country;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class CountryRepository implements CountryInterface{

    public function getAll()
    {
        return $countries = Country::all();
    }

}
