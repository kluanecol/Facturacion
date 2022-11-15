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
        //PARENTS
        //Currency
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
        //Measurement units
         DB::table('parametrics')->insert([
            'spanish_name'=>'Medidas',
            'english_name'=>'Measures',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'',
            'fk_id_parent' => null
        ]);

        //Measurement units
        DB::table('parametrics')->insert([
            'spanish_name'=>'Otros cargos',
            'english_name'=>'Other charges',
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

        DB::table('parametrics')->insert([
            'spanish_name'=>'Pesos Mexicanos',
            'english_name'=>'Mexican pesos',
            'spanish_description'=>'MXN',
            'english_description'=>'MXN',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'$',
            'fk_id_parent' => 1
        ]);

        DB::table('parametrics')->insert([
            'spanish_name'=>'Soles',
            'english_name'=>'Soles',
            'spanish_description'=>'PEN',
            'english_description'=>'PEN',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'$',
            'fk_id_parent' => 1
        ]);

        DB::table('parametrics')->insert([
            'spanish_name'=>'METRO',
            'english_name'=>'METER',
            'spanish_description'=>'MTS',
            'english_description'=>'MTS',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'MTS',
            'fk_id_parent' => 2
        ]);

        DB::table('parametrics')->insert([
            'spanish_name'=>'HORA',
            'english_name'=>'HOUR',
            'spanish_description'=>'H',
            'english_description'=>'H',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'H',
            'fk_id_parent' => 2
        ]);

        DB::table('parametrics')->insert([
            'spanish_name'=>'DÍA',
            'english_name'=>'DAY',
            'spanish_description'=>'D',
            'english_description'=>'D',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'D',
            'fk_id_parent' => 2
        ]);

        DB::table('parametrics')->insert([
            'spanish_name'=>'MES',
            'english_name'=>'MONTH',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'',
            'fk_id_parent' => 2
        ]);

        DB::table('parametrics')->insert([
            'spanish_name'=>'KILO',
            'english_name'=>'KILOGRAM',
            'spanish_description'=>'KG',
            'english_description'=>'KG',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'KG',
            'fk_id_parent' => 2
        ]);

        DB::table('parametrics')->insert([
            'spanish_name'=>'UNIDAD',
            'english_name'=>'UNIT',
            'spanish_description'=>'U',
            'english_description'=>'U',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'U',
            'fk_id_parent' => 2
        ]);

        DB::table('parametrics')->insert([
            'spanish_name'=>'STAND BY DE PERSONAL Y EQUIPO',
            'english_name'=>'STAFF AND EQUIPMENT STAND BY',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'',
            'fk_id_parent' => 3,
            'fk_id_auxiliary_parametric' => 9
        ]);

        DB::table('parametrics')->insert([
            'spanish_name'=>'MOVILIZACIÓN DE EQUIPOS ENTRE PLATAFORMAS',
            'english_name'=>'MOBILIZATION OF TEAMS BETWEEN PLATFORMS',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'',
            'fk_id_parent' => 3,
            'fk_id_auxiliary_parametric' => 9
        ]);

        DB::table('parametrics')->insert([
            'spanish_name'=>'ESTABILIZACIÓN Y RIMADO',
            'english_name'=>'STABILIZATION AND RHYMING',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'',
            'fk_id_parent' => 3,
            'fk_id_auxiliary_parametric' => 9
        ]);

        DB::table('parametrics')->insert([
            'spanish_name'=>'MINIEXCAVADORA',
            'english_name'=>'MINI EXCAVATOR',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'value'=>0,
            'symbol'=>'',
            'fk_id_parent' => 3,
            'fk_id_auxiliary_parametric' => 10
        ]);
    }
}
