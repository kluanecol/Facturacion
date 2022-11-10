<?php

namespace App\Modules\Admin\Consumable\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;
use Illuminate\Http\Request;
use App\Modules\Admin\Consumable\Repository\ConsumableInterface;

class ConsumableController extends Controller
{
    protected $consumableRepository;

    function __construct(
            ConsumableInterface $consumableRepository
        )
        {
            $this->consumableRepository = $consumableRepository;
    }


    public function getByGroupId(Request $request)
    {
        $consumables = $this->consumableRepository->getByGroupId($request->id_group)->sortBy('name')->pluck('name','id');

        return response()->json(['success' => true, 'consumables'=>$consumables]);
    }

    public function searchByString(Request $request)
    {
        $consumables = $this->consumableRepository->searchByString($request->input_string)->sortBy('name')->pluck('name_reference','id');

        return response()->json(['success' => true, 'consumables'=>$consumables]);
    }

}
