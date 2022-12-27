<?php

namespace App\Modules\Invoicing\Invoice\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Contract\Models\Contract;
use App\Modules\Invoicing\InvoiceConfiguration\Models\InvoiceConfiguration;

class Invoice extends Model
{

    protected $table = 'invoices';

    protected $primaryKey= 'id';

    protected $fillable = [
        'fk_id_contract',
        'fk_id_user',
        'fk_id_parent_invoice',
        'initial_period',
        'end_period',
        'code',
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


    public function contract()
    {
        return $this->belongsTo(Contract::class, 'fk_id_contract','id');
    }

    public function getPeriodAttribute()
    {
        return $this->initial_period.' - '.$this->end_period;
    }

    public function parentInvoice()
    {
        return $this->belongsTo(Invoice::class, 'fk_id_parent_invoice','id');
    }

    public function versions()
    {
        return $this->hasMany(Invoice::class, 'fk_id_parent_invoice');
    }

    public function configurations()
    {
        return $this->hasMany(InvoiceConfiguration::class, 'fk_id_invoice', 'id');
    }
}
