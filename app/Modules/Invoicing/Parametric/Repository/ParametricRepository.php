<?php

namespace App\Modules\Invoicing\Parametric\Repository;

use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Invoicing\Parametric\Models\Parametric;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class ParametricRepository implements ParametricInterface{

    public function getActiveChildren($idParent){
        return Parametric::active()
        ->whereJsonContains('json_countries->country', GeneralVariables::getCurrentCountryId())
        ->where('fk_id_parent',$idParent)
        ->get();
    }
}
