<?php

namespace App\Modules\Admin\ConsumableGroup\Repository;

use App\Modules\Admin\ConsumableGroup\Models\ConsumableGroup;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class ConsumableGroupRepository implements ConsumableGroupInterface{

    public function getByCountry($idCountry){
        return ConsumableGroup::where('id_country',$idCountry)
            ->where('state', 1)
            ->orderBy('nombre')->get();
    }

}
