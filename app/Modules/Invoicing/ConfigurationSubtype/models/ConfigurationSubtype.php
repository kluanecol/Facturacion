<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Models;

use App\Modules\Admin\Client\Models\Client;
use App\Modules\Admin\Project\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class ConfigurationSubtype extends Model
{
    use SoftDeletes;

    protected $table = 'configuration_subtypes';

    protected $primaryKey= 'id';

    protected $fillable = [
        'spanish_name',
        'english_name',
        'english_description',
        'json_countries',
        'state',
        'multiple',
        'charge_by_percentage',
        'fk_id_measure',
        'fk_id_configuration_type',
        'order',
        'icon'
    ];

    protected $appends = ['name'];

    public $timestamps = true;


    public function getNameAttribute()
    {
        if (Session::get('locale') == 'es') {
            return $this->spanish_name;
        } else {
            return $this->english_name;
        }

    }

    public function scopeActive(){
        return $this->where('state',1);
    }
}
