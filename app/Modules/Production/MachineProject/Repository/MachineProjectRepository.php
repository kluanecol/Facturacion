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
            $q->whereIn('value',[GeneralVariables::ID_VAL_FUNCTIONALITY_SURFACE_MACHINE,GeneralVariables::ID_VAL_FUNCTIONALITY_WATER_LINES]);
        })
        ->where('estado', 1)->get();
    }

}
