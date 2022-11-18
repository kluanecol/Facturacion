<?php

namespace App\Modules\Invoicing\Collective\Configuration;
use Session;

class GeneralVariables
{

    //PARAMETRICS
    CONST ID_PARAMETRIC_CURRENCY = 1;
    CONST ID_PARAMETRIC_MEASURES = 2;
    CONST ID_PARAMETRIC_OTHER_CHARGES = 3;

    //CONFIGURATION SUBTYPES
    CONST ID_CONFIGURATION_CURRENCY = 4;
    CONST ID_CONFIGURATION_SECOND_CURRENCY = 6;

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


    public static function getCountryNamesByIds($ids){

    }
}
