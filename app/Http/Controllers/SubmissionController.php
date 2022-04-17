<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Category;
use App\Models\Idea;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubmissionController extends Controller
{
        // Submission View index
    public function submissionIndex()
    {
        $categories = Category::all();
        return view('user.submission.index', compact('categories'));
    }

    // Submission idea view
    public function submissionIdea()
    {
        $submissions = Submission::all();
        $DateNow = Carbon::now(); 
        return view('user.submission.submission-page', compact('submissions', 'DateNow'));
    }

    // Submission List View
    public function SubmissionList($id, Request $request){
        $submission = Submission::find($id);
        // Find all ideas inside that submission gate
        $ideas_all_in_submission_gate = Submission::find($id)->ideas;
        // Get all ideas belong to specific user
        $ideas = array();
        foreach($ideas_all_in_submission_gate as $key => $each_idea)
        {
            if($each_idea->user_id == Auth::user()->id)
            {
                // Store idea into array
                array_push($ideas, $each_idea);
            }
        }
        $DateNow = Carbon::now(); 
        return view('user.submission.submission-list', compact('submission', 'ideas','DateNow', 'id'));
    }

    // Idea Contribute View
    public function ContributeIdea($id, Request $request){
        $submissionId = $id;
        $name = Auth::user()->name;
        return view('user.submission.contribute-idea', compact('submissionId','name'))->with('id', $id);
    }

    // Submission Details View
    public function SubmissionDetails($id, Request $request){
        $ideaid = $request->query('ideaid');
        $idea = Idea::find($ideaid);
        $submissionId = $request->query('submissionid');
        $submission = Submission::find($submissionId);
        $DateNow = Carbon::now(); 
        return view('user.submission.submission-details', compact('idea','submission','DateNow'));
    }

    // Delete Ideas
    public function SubmissionDelete($id, $idea_id)
    {
        Idea::find($idea_id)->delete();
        if(!empty(Idea::find($idea_id)->fileuploads))
        {
            Idea::find($idea_id)->fileuploads->delete();
        } 
        Session::put('message','Remove Idea Success');
        return response()->redirectToRoute('submission.List', $id);
    }

    public function view_submission() 
    {
          $all_submission = Submission::paginate(10);        
        return view('admin.submission.view-submission',compact('all_submission'));
    }
    
    public function create_submission()
    {
        return view('admin.submission.create-submission');
    }
    
    public function save_submission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tag_name' => 'required',
            'tag_desc'=>'required',
            'closure_date' => 'required',
            'final_date' => 'required'
        ],[
            'tag_name.required' => 'Submission Name cannot be left blank',
            'tag_desc.required' => 'Description cannot be left blank',
            'closure_date.required' => 'Closure date cannot be left blank',
            'final_date.required' => 'Final Closure date cannot be left blank'
        ]);
        if($validator->passes())
        {
            $data = array();
            $data['id'] = mt_rand(100000, 999999);
            $data['name'] = $request->tag_name;
            $data['description'] = $request->tag_desc;
            $data['closure_date'] = $request->closure_date;
            $data['final_closure_date'] = $request->final_date;

            DB::table('submissions')->insert($data);

            Session::put('message','Create successfully');
            return Redirect::to('admin/create-submission');
        }
        return response()->redirectToRoute('create.submission')->withErrors($validator->errors());
    }

    public function delete_submission(Request $request, $tag_id){
        Submission::where('id',$tag_id)->delete();
        Session::put('message','Delete successfully!');
        return Redirect::to('/admin/view-submission ');
    }

    public function edit_submission(Request $request, $tagId)
    {
        $submission = Submission::find($tagId);
        return view('admin.submission.edit-submission',compact('submission'));
    }

    public function update_submission(Request $request, $tagId)
    {
        /*$data = $request->all();
        $tag = Submission::find($tagId);
        $tag->name = $data['tag_name'];
        $tag->description = $data['tag_desc'];
        $tag->closure_date = $data['closure_date'];
        $tag->final_closure_date = $data['final_date'];
        $tag->save();*/

        $data = array();
        $data['name'] = $request->tag_name;
        $data['description'] = $request->tag_desc;
        $data['closure_date'] = $request->closure_date;
        $data['final_closure_date'] = $request->final_date;
        DB::table('submissions')->where('id',$tagId)->update($data);

        Session::put('message','Update successfully');
        return Redirect::to('admin/view-submission');
    }
}
