<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('invoice_items', function (Blueprint $table) {
            $table->decimal('igst',10,2)->after('gst_percentage')->default(0); 
            $table->decimal('net_amount',10,2)->after('cess')->default(0); 
            $table->decimal('discount',10,2)->after('labour')->default(0); 
            $table->integer('tax_type')->after('taxable_amount')->nullable(); 
             $table->decimal('amount',10,2)->after('discount')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
