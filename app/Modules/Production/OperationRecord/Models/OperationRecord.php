<?php

namespace App\Modules\Production\OperationRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Production\DailyRecord\Models\DailyRecord;

class OperationRecord extends Model
{
    use SoftDeletes;
    protected $table = 'prod_registro_operacion';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }

    public function dailyRecord()
    {
        return $this->belongsTo(DailyRecord::class, 'id_prod_registro_diario');
    }

    public function getAngleAttribute()
    {
        return $this->angulo;
    }

    public function getFromAttribute()
    {
        return $this->desde;
    }

    public function getToAttribute()
    {
        return $this->hasta;
    }
}
