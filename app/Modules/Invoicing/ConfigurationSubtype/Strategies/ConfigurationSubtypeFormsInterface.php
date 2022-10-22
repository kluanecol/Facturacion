<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Strategies;

interface ConfigurationSubtypeFormsInterface
{
    public function getForm($idContract, $idContractConfiguration);

    public function validate($request);

    public function getList($idContract);
}
