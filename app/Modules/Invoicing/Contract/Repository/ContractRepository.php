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
            $contracts = $this->getByProjectYearAndClient($request->id_project, $request->year, $request->id_client);
        }


        foreach ($contracts as $contract) {

            $table[] = [
                'id' => $contract->id,
                'project_name' => $contract->project->nombre_corto,
                'client_name' => $contract->client->nombre_cliente,
                'initial_date' => $contract->initial_date,
                'end_date' => $contract->end_date,
                'year' => $contract->year,
                'options' => view('sections.contracts.components.table-options', ['contract' => $contract])->render()
            ];


        }

        return Datatables::of($table)->addIndexColumn()->rawColumns(['options'])->make(true);
    }

    public function getById($id, $relations = []){
        return Contract::with($relations)->find($id);
    }

    public function getByProjectYearAndClient($idProject, $year, $idClient){
        return Contract::whereIn('fk_id_project',$idProject)
            ->whereIn('year',$year)
            ->whereIn('fk_id_client',$idClient)
            ->get();
    }

    public function save($request){
        $result = 200;

        try {
            if (isset($request->id)) {
                $contract = Contract::find($request->id);
            }else{
                $contract = new Contract();
            }

           $data = $request->only($contract->getFillable());
           $data['fk_id_user'] = Auth::user()->id;
           $data['fk_id_country'] = GeneralVariables::getCurrentCountryId();

           if ($contract->fill($data)->save()) {
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
