<?php

namespace App\Helper;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait ExpenseTable
{
    public static function create($company)
    {
        $tablename = 'expenses_'.$company->id;
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 250)->nullable();
            $table->integer('company_id')->nullable();
            $table->string('expensecategory', 100)->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }
}
