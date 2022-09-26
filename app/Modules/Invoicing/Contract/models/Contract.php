<?php

namespace App\Modules\Invoicing\Contract\Models;

use App\Modules\Admin\Project\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;
    protected $table = 'fac_contracts';

    protected $primaryKey= 'id';

    protected $fillable = [

        'fk_id_user',
        'fk_id_project',
        'fk_id_country',
        'initial_date',
        'end_date'
    ];

    public $timestamps = true;


    public function project()
    {
        return $this->belongsTo(Project::class, 'fk_id_project','id');
    }
}
