<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms;

use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeFormsInterface;
use App\Modules\Invoicing\Parametric\Repository\ParametricRepository;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class Currency implements ConfigurationSubtypeFormsInterface
{

    protected $parametricRepository;

    function __construct()
    {
        $this->parametricRepository = new ParametricRepository();
    }


    public function getForm()
    {
        $data = [];
        $data['currencys'] = $this->parametricRepository->getActiveChildren(GeneralVariables::ID_PARAMETRIC_CURRENCY)->pluck('name','id');

        return view('sections.contracts.configurations.form.subtypes.currency', $data)->render();
    }


}
