<?php

namespace App\Modules\Production\OperationRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class OperationRecord extends Model
{
    use SoftDeletes;
    protected $table = 'prod_registro_operacion';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }
}
