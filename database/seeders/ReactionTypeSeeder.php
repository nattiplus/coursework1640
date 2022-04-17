<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('types')->insert([
            'id'=>\mt_rand(100000, 999999),
            'reaction_type'=>'Like',
            'created_at'=> NOW(),
            'updated_at'=> NOW()
        ]);

        \DB::table('types')->insert([
            'id'=>\mt_rand(100000, 999999),
            'reaction_type'=>'DisLike',
            'created_at'=> NOW(),
            'updated_at'=> NOW()
        ]);
    }
}
