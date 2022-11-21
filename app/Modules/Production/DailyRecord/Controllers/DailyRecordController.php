<?php

namespace App\Modules\Production\DailyRecord\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Production\DailyRecord\Repository\DailyRecordInterface;

class DailyRecordController extends Controller
{
    protected $dailyRecordRepository;

    function __construct(
            DailyRecordInterface $dailyRecordRepository
        )
        {
            $this->dailyRecordRepository = $dailyRecordRepository;
    }

}
