<?php

namespace App\Modules\Invoicing\Collective\Configuration;
use Session;

class GeneralVariables
{

    CONST ID_PARAMETRIC_CURRENCY = 1;

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
