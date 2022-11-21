<?php

namespace App\Modules\Production\Machine\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class Machine extends Model
{
    use SoftDeletes;
    protected $table = 'maquinas';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }
}
