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

}
