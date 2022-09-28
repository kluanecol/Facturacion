<?php

namespace App\Modules\Invoicing\Contract\Repository;

use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Invoicing\Contract\Models\Contract;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class ContractRepository implements ContractInterface{

    public function dataTableContracts($request){

        $contracts=[];
        $table=[];

        if (isset($request->id_project) && isset($request->year)) {
            $contracts = $this->getByProjectAndYear($request->id_project, $request->year);
        }


        foreach ($contracts as $contract) {

            $table[] = [
                'id' => $contract->id,
                'project_name' => $contract->project->nombre_corto,
                'initial_date' => $contract->initial_date,
                'end_date' => $contract->end_date,
                'year' => $contract->year,
                'options' => view('sections.contracts.components.table-options', ['contract' => $contract])->render()
            ];


        }

        return Datatables::of($table)->addIndexColumn()->rawColumns(['options'])->make(true);
    }

    public function getById($id){
        return Contract::find($id);
    }

    public function getByProjectAndYear($id_project, $year){
        return Contract::whereIn('fk_id_project',$id_project)->whereIn('year',$year)->get();
    }

    public function save($request){
        $result = 200;

        try {
            if (isset($request->id)) {
                $contract = Contract::find($request->id);
            }else{
                $contract = new Contract();
            }

           $contract->fk_id_user = Auth::user()->id;
           $contract->fk_id_project = $request->id_project;
           $contract->fk_id_country = GeneralVariables::getCurrentCountryId();
           $contract->initial_date = $request->initial_date;
           $contract->end_date = $request->end_date;
           $contract->year = $request->year;

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

    public function delete($request){
        $result = 200;

        try {

            if (isset($request->id_contract)) {
                $contract = Contract::find($request->id_contract);
            }

           if ($contract->delete()) {
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
