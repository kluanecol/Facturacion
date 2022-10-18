<?php

namespace App\Modules\Admin\GeneralParametric\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralParametric extends Model
{
    use SoftDeletes;
    protected $table = 'parametrics';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }
}
