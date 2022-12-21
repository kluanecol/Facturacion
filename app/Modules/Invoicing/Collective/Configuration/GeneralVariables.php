<?php

namespace App\Modules\Invoicing\Collective\Configuration;
use Session;

class GeneralVariables
{

    //INVOICE PARAMETRICS
    CONST ID_PARAMETRIC_CURRENCY = 1;
    CONST ID_PARAMETRIC_MEASURES = 2;
    CONST ID_PARAMETRIC_OTHER_CHARGES = 3;

    //CONFIGURATION SUBTYPES

    CONST ID_CONFIGURATION_DRILLING = 1;
    CONST ID_CONFIGURATION_CASING = 2;
    CONST ID_CONFIGURATION_CURRENCY = 4;
    CONST ID_CONFIGURATION_SECOND_CURRENCY = 6;
    CONST ID_CONFIGURATION_OTHER_CHARGE = 8;

    //PARAMETRICS FUNCTIONALITY
    CONST ID_VAL_FUNCTIONALITY_SURFACE_MACHINE = 1;
    CONST ID_VAL_FUNCTIONALITY_WATER_LINES = 7;

    //PARAMETRICS TURNS
    CONST ARRAY_ID_PARAMETRIC_DAY_SHIFT = [1146,3,628,373,2428,3742,3744,175];
    CONST ARRAY_ID_PARAMETRIC_NIGHT_SHIFT = [1147,4,629,374,2429,3743,3745,176];

    //INVOICE STATUS
    CONST INVOICE_STATE_CREATED = 1;
    CONST INVOICE_STATE_GENERATED = 2;

    public static function yearsArray(){

        $years = [];
        for ($i=2022; $i < 2025; $i++) {
            $years[$i] = $i;
        }

        return $years;
    }

    public static function getCurrentCountryId(){
        return Session::get('country')->id;
    }

    public static function getCurrentLanguage(){
        return Session::get('locale');
    }

}
