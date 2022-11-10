<?php

namespace App\Modules\Admin\Consumable\Repository;

use App\Modules\Admin\Consumable\Models\Consumable;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class ConsumableRepository implements ConsumableInterface{

    public function getByCountry($idCountry){
        return Consumable::where('id_country',$idCountry)
            ->where('state', 1)
            ->orderBy('nombre')->get();
    }

    public function getByGroupId($idGroup){
        return Consumable::where('id_grupo', $idGroup)
            ->where('state', 1)
            ->orderBy('nombre')
            ->get();
    }

    public function searchByString($string){
        return Consumable::where('state','=', 1)
        ->where(function ($q) use ($string){
            $q->where('nombre', 'like', '%' .$string. '%')
                ->orWhere('nombre_ingles', 'like', '%' .$string. '%')
                ->orWhere('referencia', 'like', '%' .$string. '%');
        })
        ->orderBy('nombre')
        ->take(100)
        ->get()->unique('id');
    }

}
