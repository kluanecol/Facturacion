<?php

namespace App\Modules\Production\OperationRecord\Repository;

use App\Modules\Production\OperationRecord\Models\OperationRecord;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class OperationRecordRepository implements OperationRecordInterface{

    public function getPitsByDailyRecordsIds($dailyRecordsIds){

        return OperationRecord::whereIn('id_prod_registro_diario', $dailyRecordsIds)
            ->where('state',1)
            ->get()
            ->unique('hoyo')
            ->pluck('hoyo');
    }
}
