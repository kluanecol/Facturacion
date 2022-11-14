<?php

use Illuminate\Database\Seeder;

class ConfigurationSubtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configuration_subtypes')->insert([
            'spanish_name'=>'Encamisado',
            'english_name'=>'Casing',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'required'=>0,
            'multiple'=>1,
            'charge_by_percentage'=>0,
            'order'=>4,
            'icon'=>'icofont-calculations',
            'fk_id_measure'=>null,
            'fk_id_configuration_type'=>1
        ]);

        DB::table('configuration_subtypes')->insert([
            'spanish_name'=>'Perforación',
            'english_name'=>'Drilling',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'required'=>0,
            'multiple'=>1,
            'charge_by_percentage'=>0,
            'order'=>3,
            'icon'=>'icofont-drill',
            'fk_id_measure'=>null,
            'fk_id_configuration_type'=>1
        ]);

        DB::table('configuration_subtypes')->insert([
            'spanish_name'=>'Actividades',
            'english_name'=>'Activities',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'required'=>0,
            'multiple'=>1,
            'charge_by_percentage'=>0,
            'order'=>6,
            'icon'=>'icofont-engineer',
            'fk_id_measure'=>null,
            'fk_id_configuration_type'=>2
        ]);

        DB::table('configuration_subtypes')->insert([
            'spanish_name'=>'Tipo de moneda',
            'english_name'=>'Type of currency',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'required'=>1,
            'multiple'=>0,
            'charge_by_percentage'=>0,
            'order'=>1,
            'icon'=>'icofont-money',
            'fk_id_measure'=>null,
            'fk_id_configuration_type'=>2
        ]);

        DB::table('configuration_subtypes')->insert([
            'spanish_name'=>'Productos',
            'english_name'=>'Products',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'required'=>0,
            'multiple'=>1,
            'charge_by_percentage'=>0,
            'order'=>5,
            'icon'=>'icofont-bricks',
            'fk_id_measure'=>null,
            'fk_id_configuration_type'=>2
        ]);

        DB::table('configuration_subtypes')->insert([
            'spanish_name'=>'Tipo de moneda secundaria',
            'english_name'=>'Secondary currency type',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'required'=>0,
            'multiple'=>0,
            'charge_by_percentage'=>0,
            'order'=>2,
            'icon'=>'icofont-money-bag',
            'fk_id_measure'=>null,
            'fk_id_configuration_type'=>2
        ]);

        DB::table('configuration_subtypes')->insert([
            'spanish_name'=>'Incremento por inclinación de pozo',
            'english_name'=>'Increase due to well inclination',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'required'=>0,
            'multiple'=>1,
            'charge_by_percentage'=>0,
            'order'=>7,
            'icon'=>'icofont-circle-ruler-alt',
            'fk_id_measure'=>null,
            'fk_id_configuration_type'=>1
        ]);

        DB::table('configuration_subtypes')->insert([
            'spanish_name'=>'Otros cargos',
            'english_name'=>'Other charges',
            'spanish_description'=>'',
            'english_description'=>'',
            'state'=>1,
            'json_countries'=>'{"country": [1, 2, 3, 4, 5, 6, 7, 8, 9]}',
            'required'=>0,
            'multiple'=>1,
            'charge_by_percentage'=>0,
            'order'=>8,
            'icon'=>'icofont-paperclip',
            'fk_id_measure'=>null,
            'fk_id_configuration_type'=>1
        ]);
    }
}
