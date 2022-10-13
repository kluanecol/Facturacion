<?php

namespace App\Modules\Admin\UserCountry\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserCountry extends Model
{
    use SoftDeletes;

    protected $table = 'users_by_countries';
    protected $primaryKey= 'id';

    public function __construct()
    {
        $this->connection = config('connections.rhomb');
    }

    public function country()
    {
        return $this->belongsTo('App\Modules\Admin\Country\Models\Country', 'id_country', 'id');
    }


}
