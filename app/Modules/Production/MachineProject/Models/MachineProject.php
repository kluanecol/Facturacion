<?php

namespace App\Modules\Production\MachineProject\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class MachineProject extends Model
{
    use SoftDeletes;
    protected $table = 'maquinas_x_proyectos';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }
}
