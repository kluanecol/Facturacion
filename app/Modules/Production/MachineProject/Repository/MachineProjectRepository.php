<?php

namespace App\Modules\Production\MachineProject\Repository;

use App\Modules\Production\MachineProject\Models\MachineProject;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class MachineProjectRepository implements MachineProjectInterface{

    public function getByActiveByProjectId($id, $relations = []){
        return MachineProject::with($relations)
        ->where('id_proyecto', $id)
        ->whereHas('machine.functionality', function ($q){
            $q->whereIn('value',[1,7]);
        })
        ->where('estado', 1)->get();
    }

}
