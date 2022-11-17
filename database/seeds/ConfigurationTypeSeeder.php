<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configuration_types')->insert([
            'spanish_name'=>'Rango',
            'english_name'=>'Range',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'[1, 2, 3, 4, 5, 6, 7, 8, 9]',
        ]);

        DB::table('configuration_types')->insert([
            'spanish_name'=>'Valor Unitario',
            'english_name'=>'Unit value',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'[1, 2, 3, 4, 5, 6, 7, 8, 9]',
        ]);
    }
}
