<?php

namespace App\Modules\Admin\GeneralParametric\Repository;

use App\Modules\Admin\GeneralParametric\Models\GeneralParametric;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class GeneralParametricRepository implements GeneralParametricInterface{

    public function getActivitiesByCountry($idCountry){
        return GeneralParametric::where('id_country',$idCountry)
        ->where('category','id_param_actividad')
        ->where('state',1)
        ->get();
    }

    public function  getCasingDiameters($idCountry){
        return GeneralParametric::where('id_country',$idCountry)
        ->where('category','id_param_diametro')
        ->where('ref1_descripcion', 'LIKE', '%casing%')
        ->where('state',1)
        ->get();
    }

    public function  getDrillingDiameters($idCountry){
        return GeneralParametric::where('id_country',$idCountry)
        ->where('category','id_param_diametro')
        ->where('state',1)
        ->where('ref1_descripcion', null)
        ->get();
    }

    public function  getByIdsArray($ids){
        return GeneralParametric::whereIn('id',$ids)->get();
    }
}
