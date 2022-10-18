<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Strategies;

interface ConfigurationSubtypeFormsInterface
{
    public function getForm(int $idContract, int $idContractConfiguration);

    public function validate(Request $request);

    public function getList(int $idContract);
}
