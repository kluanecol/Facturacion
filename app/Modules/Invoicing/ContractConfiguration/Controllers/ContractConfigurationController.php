<?php

namespace App\Modules\Invoicing\ContractConfiguration\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Invoicing\ContractConfiguration\Repository\ContractConfigurationInterface;
use App\Modules\Invoicing\ConfigurationSubtype\Context\ConfigurationSubtypeFormsContext;

class ContractConfigurationController extends Controller
{
    private $contractConfigurationRepo;

    function __construct(
    ContractConfigurationInterface $contractConfigurationRepo
    )
    {
        $this->contractConfigurationRepo = $contractConfigurationRepo;
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
                    'title' => trans('messages\general.bienHecho'),
                    'message' => trans('messages\general.guardadoConExito'),
                    'type'  => 'success',
                    'status' => $result,
                    'id_configuration' => $idConfiguration
                ];
            }else if (is_string($result)) {
                $messages = [
                    'message' => $result,
                    'title' => trans('messages\general.errorNoControlado'),
                    'type'  => 'error',
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
                'title' => trans('messages\general.errorNoControlado'),
                'type'  => 'warning',
            ];
        }
        else if($result == 200){
            $messages = [
                'title' => trans('messages\general.bienHecho'),
                'message' => trans('messages\general.borradoConExito'),
                'type'  => 'success',
                'status' => $result,
                'id_configuration' => $request->id_configuration
            ];
        }else{
            $messages = [
                'message' => trans('messages\general.algoSalioMal'),
                'title' => trans('messages\general.errorAlEliminar'),
                'type'  => 'warning',
                'status' => $result,
                'id_configuration' => $request->id_configuration
            ];
        }
        return response()->json($messages);

    }


}
