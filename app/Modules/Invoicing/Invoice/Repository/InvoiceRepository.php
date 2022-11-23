<?php

namespace App\Modules\Invoicing\Invoice\Repository;

use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Invoicing\Invoice\Models\Invoice;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Modules\Production\Machine\Repository\MachineRepository;

class InvoiceRepository implements InvoiceInterface{

    protected $machineRepository;

    function __construct()
    {
        $this->machineRepository = new MachineRepository();
    }

    public function dataTableInvoices($request){

        $invoices=[];
        $table=[];

        $invoices = $this->getByIdContract($request->id_contract)->sortBy('period');

        foreach ($invoices as $invoice) {

            $table[] = [
                'id' => $invoice->id,
                'period' =>trans('invoices.periodoDeFacturacion').": ".$invoice->period,
                'code' => "FAC-".$invoice->id,
                'version' => "1",
                'state' => view('sections.invoices.components.badge-invoice-state', ['state' => $invoice->state])->render(),
                'machines' => $this->machineRepository->getByIdsArray($invoice->json_fk_machines)->sortBy('code_name')->pluck('code_name')->implode(','),
                'pits' => $invoice->json_fk_pits,
                'options' => view('sections.invoices.components.table-options', ['invoice' => $invoice])->render()
            ];


        }

        return Datatables::of($table)->addIndexColumn()->rawColumns(['state','options'])->make(true);
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
