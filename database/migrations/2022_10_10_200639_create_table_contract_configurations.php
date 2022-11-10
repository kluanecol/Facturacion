<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContractConfigurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_configurations', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->unsignedBigInteger('fk_id_contract');
            $table->foreign('fk_id_contract','fk_contract_to_configuration')->references('id')->on('contracts');

            $table->unsignedBigInteger('fk_id_configuration_subtype');
            $table->foreign('fk_id_configuration_subtype','fk_contract_to_subtype')->references('id')->on('configuration_subtypes');

            $table->unsignedBigInteger('fk_id_parametric')->nullable();
            $table->foreign('fk_id_parametric','fk_contract_to_parametric')->references('id')->on('parametrics');

            $table->unsignedInteger('fk_id_diameter')->nullable();
            $table->unsignedInteger('fk_id_activity')->nullable();
            $table->unsignedInteger('fk_id_product')->nullable();

            $table->decimal('initial_range', 8, 2)->nullable();
            $table->decimal('final_range', 8, 2)->nullable();
            $table->decimal('value', 16, 2)->default(0);
            $table->integer('order')->nullable();

            $table->unsignedBigInteger('fk_id_second_parametric')->nullable();
            $table->foreign('fk_id_second_parametric','fk_contract_to_second_parametric')->references('id')->on('parametrics');
            $table->decimal('second_value', 16, 2)->default(0);

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
        Schema::table('contract_configurations', function (Blueprint $table)
        {
            $table->dropForeign('fk_contract_to_configuration');
            $table->dropForeign('fk_contract_to_subtype');
            $table->dropForeign('fk_contract_to_parametric');
            $table->dropForeign('fk_contract_to_second_parametric');
        });

        Schema::dropIfExists('contract_configurations');
    }
}
