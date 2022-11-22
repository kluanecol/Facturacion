<?php

namespace App\Modules\Invoicing\Invoice\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Invoicing\Invoice\Repository\InvoiceInterface;
use App\Modules\Invoicing\Contract\Repository\ContractInterface;
use App\Modules\Production\MachineProject\Repository\MachineProjectInterface;
use App\Modules\Production\DailyRecord\Repository\DailyRecordInterface;
use App\Modules\Production\OperationRecord\Repository\OperationRecordInterface;

use Session;

class InvoiceController extends Controller
{
    private $invoiceRepo;
    protected $machineProjectRepo;
    private $contractRepo;
    private $dailyRecordRepo;
    private $operationRecordRepo;

    function __construct(
            InvoiceInterface $invoiceRepo,
            MachineProjectInterface $machineProjectRepo,
            ContractInterface $contractRepo,
            DailyRecordInterface $dailyRecordRepo,
            OperationRecordInterface  $operationRecordRepo
        )
        {
            $this->invoiceRepo = $invoiceRepo;
            $this->machineProjectRepo = $machineProjectRepo;
            $this->contractRepo = $contractRepo;
            $this->dailyRecordRepo = $dailyRecordRepo;
            $this->operationRecordRepo = $operationRecordRepo;
        }

    public function index($idContract){
        $data=[];

        $data['contract'] = $this->contractRepo->getById($idContract);
        $data['isInvoiceView'] = true;
        $data['invoices'] = $this->invoiceRepo->getByIdContract($idContract);

        return view('sections.invoices.index', $data);
    }

    public function Search(Request $request){
        return $this->invoiceRepo->dataTableInvoices($request);
    }

    public function getGeneralForm(Request $request){
        $data['contract'] = $this->contractRepo->getById($request->id_contract);
        $data['machines'] = $this->machineProjectRepo->getByActiveByProjectId( $data['contract']->fk_id_project, ['machine'])->pluck('machine.code_name','machine.id');


        $returnHTML = view('sections.invoices.form.general-form', $data)->render();
        return response()->json(['success' => true, 'html'=>$returnHTML]);

    }

    public function getPitsBySearch(Request $request){
        $contract = $this->contractRepo->getById($request->id_contract);
        $dailyRecordsIds = $this->dailyRecordRepo->getIdsByMachinesAndDate($request, $contract->fk_id_project);
        $pits = $this->operationRecordRepo->getPitsByDailyRecordsIds($dailyRecordsIds);

        return response()->json(['success' => true, 'pits'=> $pits]);
    }

    public function save(Request $request){
        $result = $this->invoiceRepo->save($request);

        if (is_string($result)) {
            $messages = [
                'message' => $result,
                'title' => trans('general.errorNoControlado'),
                'type'  => 'warning',
            ];
        }
        else if($result == 200){
            $messages = [
                'title' => trans('general.bienHecho'),
                'message' => trans('general.guardadoConExito'),
                'type'  => 'success',
                'status' => $result
            ];
        }else{
            $messages = [
                'message' => trans('general.algoSalioMal'),
                'title' => trans('general.errorAlGuardar'),
                'type'  => 'warning',
                'status' => $result
            ];
        }
        return response()->json($messages);

    }

    public function delete(Request $request){
        $result = $this->invoiceRepo->delete($request);

        if (is_string($result)) {
            $messages = [
                'message' => $result,
                'title' => trans('general.errorNoControlado'),
                'type'  => 'warning',
            ];
        }
        else if($result == 200){
            $messages = [
                'title' => trans('general.bienHecho'),
                'message' => trans('general.borradoConExito'),
                'type'  => 'success',
                'status' => $result
            ];
        }else{
            $messages = [
                'message' => trans('general.algoSalioMal'),
                'title' => trans('general.errorAlEliminar'),
                'type'  => 'warning',
                'status' => $result
            ];
        }
        return response()->json($messages);

    }

}
