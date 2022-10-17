<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Strategies;

interface ConfigurationSubtypeFormsInterface
{
    public function getForm(int $idContract);

    public function validate(Request $request);
}
