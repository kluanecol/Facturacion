<?php

namespace App\Modules\Admin\GeneralParametric\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class GeneralParametric extends Model
{
    use SoftDeletes;
    protected $table = 'parametrics';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }

    public function getNameAttribute()
    {
        if (GeneralVariables::getCurrentLanguage() == 'es') {
            return $this->text;
        } else {
            return $this->text_eng;
        }

    }

}
