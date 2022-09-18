<?php

namespace App\Modules\Invoicing\Contract\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    private $contractRepository;
    protected $countryRepository;
/*
    function __construct(
            TipoPagoProductoInterface $contractRepository,
            CountryInterface $countryRepository
        )
        {
            $this->contractRepository = $contractRepository;
            $this->countryRepository = $countryRepository;
        }
*/
    public function index(){
        $data = [];

       dd("Index Contracts");
    }
}
