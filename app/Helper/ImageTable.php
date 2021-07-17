<?php

namespace App\Helper;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait ImageTable
{
    public static function create($company)
    {
        $tablename = 'images_'.$company->id;
        Schema::create($tablename, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jobcard_no')->nullable();
            $table->string('image_path', 200)->nullable();
            $table->integer('type')->nullable();
            $table->timestamps();
        });
    }
}
