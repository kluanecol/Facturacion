<?php

namespace App\Modules\Invoicing\Contract\Repository;

use App\Modules\Invoicing\Contract\Models\Contract;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class ContractRepository implements ContractInterface{

    public function dataTableContracts($request){

        $contracts = $this->getByProjectAndYear($request->id_project, $request->year);
        $table=[];

        foreach ($contracts as $contract) {
            /*
            $anexo = '<a href="'.$contract->vc_anexo_radicado.'" class="btn btn-warning" target="_blank">
            <i class="fa fa-download" aria-hidden="true"></i> Anexo</a>';

            $zip = '<a href="'.$contract->vc_ruta_zip.'" class="btn btn purple" target="_blank">
            <i class="fa fa-file-archive-o" aria-hidden="true"></i> ZIP</a>';

            $informesEnviados = '<span class="caption-subject bold font-yellow-crusta uppercase"><i class="fa fa-send" aria-hidden="true"></i> Enviados </span>'.
            '<span class="badge badge-warning">'. $contract->informes->count().'</span>';
            $informesAprobados = '<span class="caption-subject bold font-blue-madison uppercase"><i class="fa fa-check-circle" aria-hidden="true"></i> Aprobados </span>'.
            '<span class="badge badge-success">'. $contract->informes->where('i_estado',2)->count().'</span>';
            $informesDevueltos = '<span class="caption-subject bold font-red uppercase"><i class="fa fa-times-circle-o" aria-hidden="true"></i> Devueltos </span>'.
            '<span class="badge badge-danger">'. $contract->informes->where('i_estado','===',0)->count().'</span>';

            $informes = ' <a data-id="'.$lotePago->i_pk_id.'" class="btn btn-info ver_informes_lote">
            <i class="fa fa-eye" aria-hidden="true"></i></a>';
            */
            $table[] = [
                'id' => $contract->id,
                'project_name' => $contract->project->nombre_corto,
                'initial_date' => $contract->initial_date,
                'end_date' => $contract->end_date,
                'year' => $contract->year,
            ];

            $opciones = null;
        }

        return Datatables::of($table)->addIndexColumn()->rawColumns([''])->make(true);
    }

    public function getByProjectAndYear($id_project, $year){
        return Contract::whereIn('fk_id_project',$id_project)->whereIn('year',$year)->get();
    }

    public function save($request){
        $result = 200;

        try {
           $contract = new Contract();
           $contract->fk_id_user = Auth::user()->id;
           $contract->fk_id_project = $request->id_project;
           $contract->fk_id_country = Session::get('country')->id;
           $contract->initial_date = $request->initial_date;
           $contract->end_date = $request->end_date;

           if ($contract->save()) {
                $result = 200;
            }else{
                $result = 400;
           }

           return $result;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
