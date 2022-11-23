<?php

namespace App\Modules\Production\Machine\Repository;

use App\Modules\Production\Machine\Models\Machine;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class MachineRepository implements MachineInterface{

    public function getByIdsArray($machinesIds){
        return Machine::whereIn('id', $machinesIds)->get();
    }

}
