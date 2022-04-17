@if (empty($pages))
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="most-viewed-ideas-tab">
        Most View
    </div>
</div>
@else
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{URL::asset('font/css/all.css')}}">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ URL::asset('css/style.css'); }}">
        {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Jquery Lib -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
        <body class="antialiased">
            <div class="loader">
              <img src="https://s13.favim.com/orig/170530/gif-world-Favim.com-5195898.gif" alt="Loading...">
            </div>
            <header>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                  <div class="container-fluid">
                    <a class="navbar-brand" href="{{URL::to('/')}}">
                        <img src="https://i.pinimg.com/originals/0c/3b/3a/0c3b3adb1a7530892e55ef36d3be6cb8.png" width="40" height="40">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->can('admin.home'))
                                <li><a class="dropdown-item" href="{{ route('admin.home') }}">Management</a></li>                                  
                                @endif
                                <li><a class="dropdown-item" href="{{ route('submission.idea') }}">Contribute Idea</a></li>
                                <li><a class="dropdown-item" href="{{URL::to('/ideas')}}">View All Idea</a></li>
                                <li class="border-top border-2">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                              </ul>
                            </li>
                        @endguest
                      </ul>
                      {{-- <form class="d-flex">
                        <input class="form-control me-2 border border-info" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-info text-dark" type="submit">Search</button>
                      </form> --}}
                    </div>
                  </div>
                </nav>
            </header>

            <section>
                <div class="container">
                    @include('user.breadcrumbs.index')
                </div>
                <?php
                $submissions = App\Models\Submission::all();
                $data_submission = array();
                if($submissions)
                {
                    foreach($submissions as $key => $submission)
                    {
                        $data = array();
                        $data['final_closure_date'] = $submission->final_closure_date;
                        array_push($data_submission, $data);
                    }
                    $submission_final_closure_date = collect($data_submission)->sortBy('final_closure_date')->reverse()->toArray();
                    $sort_final_closure_date = array();
                    foreach($submission_final_closure_date as $final_closure_date_arr)
                    {
                        foreach($final_closure_date_arr as $final_closure_date)
                        {
                            array_push($sort_final_closure_date, $final_closure_date);
                        }
                    }
                    if (Auth::user()->can('export.ideas.documents') && Auth::user()->can('export.csv') && $sort_final_closure_date[0] < Carbon\Carbon::now() )
                    {?>
                        <div class="text-center mt-3">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa-solid fa-download"></i> Download Data
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Download Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>How To Download</h5>
                                        <p>Press <a href="#" role="button" class="btn btn-outline-primary popover-test disabled" title="Popover title" data-bs-content="Download">Download</a> button below to download specific data.</p>
                                    </div>
                                    <div class="modal-footer">
                                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button> --}}
                                    <a href="{{ route('export.csv') }}" class="btn btn-outline-primary"><i class="fa-solid fa-download"></i> Download As CSV</a>
                                    <a href="{{ route('export.ideas.documents') }}" class="btn btn-outline-primary"><i class="fa-solid fa-download"></i> Download All Documents</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                <?php    
                    }
                    else if(Auth::user()->can('export.ideas.documents') && $sort_final_closure_date[0] < Carbon\Carbon::now())
                    {?>
                        <div class="text-center mt-3">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa-solid fa-download"></i> Download Data
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Download Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>How To Download</h5>
                                        <p>Press <a href="#" role="button" class="btn btn-outline-primary popover-test disabled" title="Popover title" data-bs-content="Download">Download</a> button below to download specific data.</p>
                                    </div>
                                    <div class="modal-footer">
                                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button> --}}
                                    <a href="#" class="btn btn-outline-primary disabled"><i class="fa-solid fa-download"></i> Download As CSV</a>
                                    <a href="{{ route('export.ideas.documents') }}" class="btn btn-outline-primary"><i class="fa-solid fa-download"></i> Download All Documents</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                <?php    
                    }
                    else if(Auth::user()->can('export.csv') && $sort_final_closure_date[0] < Carbon\Carbon::now())
                    { ?>
                        <div class="text-center mt-3">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa-solid fa-download"></i> Download Data
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Download Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>How To Download</h5>
                                        <p>Press <a href="#" role="button" class="btn btn-outline-primary popover-test disabled" title="Popover title" data-bs-content="Download">Download</a> button below to download specific data.</p>
                                    </div>
                                    <div class="modal-footer">
                                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button> --}}
                                    <a href="{{ route('export.csv') }}" class="btn btn-outline-primary"><i class="fa-solid fa-download"></i> Download As CSV</a>
                                    <a href="#" class="btn btn-outline-primary disabled"><i class="fa-solid fa-download"></i> Download All Documents</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                <?php    
                    }
                    else if (Auth::user()->can('export.csv') || Auth::user()->can('export.ideas.documents') && $sort_final_closure_date[0] > Carbon\Carbon::now() )
                    {?>
                        <div class="text-center mt-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fa-solid fa-download"></i> Download Data
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Download Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5 style="color: red;">You cannot download now, wait until final closure date: {{ $sort_final_closure_date[0] }}</h5>
                                    <h5>How To Download</h5>
                                    <p>Press <a href="#" role="button" class="btn btn-outline-primary popover-test disabled" title="Popover title" data-bs-content="Download">Download</a> button below to download specific data.</p>
                                </div>
                                <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button> --}}
                                <a href="#" class="btn btn-outline-primary disabled"><i class="fa-solid fa-download"></i> Download As CSV</a>
                                <a href="#" class="btn btn-outline-primary disabled"><i class="fa-solid fa-download"></i> Download All Documents</a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                <?php    
                    }
                }
            ?>
                    <div class="container">
                        <ul class="nav nav-pills mt-3">
                            <li class="nav-item">
                            <a class="nav-link" id="btn_ideas_all" data-url="{{ route('list.ideas.all') }}" aria-current="page" href="{{ route('list.ideas.all') }}">All</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" id="btn_ideas_most-popular-ideas" data-url="{{ route('list.ideas.most-popular-ideas') }}" href="{{ route('list.ideas.most-popular-ideas') }}">Most Popular Ideas</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link active" id="btn_ideas_most-viewed-ideas" data-url="{{ route('list.ideas.most-viewed-ideas') }}" href="{{ route('list.ideas.most-viewed-ideas') }}">Most viewed Ideas</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" id="btn_ideas_latest-ideas" data-url="{{ route('list.ideas.latest-ideas') }}" href="{{ route('list.ideas.latest-ideas') }}">Latest Ideas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="btn_ideas_latest-comments" data-url="{{ route('list.ideas.latest-comments') }}" href="{{ route('list.ideas.latest-comments') }}">Latest Comments</a>
                            </li>
                        </ul>
                        <div id="ideas_content">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="most-viewed-ideas" role="tabpanel" aria-labelledby="most-viewed-ideas-tab">
                                    <?php
                                        // List all Idea
                                        $ideas_popular = App\Models\Idea::where('isApprove',true)->orderBy('create_date', 'desc')->get();
                                        // Array Store Most Viewer Of Idea
                                        $arr_most_viewer_idea = array();
                                        $data = array();
                                        foreach ($ideas_popular as $key => $idea) 
                                        {
                                            // Count All Viewer in each idea If That Viewer Exist
                                            if($idea->viewers->isNotEmpty())
                                            {
                                                // Count Viewer Of That Idea
                                                $count_viewer = 0;
                                                // Lopp Each Viewer inside that idea
                                                $viewers = $idea->viewers;
                                                foreach($viewers as $index => $viewer)
                                                {
                                                    // Find Viewer inside that idea
                                                    if($viewer->idea_id == $idea->id)
                                                    {
                                                        $count_viewer++;
                                                        // Count Like and Push It Into Array
                                                        // Sort Array and Display It into Idea Page
                                                    }
                                                }
                                                // Store Like Count Of That Idea Into Array
                                                $data['id'] = $idea->id;
                                                $data['title'] = $idea->title;
                                                $data['description'] = $idea->description;
                                                $data['content'] = $idea->content;
                                                $data['user_id'] = $idea->user_id;
                                                $data['category_id'] = $idea->category_id;
                                                $data['submission_id'] = $idea->submission_id;
                                                $data['isApprove'] = $idea->isApprove;
                                                $data['isAnonymous'] = $idea->isAnonymous;
                                                $data['create_date'] = $idea->create_date;
                                                $data['last_modified_date'] = $idea->last_modified_date;
                                                $data['Viewers'] = $count_viewer;
                            
                                                array_push($arr_most_viewer_idea, $data);
                                            }
                                            else {
                                                // Store Like Count Of That Idea Into Array
                                                $data['id'] = $idea->id;
                                                $data['title'] = $idea->title;
                                                $data['description'] = $idea->description;
                                                $data['content'] = $idea->content;
                                                $data['user_id'] = $idea->user_id;
                                                $data['category_id'] = $idea->category_id;
                                                $data['submission_id'] = $idea->submission_id;
                                                $data['isApprove'] = $idea->isApprove;
                                                $data['isAnonymous'] = $idea->isAnonymous;
                                                $data['create_date'] = $idea->create_date;
                                                $data['last_modified_date'] = $idea->last_modified_date;
                                                $data['Viewers'] = 0;
                            
                                                array_push($arr_most_viewer_idea, $data);
                                            }
                                            
                                        }
                                        // Sort Array By Most Viewers
                                        $most_viewer_idea = collect($arr_most_viewer_idea)->sortBy('Viewers')->reverse()->toArray();
                                        $most_viewer_idea_sort = array();
                                        foreach ($most_viewer_idea as $key => $idea) {
                                            array_push($most_viewer_idea_sort, $idea);
                                        }
                                        $collection_most_viewer = collect($most_viewer_idea_sort);
                                        $paginate_most_viewer = App\Http\Controllers\IdeaController::paginate($collection_most_viewer, 5);
                                    ?>
                                    <table class="table-custom">
                                        <thead>
                                            <th>#</th>
                                            <th>Idea</th>
                                            <th>Author</th>
                                            <th>Description</th>
                                            <th># Tag</th>
                                            <th>Viewer</th>
                                            <th>Like</th>
                                            <th>Dislike</th>
                                            <th>Comment</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                        <?php
                                            foreach($paginate_most_viewer as $key => $idea)
                                            { 
                                                $user = App\Models\User::find($idea['user_id']);
                                        ?>
                                                <tr>
                                                    <td data-label="#">{{ $idea['id'] }}</td>
                                                    <td data-label="Idea">{{ $idea['title'] }}</td>
                                                    <td data-label="Author">
                                                        @if ($idea['isAnonymous'] == true)        
                                                        <button type="button" class="btn btn-outline-dark" disabled><h6>Author: Anonymous</h6></button>
                                                        @else
                                                        <button type="button" class="btn btn-outline-danger" disabled><h6>Author: {{ $user->name }}</h6></button>
                                                        @endif
                                                    </td>
                                                    <td data-label="Description">{!! $idea['description'] !!}</td>
                                                    <td data-label="# Tag">
                                                        <span class="badge rounded-pill bg-success" id="tag_span"># {{ App\Models\Idea::find($idea['id'])->category->name }}</span>
                                                    </td>
                                                    <td data-label="Viewer">
                                                        <p><i class="fas fa-eye " style="color: black;"></i> {{ $idea['Viewers'] }}</p>
                                                    </td>
                                                    <td data-label="Like">
                                                        <p><i class="fas fa-thumbs-up fa-1x" style="color: green;"></i> 
                                                            <?php
                                                                $count_like = 0;
                                                                $count_dislike = 0;
                                                                // Count Like Reaction Of That Idea
                                                                $reactions_all = App\Models\Idea::find($idea['id'])->reactions;
                                                                foreach ($reactions_all as $key => $reaction) {
                                                                    if($reaction->type->reaction_type == 'Like')
                                                                    {
                                                                        $count_like++;
                                                                    }
                                                                    else if($reaction->type->reaction_type == 'DisLike')
                                                                    {
                                                                        $count_dislike++;
                                                                    }
                                                                }
                                                                echo $count_like;
                                                            ?>
                                                        </p>
                                                    </td>
                                                    <td data-label="Dislike">
                                                        <p><i class="fas fa-thumbs-down fa-1x" style="color: red;"></i> {{ $count_dislike }}</p>
                                                    </td>
                                                    <td data-label="Comment">
                                                        <p><i class="fa-solid fa-comment"></i> {{ App\Models\Idea::find($idea['id'])->comments->count() }}</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <a href="{{ route('idea.details', $idea['id']) }}"><i class="fas fa-info-circle fa-2x"></i></a>
                                                    </td>
                                                </tr>
                                        <?php    
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                    <div class="pagination justify-content-center mt-3">
                                        {{ $paginate_most_viewer->links() }}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="most-viewed-ideas" role="tabpanel" aria-labelledby="most-viewed-ideas-tab">3</div>
                                <div class="tab-pane fade" id="latest-ideas" role="tabpanel" aria-labelledby="latest-ideas-tab">4</div>
                                <div class="tab-pane fade" id="latest-comments" role="tabpanel" aria-labelledby="latest-comments-tab">5</div>
                            </div>
                        </div>
                    </div> 
            </section>
            
            <footer>
                <div class="bg-dark text-secondary px-4 py-5 text-center mt-5">
                    <div class="py-5">
                      <h4 class="display-5 fw-bold text-white">EVERY INDIVIDUAL IN THE WORLD HAS A UNIQUE CONTRIBUTION</h4>
                      <div class="col-lg-6 mx-auto">
                        <p class="fs-5 mb-4">"There is no doubt that creativity is the most important human resource of all. Without creativity, there would be no progress, and we would be forever repeating the same patterns."</p>

                      </div> 
                    </div>
                  </div>

            </footer>
            <script type="text/javascript">
              window.addEventListener("load", function(){
                const loader = document.querySelector(".loader");
                loader.className += " hidden"; // class "loader hidden"
              });
            </script>

        </body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script type="text/javascript">
            // Button All
            $(document).on('click', '#btn_ideas_all', function(ev){
                // ev.preventDefault();
                var _url = $(this).data('url');
                $('#btn_ideas_most-popular-ideas').removeClass('active');
                $('#btn_ideas_most-viewed-ideas').removeClass('active');
                $('#btn_ideas_latest-ideas').removeClass('active');
                $('#btn_ideas_latest-comments').removeClass('active');
                $(this).addClass('active');
                // console.log(_url);
                // $.ajax({
                //   url: _url,
                //   type: 'GET',
                //   beforeSend: function(){
                //     $('#btn_ideas_most-popular-ideas').addClass('disabled');
                //     $('#btn_ideas_most-viewed-ideas').addClass('disabled');
                //     $('#btn_ideas_latest-ideas').addClass('disabled');
                //     $('#btn_ideas_latest-comments').addClass('disabled');
                //   },
                //   success: function(res){
                //     $('#ideas_content').html(res);
                //     $('#btn_ideas_most-popular-ideas').removeClass('disabled');
                //     $('#btn_ideas_most-viewed-ideas').removeClass('disabled');
                //     $('#btn_ideas_latest-ideas').removeClass('disabled');
                //     $('#btn_ideas_latest-comments').removeClass('disabled');
                //   }
                // });
            });
    
            // Button Most Popular Ideas
            $(document).on('click', '#btn_ideas_most-popular-ideas', function(ev){
                // ev.preventDefault();
                var _url = $(this).data('url');
                $('#btn_ideas_all').removeClass('active');
                $('#btn_ideas_most-viewed-ideas').removeClass('active');
                $('#btn_ideas_latest-ideas').removeClass('active');
                $('#btn_ideas_latest-comments').removeClass('active');
                $(this).addClass('active');
                // console.log(_url);
                // $.ajax({
                //   url: _url,
                //   type: 'GET',
                //   beforeSend: function(){
                //     $('#btn_ideas_all').addClass('disabled');
                //     $('#btn_ideas_most-viewed-ideas').addClass('disabled');
                //     $('#btn_ideas_latest-ideas').addClass('disabled');
                //     $('#btn_ideas_latest-comments').addClass('disabled');
                //   },
                //   success: function(res){
                //     $('#ideas_content').html(res);
                //     $('#btn_ideas_all').removeClass('disabled');
                //     $('#btn_ideas_most-viewed-ideas').removeClass('disabled');
                //     $('#btn_ideas_latest-ideas').removeClass('disabled');
                //     $('#btn_ideas_latest-comments').removeClass('disabled');
                //   }
                // });
            });
    
            // Button Most Viewed Ideas
            $(document).on('click', '#btn_ideas_most-viewed-ideas', function(ev){
                // ev.preventDefault();
                var _url = $(this).data('url');
                $('#btn_ideas_all').removeClass('active');
                $('#btn_ideas_most-popular-ideas').removeClass('active');
                $('#btn_ideas_latest-ideas').removeClass('active');
                $('#btn_ideas_latest-comments').removeClass('active');
                $(this).addClass('active');
                console.log(_url);
            });
    
            // Button Latest Ideas
            $(document).on('click', '#btn_ideas_latest-ideas', function(ev){
                // ev.preventDefault();
                var _url = $(this).data('url');
                $('#btn_ideas_all').removeClass('active');
                $('#btn_ideas_most-popular-ideas').removeClass('active');
                $('#btn_ideas_most-viewed-ideas').removeClass('active');
                $('#btn_ideas_all').removeClass('active');
                $('#btn_ideas_latest-comments').removeClass('active');
                $(this).addClass('active');
                console.log(_url);
            });
    
            // Button Latest Comments
            $(document).on('click', '#btn_ideas_latest-comments', function(ev){
                // ev.preventDefault();
                var _url = $(this).data('url');
                $('#btn_ideas_all').removeClass('active');
                $('#btn_ideas_most-popular-ideas').removeClass('active');
                $('#btn_ideas_most-viewed-ideas').removeClass('active');
                $('#btn_ideas_all').removeClass('active');
                $('#btn_ideas_latest-ideas').removeClass('active');
                $(this).addClass('active');
                console.log(_url);
            });
        </script>
</html>
@endif