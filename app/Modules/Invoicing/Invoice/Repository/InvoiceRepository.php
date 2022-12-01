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
                'period' =>view('sections.invoices.components.period-header', ['invoice' => $invoice])->render(),
                'code' => "FAC-".$invoice->version,
                'version' => $invoice->version,
                'state' => view('sections.invoices.components.badge-invoice-state', ['state' => $invoice->state])->render(),
                'machines' => $this->machineRepository->getByIdsArray($invoice->json_fk_machines)->sortBy('code_name')->pluck('code_name')->implode(','),
                'pits' => $invoice->json_fk_pits,
                'options' => view('sections.invoices.components.table-options', ['invoice' => $invoice])->render()
            ];


        }

        return Datatables::of($table)->addIndexColumn()->rawColumns(['period','state','options'])->make(true);
    }

    public function getById($id, $relations = []){
        return Invoice::with($relations)->find($id);
    }

    public function getByIdContract($id, $relations = []){
        return Invoice::with($relations)->where('fk_id_contract', $id)->get();
    }

    public function getByContractAndPeriod($fk_id_contract, $initial_period, $end_period){
        return Invoice::where('fk_id_contract', $fk_id_contract)
        ->where('initial_period', $initial_period)
        ->where('end_period', $end_period)
        ->get();
    }

    public function save($request){
        $result = 200;

        try {

           $invoice = new Invoice();

           $data = $request->only($invoice->getFillable());
           $data['fk_id_user'] = Auth::user()->id;
           $data['json_fk_machines'] = $data['json_fk_machines'];
           $data['json_fk_pits'] = $data['json_fk_pits'];

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

            if (isset($request->id_invoice)) {
                $invoice = Invoice::find($request->id_invoice);
            }

           if ($invoice->delete()) {
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
