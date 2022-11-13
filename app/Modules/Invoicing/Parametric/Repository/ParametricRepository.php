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
        ->where('json_countries', 'like', '%' . GeneralVariables::getCurrentCountryId() . '%')
        ->where('fk_id_parent',$idParent)
        ->get();
    }

    public function getMultipleById(array $idParametrics){
        return Parametric::active()
        ->whereIn('id', $idParametrics)
        ->get();
    }
}
