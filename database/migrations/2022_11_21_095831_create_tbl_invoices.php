<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->unsignedBigInteger('fk_id_contract');
            $table->foreign('fk_id_contract','fk_contract_to_invoice')->references('id')->on('contracts');

            $table->unsignedBigInteger('fk_id_user');

            $table->date('initial_period');
            $table->date('end_period');

            $table->string('code', 255)->nullable();
            $table->smallInteger('state')->nullable();
            $table->smallInteger('version')->nullable();
            $table->json('json_fk_machines')->nullable();
            $table->json('json_fk_pits')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table)
        {
            $table->dropForeign('fk_contract_to_invoice');
        });

        Schema::dropIfExists('invoices');
    }
}
