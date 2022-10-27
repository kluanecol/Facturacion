<?php

namespace App\Modules\Admin\Client\Repository;

use App\Modules\Admin\Client\Models\Client;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class ClientRepository implements ClientInterface{

    public function getByCountry($idCountry){
        return Client::where('id_country',$idCountry)
            ->where('estado',1)
            ->orderBy('nombre_cliente')->get();
    }

}
