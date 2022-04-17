<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name'=>'Administrator',
            'password'=>\Hash::make('Laravelmyadmin@610'),
            'phonenumber'=>'0327833610',
            'email'=>'sang0753823610@gmail.com',
            'address'=>'TP.HCM',
            'country'=>'Viet Nam',
            'type'=>'Internal',
            'created_at'=> NOW(),
            'updated_at'=> NOW()
        ]);
    }
}
