<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Repository;

use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Invoicing\ConfigurationSubtype\Models\ConfigurationSubtype;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class ConfigurationSubtypeRepository implements ConfigurationSubtypeInterface{

    public function getActive(){
        return ConfigurationSubtype::where('state',1)->orderBy('order')->get();
    }

}
