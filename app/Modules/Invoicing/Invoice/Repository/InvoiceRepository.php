<?php

namespace App\Modules\Invoicing\Invoice\Repository;

use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Invoicing\Invoice\Models\Invoice;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Session;

class InvoiceRepository implements InvoiceInterface{

    public function dataTableInvoices($request){

        $invoices=[];
        $table=[];

        $invoices = $this->getByIdContract($request->id_contract);

        foreach ($invoices as $invoice) {

            $table[] = [
                'id' => $invoice->id,
                'initial_period' => $invoice->initial_period,
                'end_period' => $invoice->end_period,
                'versions' => "",
                'options' => view('sections.contracts.components.table-options', ['contract' => $invoice])->render()
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
                $invoice = Invoice::find($request->id);
            }else{
                $invoice = new Invoice();
            }

           $data = $request->only($invoice->getFillable());
           $data['fk_id_user'] = Auth::user()->id;
           $data['json_fk_machines'] = json_encode($data['json_fk_machines']);
           $data['json_fk_pits'] = json_encode($data['json_fk_pits']);

           if ($invoice->fill($data)->save()) {
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
