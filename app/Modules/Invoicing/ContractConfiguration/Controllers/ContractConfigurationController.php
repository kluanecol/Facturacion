<?php

namespace App\Modules\Invoicing\ContractConfiguration\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Invoicing\ContractConfiguration\Repository\ContractConfigurationInterface;

class ContractConfigurationController extends Controller
{
    private $contractConfigurationRepo;

    function __construct(
        ContractConfigurationInterface $contractConfigurationRepo
        )
        {
            $this->contractConfigurationRepo = $contractConfigurationRepo;
        }

}
