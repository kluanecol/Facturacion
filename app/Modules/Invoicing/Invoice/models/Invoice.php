<?php

namespace App\Modules\Invoicing\Invoice\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{

    protected $table = 'invoices';

    protected $primaryKey= 'id';

    protected $fillable = [
        'fk_id_contract',
        'fk_id_user',
        'initial_period',
        'end_period',
        'code', 255,
        'state',
        'version',
        'json_fk_machines',
        'json_fk_pits'
    ];

    protected $casts = [
        'json_fk_machines' => 'array',
        'json_fk_pits' => 'array'
    ];

    public $timestamps = true;

    public function getPeriodAttribute()
    {
        return $this->initial_period.' - '.$this->end_period;
    }
}
