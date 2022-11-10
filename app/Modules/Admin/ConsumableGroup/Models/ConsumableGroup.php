<?php

namespace App\Modules\Admin\ConsumableGroup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class ConsumableGroup extends Model
{
    use SoftDeletes;
    protected $table = 'grupos';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }

    public function getNameAttribute()
    {
        if (GeneralVariables::getCurrentLanguage() == 'es') {
            return $this->nombre.' - '.$this->nombre_ingles;
        }

    }
}
