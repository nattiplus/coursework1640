<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['prefix'=>'/', 'middleware'=>'auth'], function(){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Route::get('/topic', [App\Http\Controllers\HomeController::class],'topic')->name('topic');
});

// Idea
Route::group(['prefix'=>'/ideas', 'middleware'=>'auth'], function(){
        // Idea
        Route::get('/', 'App\Http\Controllers\IdeaController@ideas')->name('list.ideas');
        Route::post('/', 'App\Http\Controllers\IdeaController@storeIdea')->name('store.idea');
        Route::get('/details/{id}', 'App\Http\Controllers\IdeaController@ideas_details')->name('idea.details');
        Route::get('/details/getdocuments/{id}', 'App\Http\Controllers\IdeaController@GetDownload')->name('get.documents');
        Route::post('/reaction/{id}', 'App\Http\Controllers\IdeaController@Reaction')->name('create.reaction');

        // List Idea
        Route::get('/all', 'App\Http\Controllers\IdeaController@IdeaAllList')->name('list.ideas.all');
        Route::get('/most-popular-ideas', 'App\Http\Controllers\IdeaController@IdeaMostPopularList')->name('list.ideas.most-popular-ideas');
        Route::get('/most-viewed-ideas', 'App\Http\Controllers\IdeaController@IdeaMostViewedList')->name('list.ideas.most-viewed-ideas');
        Route::get('/latest-ideas', 'App\Http\Controllers\IdeaController@LatestIdeaList')->name('list.ideas.latest-ideas');
        Route::get('/latest-comments', 'App\Http\Controllers\IdeaController@LatestCommentList')->name('list.ideas.latest-comments');
    
        // Submission
        Route::get('/submission', 'App\Http\Controllers\SubmissionController@submissionIdea')->name('submission.idea');
        Route::get('/submission/{id}/contribute', 'App\Http\Controllers\SubmissionController@SubmissionList')->name('submission.List');
        Route::get('/submission/{id}/contribute/create', 'App\Http\Controllers\SubmissionController@ContributeIdea')->name('Idea.Contribute');
        Route::get('/submission/{id}/contribute/edit', 'App\Http\Controllers\SubmissionController@SubmissionDetails')->name('submission.Details');
        Route::post('/submission/{id}/contribute/edit', 'App\Http\Controllers\IdeaController@storeUpdateIdea')->name('update.idea.submission');
        Route::get('/submission/{id}/contribute/delete/{idea_id}', 'App\Http\Controllers\SubmissionController@SubmissionDelete')->name('submission.delete');
        Route::get('/submission/{submission_id}/contribute/file', 'App\Http\Controllers\IdeaController@IdeaDeleteFile')->name('idea.delete.file');
    
        // Download
        Route::get('/singledownload', 'App\Http\Controllers\HomeController@SingleFileDownload')->name('idea.singledownload');
        // CSV
        Route::get('/export-csv', 'App\Http\Controllers\HomeController@CSVFileDownload')->name('export.csv');
        // Data Ideas
        Route::get('/export-documents-ideas', 'App\Http\Controllers\HomeController@GetIdeaDocuments')->name('export.ideas.documents');
});

// Comment Ideas
Route::group(['prefix' => 'ajax'], function(){
    Route::post('/ideas-details/{idea_id}/comment', 'App\Http\Controllers\IdeaController@comment')->name('ajax.comment');
});

Route::group(['prefix'=>'/admin','middleware'=>'auth'], function(){
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home');
    Route::get('/dashboard', 'App\Http\Controllers\AdminController@dashboard')->name('admin.dashboard');
    // Route::get('/topic', 'App\Http\Controllers\AdminController@topic')->name('admin.topic');

    // Manage Ideas
    Route::get('/censor-ideas', 'App\Http\Controllers\IdeaController@censor_ideas')->name('idea.cencor');
    Route::get('/approve/{IdeaId}', 'App\Http\Controllers\IdeaController@approve')->name('idea.approve');
    Route::get('/unApprove/{IdeaId}', 'App\Http\Controllers\IdeaController@unApprove')->name('idea.unApprove');
    Route::get('/ideas/more-info', 'App\Http\Controllers\IdeaController@IdeasInfo')->name('ideas.info');
    Route::post('/ideas/more-info/send-mail', 'App\Http\Controllers\IdeaController@IdeasEncourage')->name('ideas.encourage.post');
    Route::get('/ideas/more-info/delete/{id}', 'App\Http\Controllers\IdeaController@IdeasUserDelete')->name('ideas.user.delete');

    //Category
    Route::get('/view-category', 'App\Http\Controllers\CategoryController@view_category')->name('view.category');
    Route::get('/create-category', 'App\Http\Controllers\CategoryController@create_category')->name('create.category');
    Route::post('/save-category', 'App\Http\Controllers\CategoryController@save_category')->name('save.category');
    Route::get('/delete-category/{cate_id}', 'App\Http\Controllers\CategoryController@delete_category')->name('delete.category');
    Route::get('/edit-category/{cate_id}', 'App\Http\Controllers\CategoryController@edit_category')->name('update.category');;
    Route::post('/update-category/{cate_id}', 'App\Http\Controllers\CategoryController@update_category')->name('post.update.category');

    // Manage Submission
    Route::get('/view-submission', 'App\Http\Controllers\SubmissionController@view_submission')->name('view.submission');
    Route::get('/create-submission', 'App\Http\Controllers\SubmissionController@create_submission')->name('create.submission');
    Route::post('/save-submission', 'App\Http\Controllers\SubmissionController@save_submission')->name('save.submission');
    Route::get('/delete-submission/{submission_id}', 'App\Http\Controllers\SubmissionController@delete_submission')->name('delete.submission');
    Route::get('/edit-submission/{submission_id}', 'App\Http\Controllers\SubmissionController@edit_submission')->name('update.submission');
    Route::post('/update-submission/{submission_id}', 'App\Http\Controllers\SubmissionController@update_submission')->name('post.update.submission');

    // Manage Department
    Route::get('/view-department', 'App\Http\Controllers\DepartmentController@view_department')->name('view.department');
    Route::get('/create-department', 'App\Http\Controllers\DepartmentController@create_department')->name('create.department');
    Route::post('/save-department', 'App\Http\Controllers\DepartmentController@save_department')->name('save.department');
    Route::get('/delete-department/{dept_id}', 'App\Http\Controllers\DepartmentController@delete_department')->name('delete.department');
    Route::get('/edit-department/{dept_id}', 'App\Http\Controllers\DepartmentController@edit_department')->name('update.department');
    Route::post('/update-department/{dept_id}', 'App\Http\Controllers\DepartmentController@update_department')->name('post.update.department');

    // Manage User
    Route::get('/view-user', 'App\Http\Controllers\UserController@view_user')->name('view.user');
    Route::get('/create-user', 'App\Http\Controllers\UserController@create_user')->name('create.user');
    Route::post('/save-user', 'App\Http\Controllers\UserController@save_user')->name('save.user');
    Route::get('/delete-user/{user_id}', 'App\Http\Controllers\UserController@delete_user')->name('delete.user');
    Route::get('/edit-user/{user_id}', 'App\Http\Controllers\UserController@edit_user')->name('update.user');
    Route::post('/update-user/{user_id}', 'App\Http\Controllers\UserController@update_user')->name('post.update.user');
    Route::get('/details-user/{user_id}', 'App\Http\Controllers\UserController@details_user')->name('user.details');

    // Manage Role
    Route::get('/role', 'App\Http\Controllers\RoleController@index')->name('view.role');
    Route::get('/role/create', 'App\Http\Controllers\RoleController@create')->name('role.create');
    Route::post('/role/create', 'App\Http\Controllers\RoleController@postcreate')->name('role.create.post');
    Route::get('/role/update/{id}', 'App\Http\Controllers\RoleController@UpdateRole')->name('role.update');
    Route::post('/role/update/{id}', 'App\Http\Controllers\RoleController@StoreUpdateRole')->name('role.update.post');
    Route::get('/role/details/{id}', 'App\Http\Controllers\RoleController@RoleDetails')->name('role.details');
    Route::get('/role/delete/{id}', 'App\Http\Controllers\RoleController@DeleteRole')->name('role.delete');

    // Manage Role-User
    Route::get('/user-role', 'App\Http\Controllers\RoleController@indexRoleUser')->name('user_role.list');
    Route::get('/user-role/create', 'App\Http\Controllers\RoleController@CreateRoleUser')->name('user_role.create');
    Route::post('/user-role/create', 'App\Http\Controllers\RoleController@PostCreateRoleUser')->name('user_role.create.post');
    Route::get('/user-role/details/{user}', 'App\Http\Controllers\RoleController@UserRoleDetails')->name('user_role.details');

    // Report
    Route::get('/exception-report', 'App\Http\Controllers\AdminController@Report')->name('exception.report');
    Route::get('/exception-report/ideas-without-comments', 'App\Http\Controllers\AdminController@IdeasWithoutCommentsReport')->name('ideas.without.comments');
    Route::get('/exception-report/anonymous-ideas-and-comments', 'App\Http\Controllers\AdminController@AnonymousIdeasAndCommentsReport')->name('Anonymous.ideas.and.comments');
});
