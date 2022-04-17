<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $routeCollection = Route::getRoutes();
        $routes = array();
        foreach ($routeCollection as $route)
        {
            if ($route->getName() != '')
            {
                array_push($routes, $route->getName());
            }
        }
            

        \DB::table('roles')->insert([
            'id'=>\mt_rand(100000, 999999),
            'name'=>'Administrator',
            'permissions'=>\json_encode($routes),
            'created_at'=> NOW(),
            'updated_at'=> NOW()
        ]);

        $user = \DB::table('users')->first();
        $role = \DB::table('roles')->first();

        \DB::table('role_user')->insert([
            'id'=>\mt_rand(100000, 999999),
            'role_id'=>$role->id,
            'user_id'=>$user->id
        ]);
    }
}
