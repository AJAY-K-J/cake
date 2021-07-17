<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',250)->nullable();
            $table->string('mobile',10)->nullable();
            $table->string('reg_no',20)->nullable();
            $table->decimal('total_estimate',10,2)->nullable();
            $table->integer('order_status')->nullable();
            $table->integer('invoice_no')->nullable();
            $table->integer('status')->default(0);
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('sale_orders');
    }
}
