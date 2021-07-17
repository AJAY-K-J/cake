<?php

namespace App\Helper;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait JobcardTable
{
    public static function create($company)
    {
        $tablename = 'jobcards_'.$company->id;
        Schema::create($tablename, function (Blueprint $table) {

            $table->increments('id');
            $table->integer('jobcard_no')->nullable();
            $table->string('partno', 100)->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('rate',10,2)->nullable();
            $table->decimal('labour',10,2)->nullable();
            $table->integer('technician_id')->nullable();
            $table->integer('service_id')->nullable();
            $table->string('remarks', 100)->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
          
        });
    }

}
