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
        Schema::create('contracts', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->date('initial_date');
            $table->date('end_date');
            $table->smallInteger('year');
            $table->string('name', 255)->nullable();

            $table->unsignedBigInteger('fk_id_user');
            $table->unsignedBigInteger('fk_id_project');
            $table->unsignedBigInteger('fk_id_country');
            $table->unsignedBigInteger('fk_id_client');

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
        Schema::dropIfExists('contracts');
    }
}
