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
            $table->integer('year');

            $table->unsignedBigInteger('fk_id_user');
            $table->foreign('fk_id_user','fk_contract_to_user')->references('id')->on('users');

            $table->unsignedBigInteger('fk_id_project');
            $table->foreign('fk_id_project','fk_contract_to_project')->references('id')->on('proyectos');

            $table->unsignedBigInteger('fk_id_country');
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
            $table->dropForeign('fk_contract_to_project');
            $table->dropForeign('fk_contract_to_country');
        });

        Schema::dropIfExists('fac_contracts');
    }
}
