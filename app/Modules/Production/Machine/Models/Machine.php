<?php

namespace App\Modules\Production\Machine\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Admin\GeneralParametric\Models\GeneralParametric;

class Machine extends Model
{
    use SoftDeletes;
    protected $table = 'maquinas';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }

    public function functionality()
    {
        return $this->belongsTo(GeneralParametric::class, 'id_param_funcionalidad','id');
    }

    public function getCodeNameAttribute()
    {
        return $this->codigo.' - '.$this->nombre;
    }

    public function getNameAttribute()
    {
        return $this->nombre;
    }
}
