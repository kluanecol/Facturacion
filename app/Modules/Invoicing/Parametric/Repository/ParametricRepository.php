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
        ->whereRaw('JSON_CONTAINS(json_countries, \'"'. GeneralVariables::getCurrentCountryId() .'"\')')
        ->where('fk_id_parent',$idParent)
        ->get();
    }

    public function getMultipleById(array $idParametrics){
        return Parametric::active()
        ->whereIn('id', $idParametrics)
        ->get();
    }

    public function save($request){
        $result = 200;

        try {
            if (isset($request->id)) {
                $parametric = Parametric::find($request->id);
            }else{
                $parametric = new Parametric();
            }

           $data = $request->only($parametric->getFillable());

           if(!isset($data['json_countries'])){
                $data['json_countries'] = json_encode(array(strval(GeneralVariables::getCurrentCountryId())));
           }

           if ($parametric->fill($data)->save()) {
                $result = 200;
            }else{
                $result = 400;
           }

           return $result;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
