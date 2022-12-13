<?php

namespace App\Modules\Invoicing\InvoiceConfiguration\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Invoicing\InvoiceConfiguration\Repository\InvoiceConfigurationInterface;
use App\Modules\Invoicing\ConfigurationSubtype\Repository\ConfigurationSubtypeInterface;

class InvoiceConfigurationController extends Controller
{
    private $invoiceConfigurationRepo;
    private $contractConfigurationSubtypeRepo;

    function __construct(
        InvoiceConfigurationInterface $invoiceConfigurationRepo,
        ConfigurationSubtypeInterface $contractConfigurationSubtypeRepo
    )
    {
        $this->invoiceConfigurationRepo = $invoiceConfigurationRepo;
        $this->contractConfigurationSubtypeRepo = $contractConfigurationSubtypeRepo;
    }


}
