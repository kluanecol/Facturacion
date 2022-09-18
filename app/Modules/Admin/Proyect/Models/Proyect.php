<?php

namespace App\Modules\Admin\Proyect\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyectos extends Model
{
    use SoftDeletes;
    protected $table = 'proyectos';

}
