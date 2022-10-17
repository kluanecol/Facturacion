<?php

namespace App\Modules\Invoicing\Parametric\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parametric extends Model
{

    protected $table = 'parametrics';

    protected $primaryKey= 'id';

    protected $fillable = [
       'json_countries',
        'spanish_name',
        'english_name',
        'spanish_description',
        'english_description',
        'state',
        'value',
        'symbol',
        'fk_id_parent'
    ];

    public $timestamps = true;

    use SoftDeletes;


}
