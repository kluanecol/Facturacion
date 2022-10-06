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
        Schema::create('fac_configuration_subtypes', function (Blueprint $table) {

            $table->increments('id');
            $table->string('spanish_name', 255)->nullable($value = "Sin nombre");
            $table->string('english_name', 255)->nullable($value = "No name");
            $table->text('spanish_description')->nullable();
            $table->text('english_description')->nullable();
            $table->json('json_countries');
            $table->tinyInteger('state');

            $table->unsignedBigInteger('fk_id_configuration_type');
            $table->foreign('fk_id_configuration_type','fk_subtype_to_type')->references('id')->on('fac_configuration_types');


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
        Schema::table('fac_configuration_subtypes', function (Blueprint $table)
        {
            $table->dropForeign('fk_subtype_to_type');
        });

        Schema::dropIfExists('fac_configuration_subtypes');
    }
}
