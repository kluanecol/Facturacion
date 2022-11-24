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
use App\Modules\Production\Machine\Repository\MachineInterface;
use Maatwebsite\Excel\Facades\Excel;


class InvoiceController extends Controller
{
    private $invoiceRepo;
    private $machineProjectRepo;
    private $contractRepo;
    private $dailyRecordRepo;
    private $operationRecordRepo;
    private $machineRepo;

    function __construct(
            InvoiceInterface $invoiceRepo,
            MachineProjectInterface $machineProjectRepo,
            ContractInterface $contractRepo,
            DailyRecordInterface $dailyRecordRepo,
            OperationRecordInterface  $operationRecordRepo,
            MachineInterface $machineRepo
        )
        {
            $this->invoiceRepo = $invoiceRepo;
            $this->machineProjectRepo = $machineProjectRepo;
            $this->contractRepo = $contractRepo;
            $this->dailyRecordRepo = $dailyRecordRepo;
            $this->operationRecordRepo = $operationRecordRepo;
            $this->machineRepo = $machineRepo;
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

    public function generatePreview($idInvoice){

        $invoice = $this->invoiceRepo->getById($idInvoice, ['contract']);
        $contract = $invoice->contract->load('client','project');
        $machines = $this->machineRepo->getByIdsArray($invoice->json_fk_machines);
        $dailyRecords = $this->dailyRecordRepo->getIdsByInvoiceObjectAndProjectId($invoice, $contract->fk_id_project);

        Excel::load(public_path('excel_templates/INVOICE_V1.xlsx'), function ($file) use ($contract, $invoice, $dailyRecords, $machines) {

            $file->setTitle('INVOICE-'.$contract->project->name."(".$invoice->initial_period."-".$invoice->end_period.")");

            foreach ($invoice->json_fk_machines as $key => $machineId) {

                $operationRecords = $this->operationRecordRepo->getByDailyRecordsIds($dailyRecords->where('id_maquina',$machineId)->pluck('id')->toArray());

                if ($operationRecords->count() > 0) {
                    foreach ($invoice->json_fk_pits as $key => $pitName) {

                        $machinePitOperation =$operationRecords->where('hoyo', $pitName);

                        if ($machinePitOperation->count() > 0) {

                            $machine = $machines->where('id', $machineId)->first();

                            $workSheet = clone $file->getSheet(0);
                            $workSheet->setTitle($machine->name." - ".$pitName);

                            $workSheet->setCellValue('I4',strtoupper($machine->name));
                            $workSheet->setCellValue('N3', strtoupper($contract->client->name));
                            $workSheet->setCellValue('N4', strtoupper($contract->project->name));
                            $workSheet->setCellValue('N6', strtoupper($contract->project->location));
                            //pit data
                            $workSheet->setCellValue('W3', strtoupper($pitName));

                            //$workSheet->getRowDimension(24)->setVisible(false);

                            $file->addSheet($workSheet);
                        }

                    }
                }
            }


        })->export('xlsx');
    }
}
