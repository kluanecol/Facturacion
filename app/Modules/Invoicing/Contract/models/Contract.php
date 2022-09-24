<?php

namespace App\Modules\Invoicing\Contract\Models;

use App\Modules\Admin\Project\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;
    protected $table = 'fac_contracts';



    public function project()
    {
        return $this->belongsTo(Project::class, 'fk_id_project','id');
    }
}
