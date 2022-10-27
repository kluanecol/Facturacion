<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms;

use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeFormsInterface;
use App\Modules\Invoicing\ContractConfiguration\Repository\ContractConfigurationRepository;
use App\Modules\Admin\GeneralParametric\Repository\GeneralParametricRepository;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Invoicing\ConfigurationSubtype\Repository\ConfigurationSubtypeRepository;
use App\Modules\Admin\ConsumableGroup\Repository\ConsumableGroupRepository;
use App\Modules\Admin\Consumable\Repository\ConsumableRepository;

class Product implements ConfigurationSubtypeFormsInterface
{

    CONST ID_CONFIGURATION = 5;

    protected $contractConfigurationRepository;
    protected $generalParametricRepository;
    protected $configurationSubtypeRepository;
    protected $consumableGroupRepository;
    protected $consumableRepository;

    function __construct()
    {
        $this->contractConfigurationRepository = new ContractConfigurationRepository();
        $this->generalParametricRepository = new GeneralParametricRepository();
        $this->configurationSubtypeRepository = new ConfigurationSubtypeRepository();
        $this->consumableGroupRepository = new ConsumableGroupRepository();
        $this->consumableRepository = new ConsumableRepository();
    }

    public function getForm($idContract, $idContractConfiguration)
    {
        $data = [];

        if (isset($idContractConfiguration)) {
            $data['contractConfiguration'] = $this->contractConfigurationRepository->getById($idContractConfiguration);
            $data['consumables'] = $this->consumableRepository->getByGroupId($data['contractConfiguration']->product->group->id)->sortBy('name')->pluck('name','id');
        }

        $currentProducts = $this->contractConfigurationRepository->getByContractAndSubtype($idContract, self::ID_CONFIGURATION);
        /*
        if (isset($data['contractConfiguration'])) {
            $currentProducts = $currentProducts->whereNotIn('fk_id_product', [$data['contractConfiguration']->fk_id_product]);
        }

        $currentProducts = $currentProducts->pluck('fk_id_product')->toArray();
        */
        $data['idConfiguration'] = self::ID_CONFIGURATION;
        $data['idContract'] = $idContract;
        $data['consumableGroups'] = $this->consumableGroupRepository->getByCountry(GeneralVariables::getCurrentCountryId())
            //->whereNotIn('id', $currentProducts)
            ->push(" ")->sortBy('name')->pluck('nombre','id');

        return view('sections.contracts.configurations.form.subtypes.product', $data)->render();
    }

    public function getList($idContract)
    {
        $data = [];

        $data['idConfiguration'] = self::ID_CONFIGURATION;
        $data['idContract'] = $idContract;
        $data['configurations'] = $this->contractConfigurationRepository->getByContractAndSubtype($idContract, self::ID_CONFIGURATION)->sortBy('activity.name');

        return view('sections.contracts.configurations.list.subtypes.product', $data)->render();
    }

    public function validate($request){

        $result = 200;

        $configuration = $this->configurationSubtypeRepository->getById(self::ID_CONFIGURATION);

        if ($configuration->multiple == 1) {
            $actualConfigurations = $this->contractConfigurationRepository->getProductConfiguration($request->fk_id_contract, self::ID_CONFIGURATION, $request->fk_id_product, $request->id);

            if (is_object($actualConfigurations)) {

                $message = [
                    'title' => trans('general.algoSalioMal'),
                    'message' =>trans('contractConfiguration.yaEstaConfiguradoEsteConsumible'),
                    'type'  => 'warning',
                    'status' => 400
                ];

                return $message;
            }
        }

        return $result;
    }

}
