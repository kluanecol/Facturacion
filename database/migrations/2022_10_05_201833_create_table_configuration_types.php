<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableConfigurationTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fac_configuration_types', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->tinyInteger('state');


            $table->date('end_date');
            $table->smallInteger('year');

            $table->unsignedBigInteger('fk_id_user');
            $table->foreign('fk_id_user','fk_contract_to_user')->references('id')->on('users');

            $table->unsignedBigInteger('fk_id_project');
            $table->foreign('fk_id_project','fk_contract_to_project')->references('id')->on('proyectos');

            $table->unsignedBigInteger('fk_id_country');
            $table->foreign('fk_id_country','fk_contract_to_country')->references('id')->on('countries');

            $table->unsignedBigInteger('fk_id_client');
            $table->foreign('fk_id_client','fk_contract_to_client')->references('id')->on('clientes');

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configuration_types', function (Blueprint $table)
        {
            $table->dropForeign('fk_contract_to_user');
            $table->dropForeign('fk_contract_to_project');
            $table->dropForeign('fk_contract_to_country');
            $table->dropForeign('fk_contract_to_client');
        });

        Schema::dropIfExists('configuration_types');

    }
}
