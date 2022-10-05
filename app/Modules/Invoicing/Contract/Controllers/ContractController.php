<?php

namespace App\Modules\Invoicing\Contract\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Client\Repository\ClientInterface;
use App\Modules\Admin\Project\Repository\ProjectInterface;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Invoicing\Contract\Repository\ContractInterface;

use Session;

class ContractController extends Controller
{
    private $contractRepository;
    protected $projectRepository;
    protected $clientRepository;

    function __construct(
            ContractInterface $contractRepository,
            ProjectInterface $projectRepository,
            ClientInterface $clientRepository
        )
        {
            $this->contractRepository = $contractRepository;
            $this->projectRepository = $projectRepository;
            $this->clientRepository = $clientRepository;
        }

    public function index(){
        $data['projects'] = $this->projectRepository->getByCountry(GeneralVariables::getCurrentCountryId())->pluck('nombre_corto', 'id');
        $data['clients'] = $this->clientRepository->getByCountry(GeneralVariables::getCurrentCountryId())->pluck('nombre_cliente', 'id');
        $data['years'] = GeneralVariables::yearsArray();

        return view('sections.contracts.index', $data);
    }

    public function Search(Request $request){
        return $this->contractRepository->dataTableContracts($request);
    }

    public function getContractForm(Request $request){
        if (isset($request->id_contract)) {
            $data['contract'] = $this->contractRepository->getById($request->id_contract);
        }

        $data['projects'] = $this->projectRepository->getByCountry(GeneralVariables::getCurrentCountryId())->pluck('nombre_corto', 'id');
        $data['clients'] = $this->clientRepository->getByCountry(GeneralVariables::getCurrentCountryId())->pluck('nombre_cliente', 'id');
        $data['years'] = GeneralVariables::yearsArray();

        $returnHTML = view('sections.contracts.form.form', $data)->render();
        return response()->json(['success' => true, 'html'=>$returnHTML]);

    }

    public function save(Request $request){
        $result = $this->contractRepository->save($request);

        if (is_string($result)) {
            $mensajes = [
                'message' => $result,
                'title' => 'Error no controlado!',
                'type'  => 'warning',
            ];
        }
        else if($result == 200){
            $mensajes = [
                'title' => 'Bien hecho!',
                'message' => 'Datos guardados con éxito',
                'type'  => 'success',
                'status' => $result
            ];
        }else{
            $mensajes = [
                'message' => 'Algo salió Mal',
                'title' => 'No fue posible guardar los datos',
                'type'  => 'warning',
                'status' => $result
            ];
        }
        return response()->json($mensajes);

    }

    public function delete(Request $request){
        $result = $this->contractRepository->delete($request);

        if (is_string($result)) {
            $mensajes = [
                'message' => $result,
                'title' => 'Error no controlado!',
                'type'  => 'warning',
            ];
        }
        else if($result == 200){
            $mensajes = [
                'title' => 'Bien hecho!',
                'message' => 'Datos eliminados con éxito',
                'type'  => 'success',
                'status' => $result
            ];
        }else{
            $mensajes = [
                'message' => 'Algo salió Mal',
                'title' => 'No fue posible eliminar los datos',
                'type'  => 'warning',
                'status' => $result
            ];
        }
        return response()->json($mensajes);

    }

}
