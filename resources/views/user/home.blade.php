@extends('layouts.app')
@section('content')
<div>
  <img src="{{ URL::asset('uploads/ideas.jpg'); }}" class="img-fluid" alt="...">
</div>
<?php
    $ideas = App\Models\Idea::paginate(5);
    foreach($ideas as $idea)
    { 
        $user = App\Models\User::find($idea->user_id);
?>
<div class="container mt-5">
    <div class="card p-3 shadow mt-5">
        <div class="card-title text-end">
                {{-- <p><i class="fas fa-eye " style="color: black;"></i> 0</p> --}}
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
                    {{-- <div>
                        <h5>0</h5>
                        <p><i class="fas fa-thumbs-up fa-2x" style="color: green;"></i></p>
                    </div>
                    <div>
                        <h5>0</h5>
                        <p><i class="fas fa-thumbs-down fa-2x" style="color: red;"></i></p>
                    </div> --}}
                    <div>
                        <a href="{{URL::to('/ideas/details/'.$idea->id)}}"><i class="fas fa-info-circle fa-2x"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
     
    <?php    
        }
    ?>
    <div class="pagination justify-content-center mt-3">
        {{ $ideas->links() }}
    </div>       
</div>
@endsection