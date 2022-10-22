<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Repository;

use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Invoicing\ConfigurationSubtype\Models\ConfigurationSubtype;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class ConfigurationSubtypeRepository implements ConfigurationSubtypeInterface{

    public function getActive(){
       return ConfigurationSubtype::active()
        ->where('json_countries', 'like', '%' . GeneralVariables::getCurrentCountryId() . '%')
        ->orderBy('order')->get();
    }

    public function getById($id){
        return ConfigurationSubtype::find($id);
     }

}
