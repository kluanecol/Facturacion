<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Client\Repository\ClientInterface;
use App\Modules\Admin\Project\Repository\ProjectInterface;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Invoicing\ConfigurationSubtype\Repository\ConfigurationSubtypeInterface;

use Session;

class ConfigurationSubtypeController extends Controller
{
    private $ConfigurationSubtypeRepository;
    protected $projectRepository;
    protected $clientRepository;

    function __construct(
            ConfigurationSubtypeInterface $contractRepository
        )
        {
            $this->contractRepository = $contractRepository;
    }

}
