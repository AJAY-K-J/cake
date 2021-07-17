<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('invoice_no')->nullable();
            $table->integer('stock_item')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('product')->nullable();
            $table->string('labour_description')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('mrp',10,2)->default(0);
            $table->decimal('labour',10,2)->default(0);
            $table->decimal('taxable_amount',10,2)->nullable();
            $table->integer('gst_percentage')->nullable();
            $table->decimal('cgst',10,2)->default(0);
            $table->decimal('sgst',10,2)->default(0);
            $table->decimal('cess',10,2)->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('invoice_items');
    }
}
