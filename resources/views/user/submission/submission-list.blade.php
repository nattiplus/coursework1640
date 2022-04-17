@extends('layouts.app')
@section('content')
<div class="container">
    @include('user.breadcrumbs.index', ['submission', $submission])
</div>
<div class="container mt-5">
	<div class="col-md-12 mb-4 border-bottom border-warning border-3"><h4>Submission Idea</h4></div>

	<?php

		if($submission->closure_date <= $DateNow){ ?>
			<div class="col-md-12 mb-4 text-center"><a style="pointer-events: none;background-color: gray;" href="{{ route('Idea.Contribute', $id) }}" class="btn btn-primary">Add Submission</a></div>
		<?php
			}else{ ?>
			<div class="col-md-12 mb-4 text-center"><a href="{{ route('Idea.Contribute', $id) }}" class="btn btn-primary">Contribute New Idea</a></div>
			<?php
			}
	?>
    <?php
	$message = Session::get('message');
	if($message){
		echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
		Session::put('message',null);
	}
	?>
	<table class="table-custom">
		<thead>
			<th>Topic</th>
			<th>Submission</th>
			<th>Idea</th>
			<th>Submit Date</th>
			<th>Last Modify Date</th>
			<th>Action</th>
		</thead>
		<tbody>
			@foreach($ideas as $idea)
			<tr>
				<?php
					$category = App\Models\Category::find($idea->category_id);
				?>
				<td data-label="Topic">{{ $category->name }}</td>
				<td data-label="Submission">{{ $submission->name }}</td>
				<td data-label="Idea">{{ $idea->title }}</td>
				<td data-label="Submit Date">{{ $idea->create_date }}</td>
				<td data-label="Last Modify Date">{{ $idea->last_modified_date }}</td>
				<td data-label="Action">
					<?php
						if($submission->final_closure_date <= $DateNow){ ?>
							<a style="pointer-events: none;background-color: gray;" href="{{ URL::to('/ideas/submission/'.$id.'/contribute/edit?ideaid='.$idea->id) }}" class="btn btn-secondary"><i class="fa-solid fa-pen"></i></a>
						<?php
							}else{ ?>
							<a style="background-color: blue;" href="{{ URL::to('/ideas/submission/'.$id.'/contribute/edit?ideaid='.$idea->id) }}" class="btn btn-secondary"><i class="fa-solid fa-pen"></i></a>
							<?php
							}
					?>
				</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			
		</tfoot>
	</table>
</div>
@endsection