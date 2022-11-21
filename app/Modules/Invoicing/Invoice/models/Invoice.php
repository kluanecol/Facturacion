<?php

namespace App\Modules\Invoicing\Invoice\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{

    protected $table = 'invoices';

    protected $primaryKey= 'id';

    protected $fillable = [
        'fk_id_user',
        'fk_id_project',
        'fk_id_country',
        'fk_id_client',
        'initial_date',
        'end_date',
        'year'
    ];

    public $timestamps = true;


}
