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
        $idContract = $request->input('id_contract');

        $strategySubtypeConfiguration = ConfigurationSubTypeFormsContext::STRATEGY[$idConfiguration];

        $returnHTML = (new $strategySubtypeConfiguration)->getForm($idContract,  $request->input('id_contract_configuration'));
        return response()->json(['success' => true, 'html'=>$returnHTML]);
    }

}
