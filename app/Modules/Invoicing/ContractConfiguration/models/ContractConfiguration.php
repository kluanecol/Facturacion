<?php

namespace App\Modules\Invoicing\ContractConfiguration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Invoicing\Parametric\Models\Parametric;
use App\Modules\Invoicing\ConfigurationSubtype\Models\ConfigurationSubtype;
use App\Modules\Admin\GeneralParametric\Models\GeneralParametric;
use App\Modules\Admin\Consumable\Models\Consumable;

class ContractConfiguration extends Model
{

    protected $table = 'contract_configurations';

    protected $primaryKey= 'id';

    protected $fillable = [
       'fk_id_contract',
       'fk_id_configuration_subtype',
       'fk_id_parametric',
       'fk_id_diameter',
       'fk_id_activity',
       'fk_id_product',
       'initial_range',
       'final_range',
       'value',
       'order',
       'fk_id_second_parametric',
       'second_value',

    ];

    public $timestamps = true;

    use SoftDeletes;

    public function currency()
    {
        return $this->belongsTo(Parametric::class, 'fk_id_parametric','id');
    }

    public function secondCurrency()
    {
        return $this->belongsTo(Parametric::class, 'fk_id_second_parametric','id');
    }

    public function configurationSubtype()
    {
        return $this->belongsTo(ConfigurationSubtype::class, 'fk_id_configuration_subtype','id');
    }

    public function activity()
    {
        return $this->belongsTo(GeneralParametric::class, 'fk_id_activity','id');
    }

    public function diameter()
    {
        return $this->belongsTo(GeneralParametric::class, 'fk_id_diameter','id');
    }

    public function product()
    {
        return $this->belongsTo(Consumable::class, 'fk_id_product','id');
    }
}
