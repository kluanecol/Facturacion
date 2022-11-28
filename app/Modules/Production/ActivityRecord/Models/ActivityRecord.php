<?php

namespace App\Modules\Production\ActivityRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Production\ActivityRecord\Models\ActivityRecord;

class ActivityRecord extends Model
{
    use SoftDeletes;
    protected $table = 'prod_registro_actividades';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }

}
