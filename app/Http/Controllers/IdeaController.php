<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Idea;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Submission;
use App\Models\User;
use App\Models\Fileupload;
use App\Models\Reaction;
use App\Models\Type;
use App\Models\Department;
use App\Models\Viewer;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use ZipArchive;

class IdeaController extends Controller
{
    public function ideas(){
        $reaction_types = Type::all();
        return view('user.ideas', compact('reaction_types'));
    }

    public function ideas_details($id){
        // Viewer
        $find_viewer = Viewer::where('user_id', Auth::user()->id)->where('idea_id', $id)->first();
        if($find_viewer == null)
        {
            $viewer = new Viewer;
            $viewer->id = mt_rand(100000, 999999);
            $viewer->idea_id = $id;
            $viewer->user_id = Auth::user()->id;
            $viewer->last_visited_date = Carbon::now();
            $viewer->save();
        }
        else
        {
            $viewer = Viewer::find($find_viewer->id);
            $viewer->last_visited_date = Carbon::now();
            $viewer->save();
        }

        $comments = Comment::where('idea_id', $id)->get();
        $idea = Idea::find($id);
        $user = User::find($idea->user_id);
        $fileupload = Idea::find($id)->fileuploads;
        $count_comments = $comments->count();
        $reaction_types = Type::all();
        return view('user.ideas-details', compact('id', 'count_comments', 'idea', 'user', 'fileupload', 'reaction_types'));
    }

    public function storeIdea(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_select' => 'required',
            'title'=>'required',
            'description' => 'required',
            'content' => 'required'
        ],[
            'category_select.required' => 'Category Tag cannot be left blank',
            'title.required' => 'Idea Title cannot be left blank',
            'description.required' => 'Description cannot be left blank',
            'content.required' => 'Idea Content cannot be left blank'
        ]);
        if($validator->passes())
        {
            // Mail File
            $mail_file_path = array();
            // Create new object to using Idea model
            $idea = new Idea;
            // Insert data into database using model
            $idea_id = mt_rand(100000, 999999);
            $idea->id = $idea_id;
            $idea->title = $request->get('title');
            $idea->description = $request->description;
            $idea->content = $request->content;
            $idea->create_date = Carbon::now();
            $idea->last_modified_date = Carbon::now();
            if($request->is_anonymous == true)
            {
                $idea->isAnonymous = $request->is_anonymous;
            }
            else
            {
                $idea->isAnonymous = 0;
            }
            $idea->submission_id = $request->submission_id;
            $idea->user_id = Auth::user()->id;
            $idea->category_id = $request->category_select;
            $idea->save();

            // If Idea have file upload then store file into database also
            if($request->hasFile('document'))
            {
                foreach($request->document as $document)
                {
                    // Get Document FIle
                    $getDocument = $document;

                    // Get Original File Name "example.png, example.jpg, example.jpeg"
                    $OriginalFileName = $getDocument->getClientOriginalName();

                    // Get File Name
                    $FileName = current(explode('.', $OriginalFileName));
                    // Create New File Name
                    $FileNamenew = time().'-'.$FileName.rand(0,99).'.'.$getDocument->getClientOriginalExtension();

                    // Get File Path For Mail
                    $path = storage_path('uploads/documents/'.$FileNamenew);
                    array_push($mail_file_path, $path);

                    // Save file into the path
                    $getDocument->move(storage_path('uploads/documents'), $FileNamenew);

                    // Create new Object to use file upload model
                    $file = new Fileupload;
                    $file->id = mt_rand(100000, 999999);
                    $file->file_path = $FileNamenew;
                    $file->create_date = Carbon::now();
                    $file->description = "Staff Document";
                    $file->idea_id = $idea_id;
                    $file->save(); 
                }
            }

            // Content For Mail
            $username = User::find($idea->user_id)->value('name');
            $title = $idea->title;
            $content = $idea->content;
            $category = Category::find($idea->category_id)->value('name');
            $submission = Submission::find($idea->submission_id)->value('name');
            $date_submit = $idea->create_date;
            $idea_id = $idea_id;
            // Send Mail For QA Coordinary
            if(Auth::user()->department_id)
            {
                $_department = Department::find(Auth::user()->department_id);
                $user_inside_department = User::where('department_id', $_department->id)->get();
                foreach($user_inside_department as $key =>$user)
                {
                    // Find QA Coordinary inside this department
                    if($user->roles[0]->name == "QA Coordinator")
                    {
                        $QA_mail = $user->email;
                        $QA_Name = $user->name;
                        Mail::send('user.mail.sendmail', compact('username', 'content', 'category', 'submission', 'date_submit', 'idea_id'), function ($message) use($QA_Name, $QA_mail,$title, $mail_file_path, ){
                            // $message->sender('staff01@gmail.com', 'Staff01');
                            // $message->to('conghuynh9c@gmail.com', 'Le Cong Huynh');
                            $message->to($QA_mail, $QA_Name);
                            // $message->cc('john@johndoe.com', 'John Doe');
                            // $message->bcc('john@johndoe.com', 'John Doe');
                            // $message->replyTo('john@johndoe.com', 'John Doe');
                            $message->subject($title);
                            // $message->priority(3);
                
                            foreach($mail_file_path as $key => $file_path)
                            {
                                $message->attach($file_path);
                            }
                        });
                    }
                }
            }
            Session::put('message','The idea has been recorded, please wait for approval');
            return Redirect::to('/ideas');
        }
        return response()->redirectToRoute('Idea.Contribute', $request->submission_id)->withErrors($validator->errors());
    }

    // Store Update Idea
    public function storeUpdateIdea(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_select' => 'required',
            'title'=>'required',
            'description' => 'required',
            'content' => 'required'
        ],[
            'category_select.required' => 'Category Tag cannot be left blank',
            'title.required' => 'Idea Title cannot be left blank',
            'description.required' => 'Description cannot be left blank',
            'content.required' => 'Idea Content cannot be left blank'
        ]);
        // Create new object to using Idea model
        $idea = Idea::find($request->idea_id);
        if($validator->passes())
        {
            // Mail File
            $mail_file_path = array();
            // Insert data into database using model
            $idea->title = $request->get('title');
            $idea->description = $request->description;
            $idea->content = $request->content;
            $idea->last_modified_date = Carbon::now();
            if($request->is_anonymous == true)
            {
                $idea->isAnonymous = $request->is_anonymous;
            }
            else
            {
                $idea->isAnonymous = 0;
            }
            $idea->submission_id = $request->submission_id;
            $idea->user_id = Auth::user()->id;
            $idea->category_id = $request->category_select;
            $idea->save();

            // If Idea have file upload then store file into database also
            if($request->hasFile('document'))
            {
                foreach($request->document as $document)
                {
                    // Get Document FIle
                    $getDocument = $document;

                    // Get Original File Name "example.png, example.jpg, example.jpeg"
                    $OriginalFileName = $getDocument->getClientOriginalName();

                    // Get File Name
                    $FileName = current(explode('.', $OriginalFileName));
                    // Create New File Name
                    $FileNamenew = time().'-'.$FileName.rand(0,99).'.'.$getDocument->getClientOriginalExtension();

                    // Get File Path For Mail
                    $path = storage_path('uploads/documents/'.$FileNamenew);
                    array_push($mail_file_path, $path);

                    // Save file into the path
                    $getDocument->move(storage_path('uploads/documents'), $FileNamenew);

                    // Create new Object to use file upload model
                    $file = new Fileupload;
                    $file->id = mt_rand(100000, 999999);
                    $file->file_path = $FileNamenew;
                    $file->create_date = Carbon::now();
                    $file->description = "Staff Document";
                    $file->idea_id = $idea->id;
                    $file->save(); 
                }
            }

            // Content For Mail
            $username = User::find($idea->user_id)->value('name');
            $title = 'User '.$idea->user->name.' Update '.$idea->title.' Idea.';
            $content = $idea->content;
            $category = Category::find($idea->category_id)->value('name');
            $submission = Submission::find($idea->submission_id)->value('name');
            $date_submit = $idea->create_date;
            $idea_id = $idea->id;
            // Send Mail For QA Coordinary
            if(Auth::user()->department_id)
            {
                $_department = Department::find(Auth::user()->department_id);
                $user_inside_department = User::where('department_id', $_department->id)->get();
                foreach($user_inside_department as $key =>$user)
                {
                    // Find QA Coordinary inside this department
                    if($user->roles[0]->name == "QA Coordinator")
                    {
                        $QA_mail = $user->email;
                        $QA_Name = $user->name;
                        Mail::send('user.mail.sendmail', compact('username', 'content', 'category', 'submission', 'date_submit', 'idea_id'), function ($message) use($QA_Name, $QA_mail,$title, $mail_file_path, ){
                            // $message->sender('staff01@gmail.com', 'Staff01');
                            // $message->to('conghuynh9c@gmail.com', 'Le Cong Huynh');
                            $message->to($QA_mail, $QA_Name);
                            // $message->cc('john@johndoe.com', 'John Doe');
                            // $message->bcc('john@johndoe.com', 'John Doe');
                            // $message->replyTo('john@johndoe.com', 'John Doe');
                            $message->subject($title);
                            // $message->priority(3);
                
                            foreach($mail_file_path as $key => $file_path)
                            {
                                $message->attach($file_path);
                            }
                        });
                    }
                }
            }
            Session::put('message','Update Idea Successful!');
            // return response()->back();
            return Redirect::to('ideas/submission/'.$idea->submission_id.'/contribute/edit?ideaid='.$idea->id);
        }
        return redirect()->back()->withErrors($validator->errors());
    }

    // Delete Single File Upload of specific idea
    public function IdeaDeleteFile(Request $request)
    {
        $file_id = $request->query('file_id');
        $file = Fileupload::find($file_id);
        Session::put('message','Delete File '.$file->file_path.' Successful!');
        $file->delete();
        return redirect()->back();
    }

    // Get Download Document of Staff
    public function GetDownload($id)
    {
        $fileupload = Idea::find($id)->fileuploads;
        
        // Create object to use zip class and zip all files of specific idea and download it in ".zip" format
        $zip = new ZipArchive();
        $zipfile = time().'-'.'documents.zip';

        if($zip->open(storage_path('uploads/documents/zip/'.$zipfile), ZipArchive::CREATE) === TRUE)
        {
            foreach($fileupload as $file)
            {
                $relativenameInZipfile = 'documents/'.basename($file->file_path);
                $zip->addFile(storage_path('uploads/documents/'. $file->file_path), $relativenameInZipfile);
            }
        }
        else
        {
            echo "Failed to open or create ".$zipfile; 
        }
        $zip->close();
        // Return File Download and Delete File in Zip folder after download.
        return \Response::download(storage_path('uploads/documents/zip/'.$zipfile))->deleteFileAfterSend(true);
    }

    // Save Reaction
    public function Reaction($id, Request $request)
    {
        $reaction = new Reaction;
        $reaction->id = mt_rand(100000, 999999);
        $reaction->create_date = Carbon::now();
        $reaction->idea_id = $id;
        $reaction->user_id = Auth::user()->id;
        
        // If reaction is first time then take else delete old reaction and assign new one
        $all_reactions = Reaction::where('type_id', $request->content)
        ->where('idea_id', $id)
        ->where('user_id', Auth::user()->id)->first();
        // find all reaction that not relative to
        $not_relative_reaction = Reaction::where('idea_id', $id)
        ->where('user_id', Auth::user()->id)->get();
        if($not_relative_reaction)
        {
            foreach($not_relative_reaction as $key => $value)
            {
                if($value->type_id != $request->content)
                {
                    $delete_reaction = Reaction::find($value->id);
                    $delete_reaction->delete();
                }
            }
        }

        if($all_reactions)
        {
            $delete_reaction = Reaction::find($all_reactions->id);
            $delete_reaction->delete();
            return response()->json(['bool'=>false]);
        }
        else if($all_reactions == null){
            $reaction->type_id = $request->content;
            $reaction->save();
            return response()->json(['bool'=>true]);
        }
    }
    
    // Admin View
    public function censor_ideas()
    {
        // Store Ideas Inside data_idea
        $data_idea = array();
        $department_all = array();
        // Make Sure User Are Inside 1 department
        if(Auth::user()->department_id)
        {
            // Find User Belong to specific department
            $user_department = Department::find(Auth::user()->department_id)->users;
            // Find Idea of that user inside department
            foreach($user_department as $user)
            {
                $AllIdea = Idea::where('user_id', $user->id)->get();
                if($AllIdea->isNotEmpty())
                {
                    foreach($AllIdea as $key => $idea)
                    {
                        $data_all_idea = array();
                        $data_all_idea['id'] = $idea->id;
                        $data_all_idea['title'] = $idea->title;
                        $data_all_idea['description'] = $idea->description;
                        $data_all_idea['content'] = $idea->content;
                        $data_all_idea['user_id'] = $idea->user_id;
                        $data_all_idea['category_id'] = $idea->category_id;
                        $data_all_idea['submission_id'] = $idea->submission_id;
                        $data_all_idea['isApprove'] = $idea->isApprove;
                        $data_all_idea['isAnonymous'] = $idea->isAnonymous;
                        $data_all_idea['create_date'] = $idea->create_date;
                        $data_all_idea['last_modified_date'] = $idea->last_modified_date;
                        \array_push($data_idea, $data_all_idea);
                    }
                }
            }
        }
        else
        {
            if(Auth::user()->roles[0]->name == 'Administrator')
            {
                $department_all = Department::all();
            }
        }
        return view('admin.idea.censor-ideas', compact('data_idea', 'department_all'));
    }

    public function approve($IdeaId){

        $idea = Idea::find($IdeaId);
        $idea->isApprove = true;
        $idea->save();
        Session::put('message','Approved!');
        return Redirect::to('admin/censor-ideas');
    }
    public function unApprove($IdeaId){

        $idea = Idea::find($IdeaId);
        $idea->isApprove = false;
        $idea->save();
        Session::put('message','Unapprove!');
        return Redirect::to('admin/censor-ideas');
    }

    // More Info Ideas View Admin
    public function IdeasInfo()
    {
        // Store all user Inside data_users
        $data_users = array();
        $department_all = array();
        // Make Sure User Are Inside 1 department
        if(Auth::user()->department_id)
        {
            // Find User Belong to specific department
            $user_department = Department::find(Auth::user()->department_id)->users;
            // Find Idea of that user inside department
            foreach($user_department as $user)
            {
                \array_push($data_users, $user);
            }
        }

        else
        {
            if(Auth::user()->roles[0]->name == 'Administrator')
            {
                $department_all = Department::all();
            }
        }
        return view('admin.idea.more-info', compact('data_users', 'department_all'));
    }

    // Send Mail Encourage Staff
    public function IdeasEncourage(Request $request)
    {
        // Send Mail For Staff To Encourage Contribute Idea
        $user = User::find($request->user_id);
        $department = User::find($request->user_id)->department->value('name');
        $username = $user->name;
        $user_mail = $request->email_address;
        $message_content = $request->message_content_encourage;
        $qa_email = Auth::user()->email;
        $send_date = Carbon::now();
        $title = 'Encourage Contribute Idea';
        Mail::send('user.mail.encourage_mail', compact('username', 'message_content', 'send_date', 'department', 'qa_email'), function ($message) use($title,$username, $user_mail){
            // $message->sender('staff01@gmail.com', 'Staff01');
            // $message->to('conghuynh9c@gmail.com', 'Le Cong Huynh');
            $message->to($user_mail, $username);
            // $message->cc('john@johndoe.com', 'John Doe');
            // $message->bcc('john@johndoe.com', 'John Doe');
            // $message->replyTo('john@johndoe.com', 'John Doe');
            $message->subject($title);
            // $message->priority(3);
        });
        return Redirect::to('/admin/ideas/more-info')->with('message', 'Send Encourage Mail Success!');
    }

    // Delete All User Idea
    public function IdeasUserDelete(Request $request, $id)
    {
        if(User::find($id)->ideas)
        {
            foreach(User::find($id)->ideas as $idea)
            {
                Idea::find($idea->id)->delete();
            }
            return Redirect::to('/admin/ideas/more-info')->with('Message', 'Delete User Ideas Success!');
        }
        else
        {
            return Redirect::to('/admin/ideas/more-info');
        }
    }

    // Comment
    public function comment(Request $request, $idea_id)
    {
        $comment_date = Carbon::now();
        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ],[
            'content.required' => 'Content cannot be left blank'
        ]);
        if($validator->passes())
        {
            $commentid = mt_rand(100000, 999999);
            $comment = new Comment;
            $comment->id = $commentid;
            $comment->content = $request->content;
            $comment->create_date = $comment_date;
            $comment->isAnonymous = $request->anonymous;
            $comment->last_modified_date = Carbon::now();
            $comment->idea_id = $idea_id;
            $comment->user_id = Auth::user()->id;
            $comment->comment_id = $request->reply_id ? $request->reply_id : 0;
            $comment->save();
            // return response()->json(['data' => $comment]);
            $data_comments = Comment::where(['idea_id' => $idea_id, 'comment_id' => 0])->orderBy('create_date', 'desc')->get();

            // Send Mail For Actor of idea
            $username = Auth::user()->name;
            $user_receive_mail_id = Auth::user()->id;
            $user_mail = User::find($user_receive_mail_id)->value('email');
            $idea_title = Idea::find($idea_id)->value('title');
            $title = 'You have new comment on your "'.$idea_title. '" idea';
            $content = $request->content;
            Mail::send('user.mail.new_comment', compact('username', 'content', 'comment_date', 'idea_id', 'idea_title'), function ($message) use($title, $username, $user_mail){
                // $message->sender('staff01@gmail.com', 'Staff01');
                // $message->to('conghuynh9c@gmail.com', 'Le Cong Huynh');
                $message->to($user_mail, $username);
                // $message->cc('john@johndoe.com', 'John Doe');
                // $message->bcc('john@johndoe.com', 'John Doe');
                // $message->replyTo('john@johndoe.com', 'John Doe');
                $message->subject($title);
                // $message->priority(3);
            });
            return view('user.comment.index', compact('data_comments'));
        }
        return response()->json(['error'=>$validator->errors()->first()]);
    }

    // List All Idea
    public function IdeaAllList(Request $request)
    {
        // Get Query Page if exist return to render all page else using part of page
        if($request->query('pages'))
        {
            $pages = $request->query('pages');
            return view('user.idea.list-all-idea', compact('pages'));
        }
        else
        {
            $pages = 1;
            return view('user.idea.list-all-idea', compact('pages'));
        }
    }

    // List Most Popular Idea
    public function IdeaMostPopularList(Request $request)
    {
        // Get Query Page if exist return to render all page else using part of page
        if($request->query('pages'))
        {
            $pages = $request->query('pages');
            return view('user.idea.list-most-popular-idea', compact('pages'));
        }
        else
        {
            $pages = 1;
            return view('user.idea.list-most-popular-idea', compact('pages'));
        }
    }

    // List Most Viewed Idea
    public function IdeaMostViewedList(Request $request)
    {
        if($request->query('pages'))
        {
            $pages = $request->query('pages');
            return view('user.idea.list-most-viewed-idea', compact('pages'));
        }
        else
        {
            $pages = 1;
            return view('user.idea.list-most-viewed-idea', compact('pages'));
        }
    }

    // List Latest Idea
    public function LatestIdeaList(Request $request)
    {
        if($request->query('pages'))
        {
            $pages = $request->query('pages');
            return view('user.idea.list-latest-idea', compact('pages'));
        }
        else
        {
            $pages = 1;
            return view('user.idea.list-latest-idea', compact('pages'));
        }
    }

    // List Latest Comments
    public function LatestCommentList(Request $request)
    {
        if($request->query('pages'))
        {
            $pages = $request->query('pages');
            return view('user.idea.list-latest-idea-comments', compact('pages'));
        }
        else
        {
            $pages = 1;
            return view('user.idea.list-latest-idea-comments', compact('pages'));
        }
    }

    // Paginate
    public static function paginate(Collection $collection, $pageSize)
    {
        $page = Paginator::resolveCurrentPage('pages');
        $total = $collection->count();
        return self::paginator($collection->forPage($page, $pageSize), $total, $pageSize, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'pages',
        ]);
    }

    /**
     * Create a new length-aware paginator instance
     * 
     * @param \Illuminate\Support\Collection $items
     * @param int $total
     * @param int $perPage
     * @param int $currentPage
     * @param array $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
    */
    protected static function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }
}
