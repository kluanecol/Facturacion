<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms;

use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeFormsInterface;
use App\Modules\Invoicing\ContractConfiguration\Repository\ContractConfigurationRepository;
use App\Modules\Admin\GeneralParametric\Repository\GeneralParametricRepository;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Invoicing\ConfigurationSubtype\Repository\ConfigurationSubtypeRepository;

class Activity implements ConfigurationSubtypeFormsInterface
{

    CONST ID_CONFIGURATION = 3;

    protected $contractConfigurationRepository;
    protected $generalParametricRepository;
    protected $configurationSubtypeRepository;

    function __construct()
    {
        $this->contractConfigurationRepository = new ContractConfigurationRepository();
        $this->generalParametricRepository = new GeneralParametricRepository();
        $this->configurationSubtypeRepository = new ConfigurationSubtypeRepository();
    }

    public function getForm($idContract)
    {
        $data = [];
        $currentActivities = $this->contractConfigurationRepository->getByContractAndSubtype($idContract, self::ID_CONFIGURATION)->pluck('fk_id_activity')->toArray();

        $data['idConfiguration'] = self::ID_CONFIGURATION;
        $data['idContract'] = $idContract;
        $data['activities'] = $this->generalParametricRepository->getActivitiesByCountry(GeneralVariables::getCurrentCountryId())
            ->whereNotIn('id',$currentActivities)
            ->sortBy('name')->pluck('name','id');

        return view('sections.contracts.configurations.form.subtypes.activity', $data)->render();
    }

    public function getList($idContract)
    {
        $data = [];

        $data['idConfiguration'] = self::ID_CONFIGURATION;
        $data['idContract'] = $idContract;
        $data['configurations'] = $this->contractConfigurationRepository->getByContractAndSubtype($idContract, self::ID_CONFIGURATION);

        return view('sections.contracts.configurations.list.subtypes.activity', $data)->render();
    }

    public function validate($request){

        $result = 200;

        $configuration = $this->configurationSubtypeRepository->getById(self::ID_CONFIGURATION);

        if ($configuration->multiple == 1) {
            $actualConfigurations = $this->contractConfigurationRepository->getActivityConfiguration($request->fk_id_contract, self::ID_CONFIGURATION, $request->fk_id_activity);

            if (is_object($actualConfigurations)) {

                $message = [
                    'title' => trans('messages\general.algoSalioMal'),
                    'message' =>trans('messages\contractConfiguration.yaEstaConfiguradaEstaActividad'),
                    'type'  => 'warning',
                    'status' => 400
                ];

                return $message;
            }
        }

        return $result;
    }

}
