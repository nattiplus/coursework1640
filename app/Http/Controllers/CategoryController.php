<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CategoryController extends Controller
{
    // View Category
    public function view_category() 
    {
        $all_category = Category::paginate(10);
         
        return view('admin.category.view-category',compact('all_category'));
    }
    
    public function create_category()
    {
        return view('admin.category.create-category');
    }
    
    public function save_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cate_name' => 'required',
            'create_date'=>'required',
            'cate_desc' => 'required'
        ],[
            'cate_name.required' => 'Category name cannot be left blank',
            'create_date.required' => 'Create Date cannot be left blank',
            'cate_desc.required' => 'Description cannot be left blank'
        ]);
        if($validator->passes())
        {
            $data = $request->all();
            $cate = new Category();
            $cate->id = mt_rand(100000, 999999);
            $cate->name = $data['cate_name'];
            $cate->description = $data['cate_desc'];
            $cate->created_at = $data['create_date'];
            $cate->save();

            Session::put('message','Create successfully');
            return Redirect::to('admin/create-category');
        }
        return response()->redirectToRoute('create.category')->withErrors($validator->errors());
        // ->json(['error'=>$validator->errors()]);
    }

    public function delete_category(Request $request, $cate_id){
        Category::where('id',$cate_id)->delete();
        Session::put('message','Delete successfully!');
        return Redirect::to('/admin/view-category ');
    }

    public function edit_category(Request $request, $cateId)
    {
        $category = Category::find($cateId);
        return view('admin.category.edit-category',compact('category'));
    }

    public function update_category(Request $request, $cateId)
    {
        $data = $request->all();
        $cate = Category::find($cateId);
        $cate->name = $data['cate_name'];
        $cate->description = $data['cate_desc'];
        $cate->updated_at = Carbon::now();
        $cate->save();

        Session::put('message','Update successfully');
        return Redirect::to('admin/view-category');
    }
}
