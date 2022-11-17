<?php

namespace App\Modules\Admin\Consumable\Repository;

use App\Modules\Admin\Consumable\Models\Consumable;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class ConsumableRepository implements ConsumableInterface{

    public function getByCountry($idCountry){
        return Consumable::where('id_country',$idCountry)
            ->where('state', 1)
            ->orderBy('referencia')->get();
    }

    public function getByGroupId($idGroup){
        return Consumable::where('id_grupo', $idGroup)
            ->where('state', 1)
            ->orderBy('referencia')
            ->get();
    }

    public function searchByString($string){

        $idCountry = GeneralVariables::getCurrentCountryId();

        return Consumable::whereHas('group', function ($q) use($idCountry){
            $q->where('id_country',$idCountry);
        })->where('state','=', 1)
        ->where(function ($q) use ($string){
            $q->where('nombre', 'like', '%' .$string. '%')
                ->orWhere('nombre_ingles', 'like', '%' .$string. '%')
                ->orWhere('referencia', 'like', '%' .$string. '%');
        })
        ->orderBy('referencia')
        ->take(100)
        ->get()
        ->unique('id');


    }

}
