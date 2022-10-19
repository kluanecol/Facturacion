<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableConfigurationSubtypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuration_subtypes', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('spanish_name', 255)->nullable($value = "Sin nombre");
            $table->string('english_name', 255)->nullable($value = "No name");
            $table->text('spanish_description')->nullable();
            $table->text('english_description')->nullable();
            $table->json('json_countries');
            $table->tinyInteger('state')->nullable($value = 1);
            $table->tinyInteger('required')->nullable($value = 0);
            $table->tinyInteger('multiple')->nullable($value = 0);
            $table->tinyInteger('charge_by_percentage')->nullable($value = 0);
            $table->integer('order')->nullable();
            $table->string('icon', 255)->nullable();
            $table->unsignedBigInteger('fk_id_measure')->nullable();
            $table->foreign('fk_id_measure','fk_subtype_to_parametric')->references('id')->on('parametrics');

            $table->integer('fk_id_configuration_type');


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
        Schema::table('configuration_subtypes', function (Blueprint $table)
        {
            $table->dropForeign('fk_subtype_to_parametric');
        });

        Schema::dropIfExists('configuration_subtypes');
    }
}
