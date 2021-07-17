<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";');
        DB::table('roles')->insert([
        	['id' => 0,'name' => 'SUPERADMIN'],
        	['id' => 1,'name' => 'ADMIN'],
        	['id' => 2,'name' => 'SERVICE'],
        ]);

        DB::table('users')->insert(['id' => '1','name' => 'SUPER ADMIN','email' => 'superadmin@test.com','role_id'=>0,'username' => 'superadmin','password' => bcrypt('superadmin')]);

        DB::table('sms_settings')->insert(['id' => '1','company_id' => '0','sender_id' => 'AMMOTORS','username' => 'AMMOTORS2','password' => 'AMMOTORS2']);

    }
}
