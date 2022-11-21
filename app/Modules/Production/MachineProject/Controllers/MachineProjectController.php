<?php

namespace App\Modules\Production\MachineProject\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Production\MachineProject\Repository\MachineProjectInterface;

class MachineProjectController extends Controller
{
    protected $machineProjectRepository;

    function __construct(
            MachineProjectInterface $machineProjectRepository
        )
        {
            $this->machineProjectRepository = $machineProjectRepository;
    }

}
