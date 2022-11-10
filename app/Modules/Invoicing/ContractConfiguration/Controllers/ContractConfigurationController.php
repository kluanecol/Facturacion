<?php

namespace App\Modules\Invoicing\ContractConfiguration\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Invoicing\ContractConfiguration\Repository\ContractConfigurationInterface;
use App\Modules\Invoicing\ConfigurationSubtype\Context\ConfigurationSubtypeFormsContext;
use App\Modules\Invoicing\ConfigurationSubtype\Repository\ConfigurationSubtypeInterface;

class ContractConfigurationController extends Controller
{
    private $contractConfigurationRepo;
    private $contractConfigurationSubtypeRepo;

    function __construct(
        ContractConfigurationInterface $contractConfigurationRepo,
        ConfigurationSubtypeInterface $contractConfigurationSubtypeRepo
    )
    {
        $this->contractConfigurationRepo = $contractConfigurationRepo;
        $this->contractConfigurationSubtypeRepo = $contractConfigurationSubtypeRepo;
    }


    public function save(Request $request)
    {
        $idConfiguration = $request->input('fk_id_configuration_subtype');

        $strategyConfiguration = ConfigurationSubTypeFormsContext::STRATEGY[$idConfiguration];

        $validate = (new $strategyConfiguration)->validate($request);

        if ($validate == 200) {
            $result = $this->contractConfigurationRepo->save($request);

            if($result == 200){
                $messages = [
                    'title' => trans('general.bienHecho'),
                    'message' => trans('general.guardadoConExito'),
                    'type'  => 'success',
                    'status' => $result,
                    'id_configuration' => $idConfiguration
                ];
            }else if (is_string($result)) {
                $messages = [
                    'message' => $result,
                    'title' => trans('general.errorNoControlado'),
                    'type'  => 'error',
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

        }else{
            return response()->json($validate);
        }
    }

    public function getList(Request $request){
        $idConfiguration = $request->input('id_configuration');
        $idContract = $request->input('id_contract');

        $strategySubtypeConfiguration = ConfigurationSubTypeFormsContext::STRATEGY[$idConfiguration];

        $returnHTML = (new $strategySubtypeConfiguration)->getlist($idContract);
        return response()->json(['success' => true, 'html'=> $returnHTML, 'id_configuration' => $idConfiguration]);
    }

    public function delete(Request $request){
        $result = $this->contractConfigurationRepo->delete($request);

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
                'status' => $result,
                'id_configuration' => $request->id_configuration
            ];
        }else{
            $messages = [
                'message' => trans('general.algoSalioMal'),
                'title' => trans('general.errorAlEliminar'),
                'type'  => 'warning',
                'status' => $result,
                'id_configuration' => $request->id_configuration
            ];
        }
        return response()->json($messages);

    }

    public function reloadProgressBar(Request $request){
        $percentage = 0;
        $contractConfigurations = $this->contractConfigurationRepo->getContractConfigurationsByIdContract($request->id_contract)->groupBy('fk_id_configuration_subtype');
        $globalCurrentSettings =  $this->contractConfigurationSubtypeRepo->getActive();

        if ($globalCurrentSettings->count() > 0) {
            $percentage = round(($contractConfigurations->count()*100)/$globalCurrentSettings->count(),2);
        }

        $data['percentage'] = $percentage;
        $data['success'] = true;


        return response()->json($data);

    }


}
