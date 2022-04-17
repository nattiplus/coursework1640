<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    // Index Role View
    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin.role.index', compact('roles'));
    }

    // Create Role View
    public function create()
    {
        return view('admin.role.create');
    }

    public function postcreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required',
            'route'=>'required',
        ],[
            'role_name.required' => 'Role Name cannot be left blank',
            'route.required' => 'Route cannot be left blank',
        ]);
        if($validator->passes())
        {
            $role = new Role;
            $role->id = mt_rand(100000, 999999);
            $role->name = $request->role_name;
            $role->created_at = Carbon::now();
            $role->updated_at = Carbon::now();
            $role->permissions = \json_encode($request->route);
            $role->save();
            Session::put('message', 'Create Role Success');
            return Redirect::to('/admin/role');
        }
        return response()->redirectToRoute('role.create')->withErrors($validator->errors());
    }

    // Update Role View
    public function UpdateRole($id)
    {
        $role = Role::find($id);
        if($role['permissions'])
        {
            $myroutes = \json_decode($role['permissions']);
            return view('admin.role.update', compact('role', 'myroutes'));
        }
        else
        {
            $myroutes = null;
            return view('admin.role.update', compact('role', 'myroutes'));
        }
        
    }

    public function StoreUpdateRole($id, Request $request)
    {
        $role = Role::find($id);
        $role->name = $request->role_name;
        $role->permissions = $request->route;
        $role->updated_at = Carbon::now();
        $role->save();
        return Redirect::to('/admin/role')->with('message', 'Update Role Success');
    }

    // Role Details View
    public function RoleDetails($id)
    {
        $role = Role::find($id);
        if($role['permissions'])
        {
            $myroutes = \json_decode($role['permissions']);
            return view('admin.role.details', compact('role', 'myroutes'));
        }
        else
        {
            $myroutes = null;
            return view('admin.role.details', compact('role', 'myroutes'));
        }
    }

    // Delete Role View
    public function DeleteRole($id)
    {
        Role::find($id)->delete();
        return Redirect::to('/admin/role')->with('message', 'Delete Role Success');
    }

    // Index Role User View
    public function indexRoleUser()
    {
        $users = User::all();
        return view('admin.role_user.index', compact('users'));
    }

    // Create Role User view
    public function CreateRoleUser()
    {
        $users = User::all();
        $roles = Role::all();
        return view('admin.role_user.create', compact('users', 'roles'));
    }

    public function PostCreateRoleUser(Request $request)
    {      
        foreach($request->user_select as $key => $user_id)
        {
            $user = new User();
            $user->id = $user_id;
            $role = Role::find($request->role_select);
            $user->roles()->attach($role);
        }
        Session::put('message', 'Assign Role For User Success');
        return Redirect::to('/admin/user-role');
    }
    // View Details User Role
    public function UserRoleDetails(User $user)
    {
        return view('admin.role_user.details', compact('user'));
    }
}
