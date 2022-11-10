<?php

namespace App\Modules\Admin\Consumable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Admin\ConsumableGroup\Models\ConsumableGroup;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class Consumable extends Model
{
    use SoftDeletes;
    protected $table = 'consumibles';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }

    public function group()
    {
        return $this->belongsTo(ConsumableGroup::class, 'id_grupo','id');
    }

    public function getNameAttribute()
    {
        if (GeneralVariables::getCurrentLanguage() == 'es') {
            return $this->nombre;
        } else {
            return $this->nombre_ingles;
        }

    }

    public function getNameReferenceAttribute()
    {
        if (GeneralVariables::getCurrentLanguage() == 'es') {
            return $this->nombre.' - '.$this->referencia;
        } else {
            return $this->nombre_ingles.' - '.$this->referencia;
        }

    }
}
