<?php

namespace App\Modules\Admin\Client\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    protected $table = 'clientes';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }
}
