<?php

namespace App\Modules\Invoicing\Contract\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Client\Repository\ClientInterface;
use App\Modules\Admin\Project\Repository\ProjectInterface;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Invoicing\Contract\Repository\ContractInterface;
use App\Modules\Invoicing\ConfigurationSubtype\Repository\ConfigurationSubtypeInterface;

use Session;

class ContractController extends Controller
{
    private $contractRepo;
    protected $projectRepo;
    protected $clientRepo;
    protected $configurationSubtypeRepo;

    function __construct(
            ContractInterface $contractRepo,
            ProjectInterface $projectRepo,
            ClientInterface $clientRepo,
            ConfigurationSubtypeInterface $configurationSubtypeRepo
        )
        {
            $this->contractRepo = $contractRepo;
            $this->projectRepo = $projectRepo;
            $this->clientRepo = $clientRepo;
            $this->configurationSubtypeRepo = $configurationSubtypeRepo;
        }

    public function index(){
        $data['projects'] = $this->projectRepo->getByCountry(GeneralVariables::getCurrentCountryId())->pluck('nombre_corto', 'id');
        $data['clients'] = $this->clientRepo->getByCountry(GeneralVariables::getCurrentCountryId())->pluck('nombre_cliente', 'id');
        $data['years'] = GeneralVariables::yearsArray();

        return view('sections.contracts.index', $data);
    }

    public function Search(Request $request){
        return $this->contractRepo->dataTableContracts($request);
    }

    public function getContractForm(Request $request){
        if (isset($request->id_contract)) {
            $data['contract'] = $this->contractRepo->getById($request->id_contract);
        }

        $data['projects'] = $this->projectRepo->getByCountry(GeneralVariables::getCurrentCountryId())->pluck('nombre_corto', 'id');
        $data['clients'] = $this->clientRepo->getByCountry(GeneralVariables::getCurrentCountryId())->pluck('nombre_cliente', 'id');
        $data['years'] = GeneralVariables::yearsArray();

        $returnHTML = view('sections.contracts.form.form', $data)->render();
        return response()->json(['success' => true, 'html'=>$returnHTML]);

    }

    public function save(Request $request){
        $result = $this->contractRepo->save($request);

        if (is_string($result)) {
            $messages = [
                'message' => $result,
                'title' => trans('messages\general.errorNoControlado'),
                'type'  => 'warning',
            ];
        }
        else if($result == 200){
            $messages = [
                'title' => trans('messages\general.bienHecho'),
                'message' => trans('messages\general.guardadoConExito'),
                'type'  => 'success',
                'status' => $result
            ];
        }else{
            $messages = [
                'message' => trans('messages\general.algoSalioMal'),
                'title' => trans('messages\general.errorAlGuardar'),
                'type'  => 'warning',
                'status' => $result
            ];
        }
        return response()->json($messages);

    }

    public function delete(Request $request){
        $result = $this->contractRepo->delete($request);

        if (is_string($result)) {
            $messages = [
                'message' => $result,
                'title' => trans('messages\general.errorNoControlado'),
                'type'  => 'warning',
            ];
        }
        else if($result == 200){
            $messages = [
                'title' => trans('messages\general.bienHecho'),
                'message' => trans('messages\general.borradoConExito'),
                'type'  => 'success',
                'status' => $result
            ];
        }else{
            $messages = [
                'message' => trans('messages\general.algoSalioMal'),
                'title' => trans('messages\general.errorAlEliminar'),
                'type'  => 'warning',
                'status' => $result
            ];
        }
        return response()->json($messages);

    }

    public function configuration($idContract){
        $data=[];

        $data['contract'] = $this->contractRepo->getById($idContract);
        $data['configurationSubtypes'] = $this->configurationSubtypeRepo->getActive();

        return view('sections.contracts.configurations.index', $data);
    }

}
