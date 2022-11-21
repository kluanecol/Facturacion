<?php

namespace App\Modules\Production\DailyRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class DailyRecord extends Model
{
    use SoftDeletes;
    protected $table = 'prod_registro_diario';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }
}
