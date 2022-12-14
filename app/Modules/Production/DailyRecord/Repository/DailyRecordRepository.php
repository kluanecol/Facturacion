<?php

namespace App\Modules\Production\DailyRecord\Repository;

use App\Modules\Production\DailyRecord\Models\DailyRecord;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class DailyRecordRepository implements DailyRecordInterface{

    public function getIdsByMachinesAndDate($request, $projectId){

        return DailyRecord::where('id_proyecto', $projectId)
            ->whereIn('id_maquina', $request->id_machines)
            ->whereBetween('fecha_registro', [$request->initial_period, $request->end_period])
            ->where('state',1)
            ->pluck('id');
    }

    public function getIdsByInvoiceObjectAndProjectId($invoice, $projectId, $relations = []){

        return DailyRecord::with($relations)
            ->where('id_proyecto', $projectId)
            ->whereIn('id_maquina', $invoice->json_fk_machines)
            ->whereBetween('fecha_registro', [$invoice->initial_period, $invoice->end_period])
            ->where('state',1)
            ->get();
    }

}
