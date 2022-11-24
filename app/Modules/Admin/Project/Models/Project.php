<?php

namespace App\Modules\Admin\Project\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $table = 'proyectos';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }

    public function getNameAttribute()
    {
        return $this->nombre_corto;
    }

    public function getLocationAttribute()
    {
        return $this->ubicación;
    }

}
