<?php

namespace App\Modules\Invoicing\Invoice\Repository;

use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Invoicing\Invoice\Models\Invoice;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class InvoiceRepository implements InvoiceInterface{

    public function dataTableInvoices($request){

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
        return Invoice::with($relations)->find($id);
    }

    public function getByIdContract($id, $relations = []){
        return Invoice::with($relations)->where('fk_id_contract', $id)->get();
    }


    public function save($request){
        $result = 200;

        try {
            if (isset($request->id)) {
                $contract = Invoice::find($request->id);
            }else{
                $contract = new Invoice();
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
                $contract = Invoice::find($request->id_contract);
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
