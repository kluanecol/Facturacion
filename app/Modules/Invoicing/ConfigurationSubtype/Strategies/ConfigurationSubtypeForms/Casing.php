<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms;

use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeFormsInterface;

class Casing implements ConfigurationSubtypeFormsInterface
{
    public function getForm()
    {
        $data = [];
        return view('sections.contracts.configurations.form.subtypes.casing', $data);
    }
}
