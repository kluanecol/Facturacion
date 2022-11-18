<?php

namespace App\Modules\Invoicing\Parametric\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Invoicing\Parametric\Repository\ParametricInterface;
use App\Modules\Admin\UserCountry\Repository\UserCountryInterface;
use App\Modules\Admin\Country\Repository\CountryInterface;

class ParametricController extends Controller
{
    private $parametricRepo;
    protected $userCountryRepo;
    protected $countryRepo;

    function __construct(
            ParametricInterface $parametricRepo,
            UserCountryInterface $userCountryRepo,
            CountryInterface $countryRepo
        )
    {
        $this->parametricRepo = $parametricRepo;
        $this->userCountryRepo = $userCountryRepo;
        $this->countryRepo = $countryRepo;
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
        $userCountries = $this->userCountryRepo->getCountriesByUser()->pluck('id')->toArray();
        $countries = $this->countryRepo->getAll()->pluck('id')->toArray();
        $result = $this->parametricRepo->save($request, $countries, $userCountries);

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

        $data = [];

        if (isset($request->id_parametric)) {
            $data['parametric'] = $this->parametricRepo->getById($request->id_parametric);
        }

        $data['parents'] = $this->parametricRepo->getAllParents()->sortBy('name')->pluck('name','id')->toArray();
        $data['auxiliary'] = $this->parametricRepo->getActiveChildren(GeneralVariables::ID_PARAMETRIC_MEASURES)->sortBy('name')->pluck('name','id')->toArray();
        $data['userCountries'] = $this->userCountryRepo->getCountriesByUser()->sortBy('name')->pluck('id')->toArray();
        $data['countries'] = $this->countryRepo->getAll()->sortBy('name')->pluck('name','id')->toArray();

        $returnHTML = view('sections.parametrics.form.form', $data)->render();

        return response()->json(['success' => true, 'html'=> $returnHTML]);
    }


    public function getOtherChargeForm(Request $request){

        $data['measures'] = $this->parametricRepo->getActiveChildren(GeneralVariables::ID_PARAMETRIC_MEASURES)->sortBy('name')->pluck('name','id')->toArray();

        $returnHTML = view('sections.parametrics.form.other-charge', $data)->render();

        return response()->json(['success' => true, 'html'=> $returnHTML]);
    }

    public function changeState(Request $request){
        $result = $this->parametricRepo->changeState($request);

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
                'message' => trans('general.estadoCambiadoExito'),
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
