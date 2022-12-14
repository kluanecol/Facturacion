<?php

namespace App\Modules\Invoicing\InvoiceConfiguration\Repository;

use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Invoicing\InvoiceConfiguration\Models\InvoiceConfiguration;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class InvoiceConfigurationRepository implements InvoiceConfigurationInterface{


    public function saveConfiguration($configuration, $contractConfiguration, $idInvoice, $idConfiguration){

        $result = 200;

        try {

           $invoice = new InvoiceConfiguration();

           $data = $contractConfiguration->toArray();
           $data['fk_id_user'] = Auth::user()->id;
           $data['quantity'] = isset($configuration) ? $configuration['quantity'] : 0;
           $data['fk_id_pit'] = isset($configuration) ? $configuration['fk_id_pit'] : null;
           $data['fk_id_invoice'] = $idInvoice;
           $data['fk_id_contract_configuration'] = $idConfiguration;

            if ($invoice->fill($data)->save()) {
                $result = 200;
            }else{
                $result = 400;
           }

           return $result;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteAllByIdInvoice($idInvoice){

        $configurations = InvoiceConfiguration::where('fk_id_invoice', $idInvoice)->get();

        if ($configurations->count() > 0) {
            return InvoiceConfiguration::where('fk_id_invoice', $idInvoice)->delete();
        }else{
            return true;
        }

    }

}
