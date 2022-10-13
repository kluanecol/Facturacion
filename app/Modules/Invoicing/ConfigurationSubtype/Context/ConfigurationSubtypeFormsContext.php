<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Context;

use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms\Casing;

class ConfigurationSubtypeFormsContext
{
    const STRATEGY = [
       '1' => Casing::class,
       '2' => Casing::class,
       '3' => Casing::class,
       '4' => Casing::class,
       '5' => Casing::class,
       '6' => Casing::class
    ];
}
