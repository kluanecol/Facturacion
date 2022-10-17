<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Client\Repository\ClientInterface;
use App\Modules\Admin\Project\Repository\ProjectInterface;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Invoicing\ConfigurationSubtype\Repository\ConfigurationSubtypeInterface;
use App\Modules\Invoicing\ConfigurationSubtype\Context\ConfigurationSubtypeFormsContext;

use Session;

class ConfigurationSubtypeController extends Controller
{
    private $ConfigurationSubtypeRepository;
    protected $parametricRepository;

    function __construct(
            ConfigurationSubtypeInterface $contractRepository
        )
        {
            $this->contractRepository = $contractRepository;
    }


    public function getForm(Request $request)
    {
        $idConfiguration = $request->input('id_configuration');

        $strategyClass = ConfigurationSubTypeFormsContext::STRATEGY[$idConfiguration];

        $returnHTML = (new $strategyClass)->getForm();
        return response()->json(['success' => true, 'html'=>$returnHTML]);

        return (new $strategyClass)->getForm();
    }

}
