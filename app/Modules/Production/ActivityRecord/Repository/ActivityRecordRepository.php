<?php

namespace App\Modules\Production\ActivityRecord\Repository;

use App\Modules\Production\ActivityRecord\Models\ActivityRecord;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class ActivityRecordRepository implements ActivityRecordInterface{

    public function getByDailyRecordsIds($dailyRecordsIds){
        return ActivityRecord::whereIn('id_prod_registro_diario', $dailyRecordsIds)
        ->where('state',1)
        ->get();
    }
}
