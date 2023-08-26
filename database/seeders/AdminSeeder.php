<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Str;
use Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role'=> '1', //Admin role
            'mobile_number' => '7678976675',
            'code' => '123123'
        ]);
    }
}
