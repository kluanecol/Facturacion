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
           $data['quantity'] = $configuration['quantity'];
           $data['fk_id_pit'] = $configuration['fk_id_pit'];
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

}
