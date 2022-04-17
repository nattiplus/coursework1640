<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function view_user() 
    {
        $all_user = User::paginate(10);
        return view('admin.user.view-user',compact('all_user'));
    }
    
    public function create_user()
    {
        $user_dept = Department::orderby('id','desc')->get();
        $roles = Role::all();
        return view('admin.user.create-user',compact('user_dept', 'roles'));
    }
    
    public function save_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone'=>'required',
            'address' => 'required',
            'country' => 'required',
            'name' => 'required',
            'password' => 'required',
            'user_type' => 'required',
            'user_dept' => 'required',
            'role_select' => 'required'
        ],[
            'name.required' => 'Name cannot be left blank',
            'email.required' => 'Email cannot be left blank',
            'phone.required' => 'Phone number cannot be left blank',
            'address.required' => 'Address cannot be left blank',
            'country.required' => 'Country cannot be left blank',
            'name.required' => 'Full name cannot be left blank',
            'password.required' => 'Password cannot be left blank',
            'user_type.required' => 'User Type cannot be left blank',
            'user_dept.required' => 'Department cannot be left blank',
            'role_select.required' => 'User Role cannot be left blank'
        ]);
        if($validator->passes())
        {
            $data = $request->all();
            $user = new User();
            $user->email = $data['email'];
            $user->phonenumber = $data['phone'];
            $user->address = $data['address'];
            $user->country = $data['country'];
            $user->name = $data['name'];
            $user->password = Hash::make($data['password']);
            $user->updated_at = Carbon::now(); 
            $user->created_at = Carbon::now(); 
            $user->type = $data['user_type'];
            $user->department_id = $data['user_dept'];
            $user->save();

            // Assign User Into Role
            if($request->role_select)
            {
                $role = Role::find($request->role_select);
                $user->roles()->attach($role);
            }
            Session::put('message','Create successfully user '.$user->id);
            return Redirect::to('admin/create-user');
        }
        return response()->redirectToRoute('create.user')->withErrors($validator->errors());
    }

    public function delete_user(Request $request, $user_id){
        // Delete User Role
        $user = User::find($user_id);
        $user_role = User::find($user_id)->roles;
        $user->roles()->detach($user_role);

        // Delete Account User
        User::where('id',$user_id)->delete();
        Session::put('message','Delete successfully!');
        return Redirect::to('/admin/view-user ');
    }

    public function edit_user(Request $request, $userId)
    {
        $user = User::find($userId);
        $user_dept = Department::orderby('id','desc')->get();
        $roles = User::find($userId)->roles;
        $all_role = Role::all();
        return view('admin.user.edit-user',compact('user','user_dept', 'roles', 'all_role'));
    }

    public function update_user(Request $request, $user_id)
    {
        $data = $request->all();
        $user = User::find($user_id);
        $user->name = $data['fullname'];
        $user->email = $data['email'];
        $user->phonenumber = $data['phone'];
        $user->address = $data['address'];
        $user->country = $data['country'];
        $user->password = Hash::make($data['password']);
        $user->updated_at = Carbon::now(); 
        $user->type = $data['user_type'];
        $user->department_id = $data['user_dept'];
        $user->save();
        
        // Assign User Into Role
        if(User::find($user_id)->roles != null)
        {
            $myRole = User::find($user_id)->roles;
            $user->roles()->detach($myRole);
        }
        if($request->role_select)
        {
            $role = Role::find($request->role_select);
            $user->roles()->attach($role);
        }
        Session::put('message','Update successfully');
        return Redirect::to('admin/view-user');
    }

    // View User Details
    public function details_user($user_id)
    {
        $user = User::find($user_id);
        $user_role = User::find($user_id)->roles;
        return view('admin.user.details-user', compact('user', 'user_role'));
    }
}
