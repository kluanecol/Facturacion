<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms;

use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeFormsInterface;
use App\Modules\Invoicing\ConfigurationSubtype\Repository\ConfigurationSubtypeRepository;
use App\Modules\Invoicing\ContractConfiguration\Repository\ContractConfigurationRepository;
use App\Modules\Invoicing\Parametric\Repository\ParametricRepository;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Admin\GeneralParametric\Repository\GeneralParametricRepository;

class OtherCharge implements ConfigurationSubtypeFormsInterface
{

    CONST ID_CONFIGURATION = 8;

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

        if (isset($idContractConfiguration)) {
            $data['contractConfiguration'] = $this->contractConfigurationRepository->getById($idContractConfiguration);
        }

        $currentCharges = $this->contractConfigurationRepository->getByContractAndSubtype($idContract, self::ID_CONFIGURATION);

        if (isset($data['contractConfiguration'])) {
            $currentCharges = $currentCharges->whereNotIn('fk_id_parametric', [$data['contractConfiguration']->fk_id_parametric]);
        }


        $currentCharges = $currentCharges->pluck('fk_id_parametric')->toArray();

        $otherCharges = $this->parametricRepository->getActiveChildren(GeneralVariables::ID_PARAMETRIC_OTHER_CHARGES)->whereNotIn('id', $currentCharges)
        ->sortBy('name')->pluck('name_and_auxiliary_name','id')->toArray();

        $data['otherCharges'] = $otherCharges;

        $data['configurationCurrency'] = $this->contractConfigurationRepository->getByContractAndSubtype($idContract,GeneralVariables::ID_CONFIGURATION_CURRENCY, ['currency'])->first();
        $data['configurationSecondCurrency'] = $this->contractConfigurationRepository->getByContractAndSubtype($idContract,GeneralVariables::ID_CONFIGURATION_SECOND_CURRENCY, ['secondCurrency'])->first();

        if (isset($idContractConfiguration)) {
            $data['contractConfiguration'] = $this->contractConfigurationRepository->getById($idContractConfiguration);
        }

        return view('sections.contracts.configurations.form.subtypes.other-charge', $data)->render();
    }

    public function getList($idContract)
    {
        $data = [];
        $data['idConfiguration'] = self::ID_CONFIGURATION;
        $data['idContract'] = $idContract;
        $data['configurations'] = $this->contractConfigurationRepository->getByContractAndSubtype($idContract, self::ID_CONFIGURATION)->sortBy('fk_id_parameter')->sortBy('initial_range');
        $data['configurationCurrency'] = $this->contractConfigurationRepository->getByContractAndSubtype($idContract,GeneralVariables::ID_CONFIGURATION_CURRENCY, ['currency'])->first();
        $data['configurationSecondCurrency'] = $this->contractConfigurationRepository->getByContractAndSubtype($idContract,GeneralVariables::ID_CONFIGURATION_SECOND_CURRENCY, ['secondCurrency'])->first();

        return view('sections.contracts.configurations.list.subtypes.other-charge', $data)->render();
    }

    public function validate($request){

        $result = 200;

        $configuration = $this->configurationSubtypeRepository->getById(self::ID_CONFIGURATION);

        if ($configuration->multiple == 1 && $request->id == null) {
            $actualConfigurations = $this->contractConfigurationRepository->getChargeConfiguration($request->fk_id_contract, self::ID_CONFIGURATION, $request->fk_id_parametric, $request->id);

            if (is_object($actualConfigurations)) {

                $message = [
                    'title' => trans('general.algoSalioMal'),
                    'message' =>trans('contractConfiguration.yaEstaConfiguradoEsteCobro'),
                    'type'  => 'warning',
                    'status' => 400
                ];

                return $message;
            }
        }

        return $result;
    }


}
