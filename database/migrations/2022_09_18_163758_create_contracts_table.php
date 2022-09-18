<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fac_contracts', function (Blueprint $table) {

            $table->increments('id');
            $table->date('initial_date');
            $table->date('end_date');

            $table->integer('fk_id_user')->unsigned();
            $table->foreign('fk_id_user','fk_contract_to_user')->references('id')->on('users');

            $table->integer('fk_id_proyecto')->unsigned();
            $table->foreign('fk_id_proyecto','fk_contract_to_proyect')->references('id')->on('proyectos');

            $table->integer('fk_id_country')->unsigned();
            $table->foreign('fk_id_country','fk_contract_to_country')->references('id')->on('countries');

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
        Schema::table('fac_contracts', function (Blueprint $table)
        {
            $table->dropForeign('fk_contract_to_user');
            $table->dropForeign('fk_contract_to_proyect');
            $table->dropForeign('fk_contract_to_country');
        });

        Schema::dropIfExists('contracts');
    }
}
