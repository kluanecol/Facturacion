<?php

namespace App\Modules\Invoicing\Parametric\Repository;

use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Invoicing\Parametric\Models\Parametric;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class ParametricRepository implements ParametricInterface{

    public function dataTableChildrenParametrics($request){

        $parametrics=[];
        $table=[];

        if (isset($request->id_country) && isset($request->id_parametrics)) {
            $parametrics = $this->getAllChildrenByMultipleIdParent($request->id_parametrics, $request->id_country);
        }


        foreach ($parametrics as $parametric) {

            $table[] = [
                'id' => $parametric->id,
                'country' => $parametric->json_countries,
                'name' => $parametric->name,
                'auxiliary' => isset($parametric->auxiliarParametric) ? $parametric->auxiliarParametric->name : "NO",
                'parent' => $parametric->parent->name,
                'options' => view('sections.parametrics.components.table-options', ['parametric' => $parametric])->render()
            ];


        }

        return Datatables::of($table)->addIndexColumn()->rawColumns(['options'])->make(true);
    }

    public function getAllParents(){
        return Parametric::active()
        ->whereNull('fk_id_parent')
        ->whereRaw('JSON_CONTAINS(json_countries, \'"'. GeneralVariables::getCurrentCountryId() .'"\')')
        ->get()
        ->sortBy('name');
    }

    public function getActiveChildren($idParent){
        return Parametric::active()
        ->whereRaw('JSON_CONTAINS(json_countries, \'"'. GeneralVariables::getCurrentCountryId() .'"\')')
        ->where('fk_id_parent',$idParent)
        ->get();
    }

    public function getAllChildrenByMultipleIdParent(array $idParents, $idCountry, $relations = []){

        return Parametric::with($relations)
            ->whereRaw('JSON_CONTAINS(json_countries, \'"'. intval($idCountry) .'"\')')
            ->whereIn('fk_id_parent', $idParents)
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
