<?php

namespace App\Modules\Admin\ConsumableGroup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsumableGroup extends Model
{
    use SoftDeletes;
    protected $table = 'grupos';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }

}
