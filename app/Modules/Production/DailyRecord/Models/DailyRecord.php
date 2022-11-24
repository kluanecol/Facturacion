<?php

namespace App\Modules\Production\DailyRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Production\OperationRecord\Models\OperationRecord;

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

}
