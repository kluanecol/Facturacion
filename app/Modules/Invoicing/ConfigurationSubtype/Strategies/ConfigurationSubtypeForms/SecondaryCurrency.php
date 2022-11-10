<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms;

use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeFormsInterface;
use App\Modules\Invoicing\ConfigurationSubtype\Repository\ConfigurationSubtypeRepository;
use App\Modules\Invoicing\ContractConfiguration\Repository\ContractConfigurationRepository;
use App\Modules\Invoicing\Parametric\Repository\ParametricRepository;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class SecondaryCurrency implements ConfigurationSubtypeFormsInterface
{

    CONST ID_CONFIGURATION = 6;

    protected $parametricRepository;
    protected $configurationSubtypeRepository;
    protected $contractConfigurationRepository;

    function __construct()
    {
        $this->parametricRepository = new ParametricRepository();
        $this->configurationSubtypeRepository = new ConfigurationSubtypeRepository();
        $this->contractConfigurationRepository = new ContractConfigurationRepository();
    }


    public function getForm($idContract, $idContractConfiguration)
    {
        $data = [];
        $data['idConfiguration'] = self::ID_CONFIGURATION;
        $data['idContract'] = $idContract;
        $data['currencys'] = $this->parametricRepository->getActiveChildren(GeneralVariables::ID_PARAMETRIC_CURRENCY)->pluck('name','id');

        if (isset($idContractConfiguration)) {
            $data['contractConfiguration'] = $this->contractConfigurationRepository->getById($idContractConfiguration);
        }

        return view('sections.contracts.configurations.form.subtypes.currency', $data)->render();
    }

    public function getList($idContract)
    {
        $data = [];
        $data['idConfiguration'] = self::ID_CONFIGURATION;
        $data['idContract'] = $idContract;
        $data['configurations'] = $this->contractConfigurationRepository->getByContractAndSubtype($idContract, self::ID_CONFIGURATION);

        return view('sections.contracts.configurations.list.subtypes.currency', $data)->render();
    }

    public function validate($request){

        $result = 200;
        $configuration = $this->configurationSubtypeRepository->getById(self::ID_CONFIGURATION);

        if ($configuration->multiple == 0 && $request->id == null ) {
            $actualConfigurations = $this->contractConfigurationRepository->getByContractAndSubtype($request->fk_id_contract, self::ID_CONFIGURATION);

            if ($actualConfigurations->count() > 0) {

                $message = [
                    'title' => trans('general.algoSalioMal'),
                    'message' =>trans('contractConfiguration.yaExisteLaConfiguracion'),
                    'type'  => 'warning',
                    'status' => 400
                ];

                return $message;
            }
        }

        return $result;
    }

}
