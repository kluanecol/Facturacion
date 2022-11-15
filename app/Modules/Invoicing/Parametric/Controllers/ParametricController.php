<?php

namespace App\Modules\Invoicing\Parametric\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Invoicing\Parametric\Repository\ParametricInterface;

use Session;

class ParametricController extends Controller
{
    private $parametricRepo;

    function __construct(ParametricInterface $parametricRepo)
    {
        $this->parametricRepo = $parametricRepo;
    }

    public function save(Request $request)
    {
        $result = $this->parametricRepo->save($request);

        if($result == 200){
            $messages = [
                'title' => trans('general.bienHecho'),
                'message' => trans('general.guardadoConExito'),
                'type'  => 'success',
                'status' => $result,
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
    }

    public function getOtherChargeForm(Request $request){

        $data['measures'] = $this->parametricRepo->getActiveChildren(GeneralVariables::ID_PARAMETRIC_MEASURES)->sortBy('name')->pluck('name','id')->toArray();

        $returnHTML = view('sections.parametrics.form.other-charge', $data)->render();

        return response()->json(['success' => true, 'html'=> $returnHTML]);
    }
}
