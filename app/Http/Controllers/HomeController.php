<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Models\Idea;
use App\Models\Fileupload;
use App\Models\Category;
use App\Models\Submission;
use App\Models\User;
use App\Models\Comment;
use ZipArchive;
use File;
use Mail;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user.home');
    }

    public function topic(){
        return view('user.topic');
    }

    // Get Single Download FIle
    public function SingleFileDownload(Request $request){
        $file_name = $request->query('file');
        return \Response::download(storage_path('uploads/documents/'.$file_name));
    }

    // Get CSV Data
    public function CSVFileDownload(){
        // Create File Name for CSV
        $filename = 'data.csv';
        // Get All Idea data inside database using idea model
        $ideas = Idea::all();
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        // Create Column for CSV file
        $columns = array('id', 'title', 'description', 'content', 'user', 'category', 'submission', 'closure_date', 'final_closure_date', 'isApprove', 'isAnonymous', 'create_date', 'last_modified_date', 'comments', 'Thumbs Up', 'Thumbs Down', 'viewers');
        // Create callback function then create file and put data into it
        $callback = function() use($ideas, $columns){
            // Create Buffer memory to store file
            $file = fopen('php://output', 'w');
            // Set up csv file
            fputcsv($file, $columns);

            // Create row and Write data into CSV FIle
            foreach($ideas as $idea)
            {
                $row['id'] = $idea->id;
                $row['title'] = $idea->title;
                $row['description'] = $idea->description;
                $row['content'] = $idea->content;
                if($idea->isAnonymous == true)
                {
                    $row['user'] = 'anonymous';
                }
                else
                {
                    $row['user'] = $idea->user->name;
                }
                $row['category'] = $idea->category->name;
                $row['submission'] = $idea->submission->name;
                $row['closure_date'] = $idea->submission->closure_date;
                $row['final_closure_date'] = $idea->submission->final_closure_date;
                $row['isApprove'] = $idea->isApprove;
                if($idea->isAnonymous == true)
                {
                    $row['isAnonymous']= $idea->isAnonymous;
                }
                else
                {
                    $row['isAnonymous']= 0;
                }
                $row['create_date'] = $idea->create_date;
                $row['last_modified_date'] = $idea->last_modified_date;
                $row['comments'] = $idea->comments->count();
                // Count Thumbs Up and Thumbs Down
                $count_like = 0;
                $count_dislike = 0;
                if($idea->reactions)
                {
                    foreach($idea->reactions as $reaction)
                    {
                        if($reaction->type)
                        {
                            if($reaction->type->reaction_type == 'Like')
                            {
                                $count_like++;
                            }
                            else
                            {
                                $count_dislike++;
                            }
                        }
                    }
                }
                $row['Thumbs Up'] = $count_like;
                $row['Thumbs Down'] = $count_dislike;
                $row['viewers'] = $idea->viewers->count();

                fputcsv($file, array($row['id'], $row['title'], $row['description'], $row['content'], $row['user'], $row['category'], $row['submission'], $row['closure_date'], $row['final_closure_date'], $row['isApprove'], $row['isAnonymous'], $row['create_date'], $row['last_modified_date'], $row['comments'], $row['Thumbs Up'], $row['Thumbs Down'], $row['viewers']));
            }

            // Close file after insert data into csv file
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    // Get All Idea Documents Download
    public function GetIdeaDocuments()
    {
        // FInd All Ideas
        $ideas = Idea::all();
        // Create object to use zip class and zip all files of specific idea and download it in ".zip" format
        $zip = new ZipArchive();
        $zipfile = time().'-'.'documents.zip';

        if($zip->open(storage_path('uploads/documents/zip/'.$zipfile), ZipArchive::CREATE) === TRUE)
        {
            foreach($ideas as $key => $idea)
            {
                $fileupload = Idea::find($idea->id)->fileuploads;
                foreach($fileupload as $file)
                {
                    $relativenameInZipfile = 'documents/idea_'.$idea->id.'_'.$idea->title.'_'.$idea->user->name.'/'.basename($file->file_path);
                    $zip->addFile(storage_path('uploads/documents/'. $file->file_path), $relativenameInZipfile);
                }
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
}
