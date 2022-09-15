<?php

namespace App\Modules\Admin\Country\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Country extends Model
{
    use SoftDeletes;

    protected $table = 'countries';
    protected $fillable=['name','state'];
    protected $dates=['deleted_at'];

    public function UsersCountries()
    {
        return $this->hasMany('App\Modules\Admin\Country\Models\UserCountry', 'id_country', 'id' );
    }



}
