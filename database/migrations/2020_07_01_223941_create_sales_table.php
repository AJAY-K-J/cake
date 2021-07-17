<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('receipt_no');
            $table->string('customer_name',100);
            $table->string('mobile',10);
            $table->date('sale_date');
            $table->integer('total_items');
            $table->decimal('total_gross_amount',10,2);
            $table->decimal('total_discount_amount',10,2)->nullable();
            $table->decimal('total_net_amount',10,2);
            $table->decimal('received_amount',10,2);
            $table->integer('credit')->default(0);
            $table->integer('payment_status')->default(0);
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
        Schema::dropIfExists('sales');
    }
}
