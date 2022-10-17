<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms;

use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeFormsInterface;

class Currency implements ConfigurationSubtypeFormsInterface
{
    public function getForm()
    {
        $data = [];
        return view('sections.contracts.configurations.form.subtypes.currency', $data)->render();
    }


}
