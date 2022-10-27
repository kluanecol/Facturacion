<?php

namespace App\Modules\Admin\Project\Repository;

use App\Modules\Admin\Project\Models\Project;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class ProjectRepository implements ProjectInterface{

    public function getByCountry($idCountry){
        return Project::where('id_country',$idCountry)
            ->where('estado',1)
            ->orderBy('nombre_corto')->get();
    }

}
