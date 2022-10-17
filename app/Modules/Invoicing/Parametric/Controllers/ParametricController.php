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

    function __construct(
        ParametricInterface $parametricRepo
        )
        {
            $this->parametricRepo = $parametricRepo;
        }

}
