<?php

namespace App\Modules\Invoicing\ContractConfiguration\Repository;

use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Invoicing\ContractConfiguration\Models\ContractConfiguration;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class ContractConfigurationRepository implements ContractConfigurationInterface{

    public function getByContractAndSubtype($idContract, $idConfigurationSubtype){
        return ContractConfiguration::where('fk_id_contract',$idContract)
            ->where('fk_id_configuration_subtype',$idConfigurationSubtype)
            ->get();
    }

    public function getActivityConfiguration($idContract, $idConfigurationSubtype, $idActivity){
        return ContractConfiguration::where('fk_id_contract', $idContract)
            ->where('fk_id_configuration_subtype', $idConfigurationSubtype)
            ->where('fk_id_activity', $idActivity)
            ->first();
    }

    public function getById($id){
        return ContractConfiguration::find($id);
    }

    public function save($request){
        $result = 200;

        try {
            if (isset($request->id)) {
                $contractConfiguration = ContractConfiguration::find($request->id);
            }else{
                $contractConfiguration = new ContractConfiguration();
            }

           $data = $request->only($contractConfiguration->getFillable());

           if ($contractConfiguration->fill($data)->save()) {
                $result = 200;
            }else{
                $result = 400;
           }

           return $result;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($request){
        $result = 200;

        try {

            if (isset($request->id_contract_configuration)) {
                $contractConfiguration = ContractConfiguration::find($request->id_contract_configuration);
            }

           if ($contractConfiguration->delete()) {
                $result = 200;
            }else{
                $result = 400;
           }

           return $result;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
