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
            $table->string('spanish_name', 255);
            $table->string('english_name', 255);
            $table->text('spanish_description')->nullable();
            $table->text('english_description')->nullable();
            $table->tinyInteger('state');
            $table->json('json_countries');

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
        Schema::dropIfExists('fac_configuration_types');
    }
}
