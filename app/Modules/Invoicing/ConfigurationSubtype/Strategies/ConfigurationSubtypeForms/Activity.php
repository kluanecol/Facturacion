<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms;

use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeFormsInterface;
use App\Modules\Invoicing\ContractConfiguration\Repository\ContractConfigurationRepository;

class Activity implements ConfigurationSubtypeFormsInterface
{

    CONST ID_CONFIGURATION = 3;

    protected $contractConfigurationRepository;

    function __construct()
    {
        $this->contractConfigurationRepository = new ContractConfigurationRepository();
    }

    public function getForm($idContract)
    {
        $data = [];
        return view('sections.contracts.configurations.form.subtypes.activity', $data)->render();
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
        /*
        $configuration = $this->configurationSubtypeRepository->getById(self::ID_CONFIGURATION);

        if ($configuration->multiple == 0) {
            $actualConfigurations = $this->contractConfigurationRepository->getByContractAndSubtype($request->fk_id_contract, self::ID_CONFIGURATION);

            if ($actualConfigurations->count() > 0) {

                $message = [
                    'title' => trans('messages\general.algoSalioMal'),
                    'message' =>trans('messages\contractConfiguration.yaExisteLaConfiguracion'),
                    'type'  => 'warning',
                    'status' => 400
                ];

                return $message;
            }
        }
        */
        return $result;
    }

}
