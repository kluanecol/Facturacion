<?php

namespace App\Modules\Invoicing\InvoiceConfiguration\Repository;

use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use App\Modules\Invoicing\InvoiceConfiguration\Models\InvoiceConfiguration;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class InvoiceConfigurationRepository implements InvoiceConfigurationInterface{


    public function saveConfiguration($request){

        dd($request->all());

        $result = 200;

        try {

           $invoice = new Invoice();

           $data = $request->only($invoice->getFillable());
           $data['fk_id_user'] = Auth::user()->id;
           $data['json_fk_machines'] = $data['json_fk_machines'];
           $data['json_fk_pits'] = $data['json_fk_pits'];

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
