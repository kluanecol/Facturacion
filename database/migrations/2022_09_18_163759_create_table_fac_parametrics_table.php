<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFacParametricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fac_parametrics', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->json('json_countries');
            $table->string('spanish_name', 255);
            $table->string('english_name', 255);
            $table->text('spanish_description')->nullable();
            $table->text('english_description')->nullable();
            $table->tinyInteger('state')->default(1);
            $table->decimal('value', 8, 2)->nullable();
            $table->string('symbol', 10)->nullable();

            $table->unsignedBigInteger('fk_id_parent')->nullable();
            $table->foreign('fk_id_parent','fk_parametric_to_parent')->references('id')->on('fac_parametrics');

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
        Schema::table('fac_parametrics', function (Blueprint $table)
        {
            $table->dropForeign('fk_id_parent');

        });

        Schema::dropIfExists('fac_parametrics');
    }
}
