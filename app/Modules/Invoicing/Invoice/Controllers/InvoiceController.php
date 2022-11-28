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
use App\Modules\Admin\GeneralParametric\Repository\GeneralParametricInterface;
use App\Modules\Production\ActivityRecord\Repository\ActivityRecordInterface;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    private $invoiceRepo;
    private $machineProjectRepo;
    private $contractRepo;
    private $dailyRecordRepo;
    private $operationRecordRepo;
    private $machineRepo;
    private $activityRecordRepo;

    function __construct(
            InvoiceInterface $invoiceRepo,
            MachineProjectInterface $machineProjectRepo,
            ContractInterface $contractRepo,
            DailyRecordInterface $dailyRecordRepo,
            OperationRecordInterface  $operationRecordRepo,
            MachineInterface $machineRepo,
            GeneralParametricInterface $generalParametricRepo,
            ActivityRecordInterface $activityRecordRepo
        )
        {
            $this->invoiceRepo = $invoiceRepo;
            $this->machineProjectRepo = $machineProjectRepo;
            $this->contractRepo = $contractRepo;
            $this->dailyRecordRepo = $dailyRecordRepo;
            $this->operationRecordRepo = $operationRecordRepo;
            $this->machineRepo = $machineRepo;
            $this->generalParametricRepo = $generalParametricRepo;
            $this->activityRecordRepo = $activityRecordRepo;
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

            //$file->setTitle('INVOICE-'.$contract->project->name."(".$invoice->initial_period."-".$invoice->end_period.")");

            foreach ($invoice->json_fk_machines as $key => $machineId) {

                $machineDailyRecords = $dailyRecords->where('id_maquina',$machineId);
                $operationRecords = $this->operationRecordRepo->getByDailyRecordsIds($machineDailyRecords->where('id_maquina',$machineId)->pluck('id')->toArray());
                $activityRecords = $this->activityRecordRepo->getByDailyRecordsIds($machineDailyRecords->where('id_maquina',$machineId)->pluck('id')->toArray());


                if ($operationRecords->count() > 0) {
                    foreach ($invoice->json_fk_pits as $key => $pitName) {

                        $machinePitOperation = $operationRecords->where('hoyo', $pitName);

                        if ($machinePitOperation->count() > 0) {

                            $machine = $machines->where('id', $machineId)->first();
                            $initialDate = Carbon::parse($invoice->initial_period);
                            $finalDate = Carbon::parse($invoice->end_period);
                            $days = $initialDate->diffInDays($finalDate);

                            $workSheet = clone $file->getSheet(0);
                            $workSheet->setTitle($machine->name." - ".$pitName);

                            //SHEET HEADER
                            $workSheet->setCellValue('I4',strtoupper($machine->name));
                            $workSheet->setCellValue('N3', strtoupper($contract->client->name));
                            $workSheet->setCellValue('N4', strtoupper($contract->project->name));
                            $workSheet->setCellValue('N6', strtoupper($contract->project->location));
                            //pit data
                            $workSheet->setCellValue('W3', strtoupper($pitName));
                            $workSheet->setCellValue('W4', strtoupper($operationRecords->first()->angle));
                            //Table row headers
                            $workSheet->setCellValue('G8',  Carbon::parse($invoice->initial_period)->format('d/m/Y'));

                            //DIAMETERS
                            $diameters = $this->generalParametricRepo->getByIdsArray($machinePitOperation->pluck('id_param_diametro')->unique());
                            $row = 12;
                            $drillingRowsLimit = 42;
                            for ($i=($row + ($diameters->count()*3)); $i < ($drillingRowsLimit); $i++) {
                                $workSheet->getRowDimension($i)->setVisible(false);
                            }
                            //Drilling rows
                            foreach ($diameters as $diameter) {
                                //DRILLING AND CASING ROWS
                                $col = "D";
                                $workSheet->setCellValue($col.$row, strtoupper($diameter->name));
                                $operations = $machinePitOperation->where('id_param_diametro', $diameter->id);
                                $dailys = $machineDailyRecords->whereIn('id',$operationRecords->pluck('id_prod_registro_diario'));
                                $currentDay = Carbon::parse($invoice->initial_period);

                                $col = "G";
                                for ($i=0; $i <= $days ; $i++) {

                                    $currentDayRecord = $dailys->where('fecha_registro',$currentDay->format('Y-m-d'));

                                    if ($currentDayRecord->isNotEmpty()) {

                                        $dayShift = $currentDayRecord->whereIn('id_param_turno',GeneralVariables::ARRAY_ID_PARAMETRIC_DAY_SHIFT)->first();
                                        if($dayShift){

                                            $dayShiftOperation = $operations->where('id_prod_registro_diario',$dayShift->id)->first();
                                            if($dayShiftOperation){
                                                $workSheet->setCellValue($col.$row, $dayShiftOperation->from);
                                                $workSheet->setCellValue($col.($row + 1), $dayShiftOperation->to);
                                            }
                                        }

                                        $nightShift = $currentDayRecord->whereIn('id_param_turno',GeneralVariables::ARRAY_ID_PARAMETRIC_NIGHT_SHIFT)->first();
                                        $col++;$col++;
                                        if($nightShift){
                                            $nightShiftOperation = $operations->where('id_prod_registro_diario',$nightShift->id)->first();
                                            if($nightShiftOperation){
                                                $workSheet->setCellValue($col.$row, $nightShiftOperation->from);
                                                $workSheet->setCellValue($col.($row+1), $nightShiftOperation->to);
                                            }
                                        }

                                        $col++;$col++;
                                        $currentDay->addDay();
                                    }
                                    else {
                                        $col++;$col++;$col++;$col++;
                                        $currentDay = $currentDay->addDay();

                                    }
                                }

                                $row = $row + 3;
                            }

                            //ACTIVITIES
                            $activities = $this->generalParametricRepo->getByIdsArray($machinePitOperation->pluck('id_param_diametro')->unique());
                            $row = 12;
                            $drillingRowsLimit = 42;

                            if($activityRecords->count() > 0){
                                dd($activityRecords[0]);
                            }

                            $file->addSheet($workSheet);
                        }

                    }
                }



            }

            $file->removeSheetByIndex(0);

        })->export('xlsx');
    }
}
