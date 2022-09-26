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

}
