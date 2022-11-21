<?php

namespace App\Modules\Production\OperationRecord\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Production\OperationRecord\Repository\OperationRecordInterface;

class OperationRecordController extends Controller
{
    protected $operationRecordRepository;

    function __construct(
            OperationRecordInterface $operationRecordRepository
        )
        {
            $this->operationRecordRepository = $operationRecordRepository;
    }

}
