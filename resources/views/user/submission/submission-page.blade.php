@extends('layouts.app')
@section('content')
<div class="container">
    @include('user.breadcrumbs.index')
</div>
<div class="container mt-5">
	<div class="card" style="padding: 10px;">
	<div class="row">
		<h5>Submission</h5>
		<?php
		 	$submissions = App\Models\Submission::all();
			$count = 0;
		 	foreach($submissions as $submission)
		 	{
				$ideas = App\Models\Submission::find($submission->id)->ideas;
				foreach($ideas as $key => $idea)
				{
					if($idea->user_id == Auth::user()->id)
					{
						$count++;
					}
				}
		 		$ideacount = $count;
				// Reset count
				$count = 0;
		?>
		<div class="col-md-12">
			<div class="mt-2" style="border-left-style: solid; border-color: blue; padding-left: 10px;">
				<i class="fa-solid fa-file"></i>
				<a href="{{ route('submission.List', $submission->id) }}">
					<u><i>{{$submission->name}}</i></u>
					@if($submission->closure_date <= $DateNow)
					<span class="badge bg-danger rounded-pill">Close</span>
					@else
					<span class="badge bg-success rounded-pill">Open</span>
					@endif
				</a>
				<p><b>Closure Date: </b>({{$submission->closure_date}})</p>
				<p><b>Final Date: </b>({{$submission->final_closure_date}})</p>
				@if($ideacount > 0)
				<a href="{{ route('submission.List', $submission->id) }}" class="btn btn-success"><i class="fa-solid fa-check"></i> Submitted <span class="badge bg-dark rounded-pill">{{$ideacount}} Ideas</span></a>
				@else
				<a href="{{ route('submission.List', $submission->id) }}" class="btn btn-danger"><i class="fa-solid fa-x"></i> Not Submit <span class="badge bg-dark rounded-pill">{{$ideacount}} Idea</span></a>
				@endif
			</div>
		</div>
		<?php
			}
		?>
	</div>
	</div>
</div>
@endsection