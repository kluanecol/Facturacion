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
use App\Modules\Invoicing\InvoiceConfiguration\Repository\InvoiceConfigurationInterface;
use App\Modules\Invoicing\ContractConfiguration\Repository\ContractConfigurationInterface;

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
    private $invoiceConfigurationRepo;
    private $contractConfigurationRepo;

    function __construct(
            InvoiceInterface $invoiceRepo,
            MachineProjectInterface $machineProjectRepo,
            ContractInterface $contractRepo,
            DailyRecordInterface $dailyRecordRepo,
            OperationRecordInterface  $operationRecordRepo,
            MachineInterface $machineRepo,
            GeneralParametricInterface $generalParametricRepo,
            ActivityRecordInterface $activityRecordRepo,
            InvoiceConfigurationInterface $invoiceConfigurationRepo,
            ContractConfigurationInterface $contractConfigurationRepo
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
            $this->invoiceConfigurationRepo = $invoiceConfigurationRepo;
            $this->contractConfigurationRepo = $contractConfigurationRepo;
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
        $data['isNewVersion'] = 0;
        $data['version'] = 1;

        $returnHTML = view('sections.invoices.form.general-form', $data)->render();
        return response()->json(['success' => true, 'html'=>$returnHTML]);

    }

    public function getNewInvoiceVersionForm(Request $request){

        $invoice = $this->invoiceRepo->getById($request->id_invoice);

        $data['contract'] = $this->contractRepo->getById($invoice->fk_id_contract);
        $data['machines'] = $this->machineProjectRepo->getByActiveByProjectId( $data['contract']->fk_id_project, ['machine'])->pluck('machine.code_name','machine.id');
        $data['invoice'] = $invoice;
        $data['isNewVersion'] = 1;
        $data['version'] = 2 + $invoice->versions->count();


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

        $initialDate = Carbon::parse($request->initial_period);
        $finalDate = Carbon::parse($request->end_period);

        if($initialDate->diffInDays($finalDate) > 16){
            return  $response = [
                'message' => trans('general.errorAlGuardar'),
                'title' => trans('invoices.periodoDeFacturacionMuyLargo')
            ];
        }

        if($request->is_new_version == false){
            if($this->invoiceRepo->getByContractAndPeriod($request->fk_id_contract, $request->initial_period, $request->end_period)->count() > 0){
                return  $response = [
                    'message' => trans('general.errorAlGuardar'),
                    'title' =>  trans('invoices.periodoDeFacturacionRepetido')
                ];
            }
        }


        $result = $this->invoiceRepo->save($request);

        if (is_string($result)) {
            $response = [
                'message' => $result,
                'title' => trans('general.errorNoControlado'),
                'type'  => 'warning',
            ];
        }
        else if($result == 200){
            $response = [
                'title' => trans('general.bienHecho'),
                'message' => trans('general.guardadoConExito'),
                'type'  => 'success',
                'status' => $result
            ];
        }else{
            $response = [
                'message' => trans('general.algoSalioMal'),
                'title' => trans('general.errorAlGuardar'),
                'type'  => 'warning',
                'status' => $result
            ];
        }
        return response()->json($response);

    }

    public function delete(Request $request){
        $result = $this->invoiceRepo->delete($request);

        if (is_string($result)) {
            $response = [
                'message' => $result,
                'title' => trans('general.errorNoControlado'),
                'type'  => 'warning',
            ];
        }
        else if($result == 200){
            $response = [
                'title' => trans('general.bienHecho'),
                'message' => trans('general.borradoConExito'),
                'type'  => 'success',
                'status' => $result
            ];
        }else{
            $response = [
                'message' => trans('general.algoSalioMal'),
                'title' => trans('general.errorAlEliminar'),
                'type'  => 'warning',
                'status' => $result
            ];
        }
        return response()->json($response);

    }


    public function getConfigurationInvoiceForm($idInvoice){
        $data = [];
        $invoice = $this->invoiceRepo->getById($idInvoice, ['configurations']);
        $contract = $this->contractRepo->getById($invoice->fk_id_contract, ['configurations']);

        $otherChargesConfiguration = $contract->configurations->where('fk_id_configuration_subtype', GeneralVariables::ID_CONFIGURATION_OTHER_CHARGE);

        if($otherChargesConfiguration->count() > 0){
            $data['contract'] = $contract;
            $data['invoice'] = $invoice;
            $data['otherChargeConfigurations'] = $otherChargesConfiguration->load('charge');
            $data['invoiceConfigurations'] = $invoice->configurations->where('fk_id_configuration_subtype', GeneralVariables::ID_CONFIGURATION_OTHER_CHARGE);

            $returnHTML = view('sections.invoices.form.configuration-form', $data)->render();
            return response()->json(['status' => 200, 'html'=> $returnHTML]);

        }else{
            $response = [
                'title' => trans('invoices.noEsPosibleConfigurarLaFactura'),
                'message' => trans('invoices.elContratoNoHaSidoConfigurado'),
                'status' => 400
            ];
            return response()->json($response);
        }
    }

    public function saveConfiguration(Request $request){

        $result = 200;
        foreach($request->invoice_configurations as $configuration){

            $contractConfiguration = $this->contractConfigurationRepo->getById($configuration['fk_id_configuration'])->makeHidden(['id','fk_id_contract','fk_id_user']);
            $result = $this->invoiceConfigurationRepo->saveConfiguration($configuration, $contractConfiguration, $request->fk_id_invoice, $configuration['fk_id_configuration']);
        }

        if (is_string($result)) {
            $response = [
                'message' => $result,
                'title' => trans('general.errorNoControlado'),
                'type'  => 'warning',
            ];
        }
        else if($result == 200){
            $response = [
                'title' => trans('general.bienHecho'),
                'message' => trans('general.guardadoConExito'),
                'type'  => 'success',
                'status' => $result
            ];
        }else{
            $response = [
                'message' => trans('general.algoSalioMal'),
                'title' => trans('general.errorAlGuardar'),
                'type'  => 'warning',
                'status' => $result
            ];
        }
        return response()->json($response);

    }

    public function generatePreview($idInvoice){

        $invoice = $this->invoiceRepo->getById($idInvoice, ['contract']);
        $contract = $invoice->contract->load('client','project','configurations.diameter');
        $machines = $this->machineRepo->getByIdsArray($invoice->json_fk_machines);
        $dailyRecords = $this->dailyRecordRepo->getIdsByInvoiceObjectAndProjectId($invoice, $contract->fk_id_project);
        $drillingConfigurations = $contract->configurations->whereIn('fk_id_configuration_subtype', [GeneralVariables::ID_CONFIGURATION_DRILLING,GeneralVariables::ID_CONFIGURATION_CASING]);
        $currency = $contract->configurations->whereIn('fk_id_configuration_subtype', [GeneralVariables::ID_CONFIGURATION_CURRENCY])->first();

        Excel::load(public_path('excel_templates/INVOICE_V1.xlsx'), function ($file) use ($contract, $invoice, $dailyRecords, $machines, $drillingConfigurations, $currency) {

            //$file->getProperties()->setTitle('INVOICE-'.$contract->project->name."(".$invoice->initial_period."-".$invoice->end_period.")");

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

                            //HEADERS DRILLING AND CASING CONFIGURATION TABLE
                            $row = 124;
                            $workSheet->setCellValue('E'.$row, isset($currency) ? "TOTAL ".$currency->currency->description : "TOTAL");
                            $workSheet->setCellValue('L'.$row, isset($currency) ? trans('invoices.PRECIO')." ".$currency->currency->description : trans('invoices.PRECIO'));
                            $workSheet->setCellValue('M'.$row, isset($currency) ? "TOTAL ".$currency->currency->description : "TOTAL");

                            //DRILLING AND CASING CONFIGURATION TABLE
                            $row = 126;
                            $initialRow = $row;
                            foreach ($drillingConfigurations->groupBy('fk_id_diameter') as $configurationGroup) {

                                $configurationDiameter = $configurationGroup->first();

                                $workSheet->setCellValue('C'.$row, $configurationDiameter->diameter->name);
                                $workSheet->setCellValue('D'.$row, $machinePitOperation->where('id_param_diametro', $configurationDiameter->diameter->id)->sum('total'));

                                foreach ($configurationGroup->sortBy('initial_range') as $configuration) {
                                    $workSheet->setCellValue('F'.$row, $configuration->initial_range);
                                    $workSheet->setCellValue('G'.$row, $configuration->final_range);
                                    /*
                                    $workSheet->setCellValue('I'.$row,
                                        $machinePitOperation->where('id_param_diametro',$idConfigurationDiameter)->sum('total')
                                    );
                                    */
                                    $workSheet->setCellValue('L'.$row, $configuration->value);

                                    $row++;
                                }

                                if ($configurationGroup->count() > 1) {
                                    $workSheet->mergeCells('C'.$initialRow.':C'.($row - 1));
                                    $workSheet->mergeCells('D'.$initialRow.':D'.($row - 1));
                                    $workSheet->mergeCells('E'.$initialRow.':E'.($row - 1));
                                    $initialRow = $row;
                                }

                            }

                            $rowsLimit = 176;
                            for ($i=($row); $i <= ($rowsLimit); $i++) {
                                $workSheet->getRowDimension($i)->setVisible(false);
                            }

                            /*ACTIVITIES
                            $activities = $this->generalParametricRepo->getByIdsArray($machinePitOperation->pluck('id_param_diametro')->unique());
                            $row = 12;
                            $drillingRowsLimit = 42;

                            if($activityRecords->count() > 0){
                                dd($activityRecords[0]);
                            }
                            */

                            $file->addSheet($workSheet);
                        }

                    }
                }



            }

            $file->removeSheetByIndex(0);

        })->export('xlsx');
    }
}
