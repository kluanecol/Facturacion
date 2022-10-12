<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Models;

use App\Modules\Admin\Client\Models\Client;
use App\Modules\Admin\Project\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigurationSubtype extends Model
{
    use SoftDeletes;
    protected $table = 'fac_configuration_subtypes';

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
        'fk_id_configuration_type'
    ];

    public $timestamps = true;


}
