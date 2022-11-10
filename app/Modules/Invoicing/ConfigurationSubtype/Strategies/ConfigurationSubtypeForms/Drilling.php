<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms;

use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeFormsInterface;
use App\Modules\Invoicing\ConfigurationSubtype\Repository\ConfigurationSubtypeRepository;
use App\Modules\Invoicing\ContractConfiguration\Repository\ContractConfigurationRepository;
use App\Modules\Invoicing\Parametric\Repository\ParametricRepository;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Admin\GeneralParametric\Repository\GeneralParametricRepository;

class Drilling implements ConfigurationSubtypeFormsInterface
{

    CONST ID_CONFIGURATION = 2;

    protected $parametricRepository;
    protected $configurationSubtypeRepository;
    protected $contractConfigurationRepository;
    protected $generalParametricRepository;

    function __construct()
    {
        $this->parametricRepository = new ParametricRepository();
        $this->configurationSubtypeRepository = new ConfigurationSubtypeRepository();
        $this->contractConfigurationRepository = new ContractConfigurationRepository();
        $this->generalParametricRepository = new GeneralParametricRepository();
    }

    public function getForm($idContract, $idContractConfiguration)
    {
        $data = [];
        $data['idConfiguration'] = self::ID_CONFIGURATION;
        $data['idContract'] = $idContract;
        $data['diameters'] = $this->generalParametricRepository->getDrillingDiameters(GeneralVariables::getCurrentCountryId())->sortBy('name')->pluck('name','id');
        $data['configurationCurrency'] = $this->contractConfigurationRepository->getByContractAndSubtype($idContract,GeneralVariables::ID_CONFIGURATION_CURRENCY, ['currency'])->first();
        $data['configurationSecondCurrency'] = $this->contractConfigurationRepository->getByContractAndSubtype($idContract,GeneralVariables::ID_CONFIGURATION_SECOND_CURRENCY, ['secondCurrency'])->first();

        if (isset($idContractConfiguration)) {
            $data['contractConfiguration'] = $this->contractConfigurationRepository->getById($idContractConfiguration);
        }

        return view('sections.contracts.configurations.form.subtypes.drilling', $data)->render();
    }

    public function getList($idContract)
    {
        $data = [];
        $data['idConfiguration'] = self::ID_CONFIGURATION;
        $data['idContract'] = $idContract;
        $data['configurations'] = $this->contractConfigurationRepository->getByContractAndSubtype($idContract, self::ID_CONFIGURATION)->sortBy('fk_id_parameter')->sortBy('initial_range');
        $data['configurationCurrency'] = $this->contractConfigurationRepository->getByContractAndSubtype($idContract,GeneralVariables::ID_CONFIGURATION_CURRENCY, ['currency'])->first();
        $data['configurationSecondCurrency'] = $this->contractConfigurationRepository->getByContractAndSubtype($idContract,GeneralVariables::ID_CONFIGURATION_SECOND_CURRENCY, ['secondCurrency'])->first();

        return view('sections.contracts.configurations.list.subtypes.drilling', $data)->render();
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

        if ($configuration->multiple == 1) {
            $result = $this->contractConfigurationRepository->isAValidRange($request->fk_id_contract, $request->fk_id_diameter, $request->initial_range, $request->final_range, $request->id);

            return $result;
        }

        return $result;
    }


}
