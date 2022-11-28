<?php

namespace App\Modules\Production\ActivityRecord\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Production\ActivityRecord\Repository\ActivityRecordInterface;

class OperationRecordController extends Controller
{
    protected $activityRecordRepository;

    function __construct(
        ActivityRecordInterface $activityRecordRepository
        )
        {
            $this->$activityRecordRepository = $activityRecordRepository;
        }

}
