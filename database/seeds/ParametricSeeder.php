<?php

use Illuminate\Database\Seeder;

class ParametricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parametrics')->insert([
            'spanish_name'=>'Moneda',
            'english_name'=>'Currency',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'',
            'fk_id_parent' => null
        ]);

        DB::table('parametrics')->insert([
            'spanish_name'=>'Pesos Colombianos',
            'english_name'=>'Colombian pesos',
            'spanish_description'=>'COP',
            'english_description'=>'COP',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'$',
            'fk_id_parent' => 1
        ]);


        DB::table('parametrics')->insert([
            'spanish_name'=>'Dólares',
            'english_name'=>'Dollars',
            'spanish_description'=>'USD',
            'english_description'=>'USD',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'$',
            'fk_id_parent' => 1
        ]);

    }
}
