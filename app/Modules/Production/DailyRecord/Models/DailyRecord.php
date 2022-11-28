<?php

namespace App\Modules\Production\DailyRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Production\OperationRecord\Models\OperationRecord;
use App\Modules\Production\ActivityRecord\Models\ActivityRecord;

class DailyRecord extends Model
{
    use SoftDeletes;
    protected $table = 'prod_registro_diario';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }

    public function operationRecords()
    {
        return $this->hasMany(OperationRecord::class, 'id_prod_registro_diario');
    }

    public function activityRecords()
    {
        return $this->hasMany(ActivityRecord::class, 'id_prod_registro_diario');
    }

}
