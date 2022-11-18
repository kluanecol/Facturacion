<?php

namespace App\Modules\Invoicing\Parametric\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Invoicing\Parametric\Repository\ParametricInterface;
use App\Modules\Admin\UserCountry\Repository\UserCountryInterface;

class ParametricController extends Controller
{
    private $parametricRepo;
    protected $userCountryRepo;

    function __construct(
            ParametricInterface $parametricRepo,
            UserCountryInterface $userCountryRepo
        )
    {
        $this->parametricRepo = $parametricRepo;
        $this->userCountryRepo = $userCountryRepo;
    }

    public function index(){
        $data = [];

        $data['countries'] = $this->userCountryRepo->getCountriesByUser()->sortBy('name')->pluck('name','id_country');
        $data['parametricParents'] = $this->parametricRepo->getAllParents()->pluck('name','id');

        return view('sections.parametrics.index', $data);
    }

    public function Search(Request $request){
        return $this->parametricRepo->dataTableChildrenParametrics($request);
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

    public function getParametricForm(Request $request){

        $data['parents'] = $this->parametricRepo->getAllParents()->sortBy('name')->pluck('name','id')->toArray();
        $data['auxiliary'] = $this->parametricRepo->getActiveChildren(GeneralVariables::ID_PARAMETRIC_MEASURES)->sortBy('name')->pluck('name','id')->toArray();
        $data['countries'] = $this->userCountryRepo->getCountriesByUser()->sortBy('name')->pluck('name','id')->toArray();

        $returnHTML = view('sections.parametrics.form.form', $data)->render();

        return response()->json(['success' => true, 'html'=> $returnHTML]);
    }


    public function getOtherChargeForm(Request $request){

        $data['measures'] = $this->parametricRepo->getActiveChildren(GeneralVariables::ID_PARAMETRIC_MEASURES)->sortBy('name')->pluck('name','id')->toArray();

        $returnHTML = view('sections.parametrics.form.other-charge', $data)->render();

        return response()->json(['success' => true, 'html'=> $returnHTML]);
    }
}
