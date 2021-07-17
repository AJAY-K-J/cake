<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
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
            $table->integer('invoice_no')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('name',250)->nullable();
            $table->string('mobile',10)->nullable();
            $table->string('reg_no',20)->nullable();
            $table->decimal('total_gross_amount',10,2)->nullable();
            $table->decimal('total_taxable',10,2)->nullable();
            $table->decimal('total_cgst',10,2)->nullable();
            $table->decimal('total_sgst',10,2)->nullable();
            $table->decimal('total_cess',10,2)->nullable();
            $table->decimal('total_discount',10,2)->nullable();
            $table->decimal('total_net_amount',10,2)->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
