<?php

namespace App\Helper;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait CustomerTable
{
    public static function create($company)
    {
    	$tablename = 'customers_'.$company->id;
    	Schema::create($tablename, function (Blueprint $table) {
    	    $table->increments('id');
            $table->integer('campaign_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('type')->default(0);
            $table->string('name', 100)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('mobile2', 20)->nullable();
            $table->string('reg_no', 20)->nullable();
            $table->string('make', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('color', 20)->nullable();
            $table->string('location', 150)->nullable();
            $table->integer('service_type')->nullable();
            $table->string('service_string', 100)->nullable();
            $table->integer('reg_status')->default(0);
            $table->string('remarks')->nullable();
            $table->timestamp('completed_date')->nullable();
            $table->timestamp('delivered_date')->nullable();
            $table->string('referral_code', 50)->nullable();
            $table->string('template', 500)->nullable();
            $table->integer('redeem_status')->default(0);
            $table->timestamp('redeem_date')->nullable();
            $table->integer('service_user_id')->nullable();
            $table->decimal('redeem_amount',10,2)->nullable();
            $table->decimal('spare_amount',10,2)->nullable();
            $table->decimal('tax',10,2)->nullable();
            $table->decimal('discount',10,2)->nullable();
            $table->decimal('labour_amount',10,2)->nullable();
            $table->decimal('total_amount',10,2)->nullable();
            $table->string('jobcard_prefix',10)->nullable();
            $table->integer('jobcard_no')->nullable();
            $table->timestamp('jobcard_created_date')->nullable();
            $table->integer('jobcard_userid')->nullable();
            $table->integer('jobadvisor_id')->nullable();
            $table->integer('status')->default(0);
            $table->timestamp('added_date')->nullable();
            $table->date('sent_date')->nullable();
            $table->timestamps();
    	});
    }
}
