<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('categories')->insert([
            'id'=>\mt_rand(100000, 999999),
            'name'=>'Quality Improvement',
            'description'=>'This is quality improvement tag',
            'created_at'=> NOW(),
            'updated_at'=> NOW()
        ]);
    }
}
