<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function view_department() 
    {
        $all_department = Department::paginate(10);
         
        return view('admin.department.view-department',compact('all_department'));
    }
    
    public function create_department()
    {
        return view('admin.department.create-department');
    }
    
    public function save_department(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dept_name' => 'required',
            'create_date'=>'required',
        ],[
            'dept_name.required' => 'Department Name cannot be left blank',
            'create_date.required' => 'Create Date cannot be left blank',
        ]);
        if($validator->passes())
        {
            $data = $request->all();
            $dept = new Department();
            $dept->id = mt_rand(100000, 999999);
            $dept->name = $data['dept_name'];
            $dept->updated_at = Carbon::now(); 
            $dept->created_at = $data['create_date'];
            $dept->save();

            Session::put('message','Create successfully');
            return Redirect::to('admin/create-department');
        }
        return response()->redirectToRoute('create.department')->withErrors($validator->errors());
    }

    public function delete_department(Request $request, $dept_id){
        Department::where('id',$dept_id)->delete();
        Session::put('message','Delete successfully!');
        return Redirect::to('/admin/view-department ');
    }

    public function edit_department(Request $request, $deptId)
    {
        $department = Department::find($deptId);
        return view('admin.department.edit-department',compact('department'));
    }

    public function update_department(Request $request, $deptId)
    {
        $data = $request->all();
        $dept = Department::find($deptId);
        $dept->name = $data['dept_name'];
        $dept->updated_at = Carbon::now();     
        $dept->save();

        Session::put('message','Update successfully');
        return Redirect::to('admin/view-department');
    }
}
