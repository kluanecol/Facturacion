<?php

namespace App\Modules\Production\MachineProject\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Production\Machine\Models\Machine;

class MachineProject extends Model
{
    use SoftDeletes;
    protected $table = 'maquinas_x_proyectos';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }

    public function machine()
    {
        return $this->belongsTo(machine::class, 'id_maquina','id');
    }
}
