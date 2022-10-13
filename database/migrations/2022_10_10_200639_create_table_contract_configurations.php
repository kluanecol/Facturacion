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

            $table->unsignedBigInteger('fk_id_configuration_subtype');
            $table->foreign('fk_id_configuration_subtype','fk_contract_to_subtype')->references('id')->on('configuration_subtypes');

            $table->unsignedInteger('fk_id_activity')->nullable();
            $table->unsignedInteger('fk_id_product')->nullable();

            $table->decimal('initial_range', 8, 2)->nullable();
            $table->decimal('final_range', 8, 2)->nullable();
            $table->decimal('value', 8, 2);
            $table->integer('order')->nullable();

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
            $table->dropForeign('fk_subtype_to_type');
        });

        Schema::dropIfExists('contract_configurations');
    }
}
