<?php

namespace App\Modules\Admin\Consumable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumable extends Model
{
    use SoftDeletes;
    protected $table = 'consumibles';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }

}
