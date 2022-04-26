<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('departments')->insert([
            'id'=>\mt_rand(100000, 999999),
            'name'=>'IT Department',
            'created_at'=> NOW(),
            'updated_at'=> NOW()
        ]);
    }
}
