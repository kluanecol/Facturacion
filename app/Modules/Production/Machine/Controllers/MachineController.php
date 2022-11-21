<?php

namespace App\Modules\Production\Machine\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Production\Machine\Repository\MachineInterface;

class MachineController extends Controller
{
    protected $machineRepository;

    function __construct(
            MachineInterface $machineRepository
        )
        {
            $this->machineRepository = $machineRepository;
    }

}
