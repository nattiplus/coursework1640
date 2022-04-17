<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use App\Models\Idea;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // View Index
    public function index()
    {
        return view('admin.home.index');
    }

    // View Dashboard
    public function dashboard() {
        // Number of ideas per department and percentage of ideas per department

        // COUNT(*) as department_count
        $datas = array();
        $departments = Department::select(DB::raw("id,name"))->get();
        $ideas = array();
        foreach($departments as $index => $department)
        {
            $count = 0;
            // find all user belong to that department
            $users = Department::find($department->id)->users;
            foreach($users as $user)
            {
                // count user idea per each department     
                $count_ideas = Idea::select(DB::raw("COUNT(*) as idea_count"))->where('user_id',$user->id)->pluck('idea_count');
                $count += $count_ideas[0];
            }
            array_push($ideas, $count);
            // assign to datas array
            $datas[$department->name] = $ideas[$index];
        }

        // Number of contributors within each Department
        
        // COUNT(*) as department_count
        $datas_contributors = array();
        $departments = Department::select(DB::raw("id,name"))->get();
        $contributors = array();
        foreach($departments as $index => $department)
        {
            $count = 0;
            // find all user belong to that department
            $users = Department::find($department->id)->users;
            foreach($users as $user)
            {
                // count user that have already contribute their idea per each department     
                $count_users = User::find($user->id)->ideas->count();
                if($count_users != 0)
                {
                    $count += 1;
                }
            }
            array_push($contributors, $count);
            // assign to $datas_contributors array
            $datas_contributors[$department->name] = $contributors[$index];
        }
        return view('admin.dashboard.index', compact('datas', 'datas_contributors'));
    }
    
    // // View Topic
    // public function topic() {
    //     return view('admin.topic.index');
    // }

    // View Exception Report
    public function Report()
    {
        // Ideas without a comment
        // list All Idea
        $all_ideas = Idea::all();
        // Store all ideas without comment into 'ideas' array
        $ideas = array();
        foreach($all_ideas as $key => $idea)
        {
            // Find comment inside each idea
            $comments = Idea::find($idea->id)->comments;
            if($comments->isEmpty())
            {
                \array_push($ideas, $idea);
            }
        }

        // Anonymous Ideas and comments

        // Store all ideas without comment into 'ideas' array
        $anonymous_ideas = array();
        foreach($all_ideas as $key => $idea)
        {
            // Find comment inside each idea
            $a_comments = Idea::find($idea->id)->comments;
            if($a_comments->isNotEmpty())
            {
                \array_push($anonymous_ideas, $idea);
            }
        }
        return view('admin.Exception_reports.index', compact('ideas', 'anonymous_ideas'));
    }

    // View Ideas without a comment
    public function IdeasWithoutCommentsReport()
    {
        // Ideas without a comment
        // list All Idea
        $all_ideas = Idea::all();
        // Store all ideas without comment into 'ideas' array
        $ideas = array();
        foreach($all_ideas as $key => $idea)
        {
            // Find comment inside each idea
            $comments = Idea::find($idea->id)->comments;
            if($comments->isEmpty())
            {
                \array_push($ideas, $idea);
            }
        }
        return view('admin.Exception_reports.ideas-without-comments', compact('ideas'));
    }

    // View Ideas without a comment
    public function AnonymousIdeasAndCommentsReport()
    {
        // Anonymous Ideas and comments
        // list All Idea
        $all_ideas = Idea::all();
        
        // Store all ideas without comment into 'ideas' array
        $anonymous_ideas = array();
        foreach($all_ideas as $key => $idea)
        {
            // Find comment inside each idea
            $a_comments = Idea::find($idea->id)->comments;
            if($a_comments->isNotEmpty())
            {
                \array_push($anonymous_ideas, $idea);
            }
        }
        return view('admin.Exception_reports.anonymous-ideas-and-comments', compact('anonymous_ideas'));
    }
}
