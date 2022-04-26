@extends('layouts.app')
@section('content')
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
        if($sort_final_closure_date != null)
        {
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
    }
?>
    <div class="container">
        <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
        <ul class="nav nav-pills mt-3">
            <li class="nav-item">
              <a class="nav-link active" id="btn_ideas_all" data-url="{{ route('list.ideas.all') }}" aria-current="page" href="{{ route('list.ideas.all') }}">All</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="btn_ideas_most-popular-ideas" data-url="{{ route('list.ideas.most-popular-ideas') }}" href="{{ route('list.ideas.most-popular-ideas') }}">Most Popular Ideas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="btn_ideas_most-viewed-ideas" data-url="{{ route('list.ideas.most-viewed-ideas') }}" href="{{ route('list.ideas.most-viewed-ideas') }}">Most viewed Ideas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="btn_ideas_latest-ideas" data-url="{{ route('list.ideas.latest-ideas') }}" href="{{ route('list.ideas.latest-ideas') }}">Latest Ideas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="btn_ideas_latest-comments" data-url="{{ route('list.ideas.latest-comments') }}" href="{{ route('list.ideas.latest-comments') }}">Latest Comments</a>
            </li>
        </ul>
        <div id="ideas_content">
            @include('user.idea.list-all-idea')
        </div>
    </div>

@endsection
{{-- <div class="container mt-5">
    <div class="card p-3 shadow mt-5">
        <div class="card-title text-end">
            </div>
            <div class="row" >
                <div class="col-md-10 right">
                    <img src="https://i.pinimg.com/originals/0c/3b/3a/0c3b3adb1a7530892e55ef36d3be6cb8.png" alt="" width="120" height="120">
                    <div class="text">
                        <h2>{{ $idea->title }}</h2>
                        @if ($idea->isAnonymous == true)        
                        <button type="button" class="btn btn-outline-dark" disabled><h5>Author: Anonymous</h5></button>
                        @else
                        <button type="button" class="btn btn-outline-info" disabled><h5>Author: {{ $user->name }}</h5></button>
                        @endif
                        {!! $idea->description !!}
                    </div>
                </div>
                <div class="col-md-2 left">
                    <div>
                        <a href="{{ route('idea.details', $idea->id) }}"><i class="fas fa-info-circle fa-2x"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@section('JS')
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
@endsection