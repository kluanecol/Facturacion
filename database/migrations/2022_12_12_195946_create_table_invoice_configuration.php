<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInvoiceConfiguration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_configurations', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->decimal('quantity', 16, 2)->default(0);

            $table->unsignedBigInteger('fk_id_invoice');
            $table->foreign('fk_id_invoice','fk_invoice_to_configuration')->references('id')->on('invoices')->onDelete('cascade');

            $table->unsignedBigInteger('fk_id_configuration_subtype')->nullable();
            $table->foreign('fk_id_configuration_subtype','fk_invoice_to_subtype')->references('id')->on('configuration_subtypes');

            $table->unsignedBigInteger('fk_id_parametric')->nullable();
            $table->foreign('fk_id_parametric','fk_invoice_to_parametric')->references('id')->on('parametrics');

            $table->unsignedInteger('fk_id_diameter')->nullable();
            $table->unsignedInteger('fk_id_activity')->nullable();
            $table->unsignedInteger('fk_id_product')->nullable();

            $table->decimal('initial_range', 8, 2)->nullable();
            $table->decimal('final_range', 8, 2)->nullable();
            $table->decimal('value', 16, 2)->default(0);
            $table->integer('order')->nullable();
            $table->smallInteger('charge_by_percentage')->nullable();
            $table->json('json_fk_parametrics')->nullable();

            $table->unsignedBigInteger('fk_id_second_parametric')->nullable();
            $table->foreign('fk_id_second_parametric','fk_invoice_to_second_parametric')->references('id')->on('parametrics');
            $table->decimal('second_value', 16, 2)->nullable();


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
        Schema::table('contract_configurations', function (Blueprint $table)
        {
            $table->dropForeign('fk_invoice_to_configuration');
            $table->dropForeign('fk_invoice_to_subtype');
            $table->dropForeign('fk_invoice_to_parametric');
            $table->dropForeign('fk_invoice_to_second_parametric');
        });

        Schema::dropIfExists('invoice_configurations');
    }
}
