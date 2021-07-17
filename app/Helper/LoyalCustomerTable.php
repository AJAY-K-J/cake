<?php

namespace App\Helper;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait LoyalCustomerTable
{
    public static function create($company)
    {
        $tablename = 'loyalcustomers_'.$company->id;
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->nullable();
            $table->integer('customer_code')->nullable();
            $table->string('mobile', 10)->nullable();
            $table->string('location', 100)->nullable();
            $table->decimal('credit_amount',10,2)->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }
}
