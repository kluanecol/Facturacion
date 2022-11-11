<?php

namespace App\Modules\Invoicing\ConfigurationSubtype\Context;

use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms\Casing;
use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms\Drilling;
use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms\Activity;
use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms\Currency;
use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms\Product;
use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms\SecondaryCurrency;
use App\Modules\Invoicing\ConfigurationSubtype\Strategies\ConfigurationSubtypeForms\HoleInclination;

class ConfigurationSubtypeFormsContext
{
    const STRATEGY = [
       '1' => Casing::class,
       '2' => Drilling::class,
       '3' => Activity::class,
       '4' => Currency::class,
       '5' => Product::class,
       '6' => SecondaryCurrency::class,
       '7' => HoleInclination::class
    ];
}
