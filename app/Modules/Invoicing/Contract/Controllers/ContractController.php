<?php

namespace App\Modules\Invoicing\Contract\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Invoicing\Contract\Repository\ContractInterface;

class ContractController extends Controller
{
    private $contractRepository;
    protected $countryRepository;

    function __construct(
            ContractInterface $contractRepository
        )
        {
            $this->contractRepository = $contractRepository;
        }

    public function index(){
        $data = [];
        return view('sections.contracts.index', $data);
    }

    public function Search(Request $request){
        return $this->contractRepository->dataTableContracts($request);
    }

    public function getContractForm(Request $request){
        $data = [];

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
}
