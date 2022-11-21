<?php

namespace App\Modules\Invoicing\Invoice\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Client\Repository\ClientInterface;
use App\Modules\Admin\Project\Repository\ProjectInterface;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Invoicing\Invoice\Repository\InvoiceInterface;
use App\Modules\Invoicing\Contract\Repository\ContractInterface;

use Session;

class InvoiceController extends Controller
{
    private $invoiceRepo;
    protected $projectRepo;
    private $contractRepo;

    function __construct(
            InvoiceInterface $invoiceRepo,
            ProjectInterface $projectRepo,
            ContractInterface $contractRepo
        )
        {
            $this->invoiceRepo = $invoiceRepo;
            $this->projectRepo = $projectRepo;
            $this->contractRepo = $contractRepo;
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

    public function getInvoiceForm(Request $request){
        if (isset($request->id_contract)) {
            $data['contract'] = $this->invoiceRepo->getById($request->id_contract);
        }

        $data['projects'] = $this->projectRepo->getByCountry(GeneralVariables::getCurrentCountryId())->pluck('nombre_corto', 'id');
        $data['clients'] = $this->clientRepo->getByCountry(GeneralVariables::getCurrentCountryId())->pluck('nombre_cliente', 'id');
        $data['years'] = GeneralVariables::yearsArray();

        $returnHTML = view('sections.contracts.form.form', $data)->render();
        return response()->json(['success' => true, 'html'=>$returnHTML]);

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

    public function configuration($idInvoice){
        $data=[];
        $percentage = 0;

        $contractConfigurations = $this->contractConfigurationRepo->getInvoiceConfigurationsByIdInvoice($idInvoice)->groupBy('fk_id_configuration_subtype');
        $globalCurrentSettings =  $this->configurationSubtypeRepo->getActive();

        if ($globalCurrentSettings->count() > 0) {
            $percentage = ($contractConfigurations->count()*100)/$globalCurrentSettings->count();
        }

        $data['contract'] = $this->invoiceRepo->getById($idInvoice);
        $data['configurationSubtypes'] = $this->configurationSubtypeRepo->getActive();
        $data['percentage'] = round($percentage, 1);

        return view('sections.contracts.configurations.index', $data);
    }

}
