@extends('layouts.app')
@section('content')
<div class="container">
    @include('user.breadcrumbs.index', ['idea', $idea])
</div>
<div class="container mt-5">
	<div class="col-md-12 mb-4 border-bottom border-warning border-3"><h4>Submission Details</h4></div>
	<div class="col-md-12">
		<?php
			$message = Session::get('message');
			if($message){
				echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
				Session::put('message',null);
			}
		?>
	</div>
	<small id="error_message" style="color: red;">
		@if ($errors->any())
		<ul class="col-md-12">
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
		@endif
	</small>
	<div class="col-md-12"><h6>Notes:</h6></div>
	<div class="col-md-12 mb-4"><h6>You must submitted .pdf, docx, xlsx format</h6></div>
	<table class="table table-borderless table-striped table-hover">
		<tbody>
			<tr>
				<th class="col-md-2">Status</th>
				@if ($idea->isApprove == true)
					<td class="col-md-10 table-success">Approved</td>
				@else
					<td class="col-md-10 table-danger">Waiting to be approved</td>
				@endif
			</tr>
			<tr>
				<th class="col-md-2">Closure Date</th>
				<?php
					if($idea->submission_id)
					{ 
						$submission = App\Models\Submission::find($idea->submission_id);
					?>
						<td class="col-md-10">{{ $submission->closure_date }}</td>
				<?php	
					}else{ ?>
						<td class="col-md-10">None</td>
				<?php	
					}
				?>
			</tr>
			<tr>
				<th class="col-md-2">Final Date</th>
				<?php
					if($idea->submission_id)
					{ ?>
						<td class="col-md-10">{{ $submission->final_closure_date }}</td>
				<?php	
					}else{ ?>
						<td class="col-md-10">None</td>
				<?php	
					}
				?>		
			</tr>
			<tr>
				<th class="col-md-2">Topic</th>
				<?php
					if($idea->category_id)
					{
						$category = App\Models\Category::find($idea->category_id);
					?>
						<td class="col-md-10" style="background-color: #cfefcf">{{ $category->name }}</td>
				<?php	
					}else{ ?>
						<td class="col-md-10">None</td>
				<?php	
					}
				?>		
			</tr>
			<tr>
				<th class="col-md-2">Idea</th>
				<?php
					if($idea->title)
					{ ?>
						<td class="col-md-10" style="background-color: #cfefcf">{{ $idea->title }}</td>
				<?php	
					}else{ ?>
						<td class="col-md-10">None</td>
				<?php	
					}
				?>		
			</tr>
			<tr>
				<th class="col-md-2">File Submissions</th>
				<td class="col-md-10">
					<?php
						$files = App\Models\Idea::find($idea->id)->fileuploads;
					?>
					@foreach($files as $file)
					<i class="fa-solid fa-file mb-2"></i> <a href="{{URL::to('/ideas/singledownload?file='.$file->file_path)}}" style="color: black; background-color: #f2f2f2;">{{ $file->file_path }}</a> <br>
					@endforeach
				</td>
			</tr>
			<tr>
				<th class="col-md-2">Submission Date</th>
				<td class="col-md-10">{{ $idea->last_modified_date }}</td>		
			</tr>
		</tbody>
	</table>
	<div class="col-md-12 text-center">
		<?php

		if($submission->closure_date <= $DateNow){ ?>
			<button disabled class="btn btn-secondary">Edit Submission</button>
			<a href="#" class="btn btn-secondary disabled">Remove</a>
		<?php
			}else{ ?>
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#myModal">
				Edit Submission
			</button>
			
			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title" id="myModalLabel">Edit Idea</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
					<div class="container-fluid">
					<form method="post" action="{{ route('update.idea.submission', $idea->submission_id) }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<input type="hidden" name="idea_id" value="{{ $idea->id }}">
						<input type="hidden" name="category_id" value="{{ $idea->category_id }}">
						<input type="hidden" name="submission_id" value="{{ $idea->submission_id }}">
						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Your Name</label>
							<?php
								if(Auth::user()->name)
								{ 
								?>
							<input type="text" class="form-control" id="exampleFormControlInput1" value="{{ Auth::user()->name }}" readonly>
							<?php    
								}else
								{ 
							?>
							<input type="text" class="form-control" id="exampleFormControlInput1" value="Null" readonly>
							<?php    
								}
							?>
						</div>
						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Category</label>
							@if ($idea->category)
							<span class="badge rounded-pill bg-success" id="tag_span"># {{ $idea->category->name }}</span>
							<select class="form-select" aria-label="Default select" name="category_select">
								<option disabled>>> Select Tag <<</option>
								<?php
									$categories = App\Models\Category::all();
									foreach ($categories as $index => $category) 
									{
										if($category->name == $idea->category->name)
										{?>
										<option value="{{ $category->id }}" id="opt_tag" data-tag="{{ $category->name }}" selected>{{ $category->name }}</option>
									<?php	
										}
										else { ?>
										<option value="{{ $category->id }}" id="opt_tag" data-tag="{{ $category->name }}">{{ $category->name }}</option>
									<?php	
										}
									?>
								<?php    
									}
								?>
							  </select>
							@else
							<span class="badge rounded-pill bg-success" id="tag_span"></span>
							<select class="form-select" aria-label="Default select" name="category_select">
								<option selected disabled>>> Select Tag <<</option>
								<?php
									$categories = App\Models\Category::all();
									foreach ($categories as $index => $category) 
									{?>
										<option value="{{ $category->id }}" id="opt_tag" data-tag="{{ $category->name }}">{{ $category->name }}</option>
								<?php    
									}
								?>
							  </select>
							@endif
							{{-- <input type="text" class="form-control" id="exampleFormControlInput1" value="" > --}}
						</div>
						  <div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Title</label>
							<input type="text" class="form-control" name="title" id="exampleFormControlInput1" value="{{ $idea->title }}" >
						</div>
						<div class="mb-3">
							<label for="exampleFormControlTextarea1" class="form-label">Description</label>
							<textarea class="form-control" name="description" id="ckeditor2" rows="1">{!! $idea->description !!}</textarea>
						</div>
						<div class="mb-3">
							<label for="exampleFormControlTextarea1" class="form-label">Your Ideas</label>
							<textarea class="form-control" name="content" id="ckeditor1" rows="3">{!! $idea->content !!}</textarea>
						</div>
						<div class="mb-3">
							<label for="formFile" class="form-label">Document</label>
							<div class="row">
								<div class="col-md-12">
									<?php
										$files = App\Models\Idea::find($idea->id)->fileuploads;
									?>
									@foreach($files as $file)
									<i class="fa-solid fa-file mb-2"></i> <a href="{{URL::to('/ideas/singledownload?file='.$file->file_path)}}" style="color: black; background-color: #f2f2f2;">{{ $file->file_path }}</a>
									<a href="{{ URL::to('/ideas/submission/'.$idea->submission_id.'/contribute/file?file_id='.$file->id) }}" onclick="return confirm('Are you sure want to delete {{ $file->file_path }} file?')" style="color: gray;"><i class="fa-solid fa-circle-xmark"></i></a> <br>
									@endforeach
								</div>
							</div>
							<input class="form-control" type="file" name="document[]" id="formFile" multiple>
						</div>
						{{-- <div class="form-check mt-3">
							<input class="form-check-input" type="checkbox" value="1" id="flexCheckIndeterminate">
							<label class="form-check-label" for="flexCheckIndeterminate">Incognito</label>
						</div> --}}
						<div class="row">
							<div class="col-md-2">
								@if ($idea->isAnonymous == true)
								<div class="form-check mt-3">
									<input type="checkbox" name="is_anonymous" id="is_anonymous_idea" class="form-check-input" value="1" checked/>
									<label class="form-check-label" for="flexCheckIndeterminate">Anonymous Idea</label>
								</div>
								@else
								<div class="form-check mt-3">
									<input type="checkbox" name="is_anonymous" id="is_anonymous_idea" class="form-check-input" value="0"/>
									<label class="form-check-label" for="flexCheckIndeterminate">Anonymous Idea</label>
								</div>	
								@endif
							</div>
						</div>
						
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary" id="submit_idea">Save changes</button>
							</div>
						</form>
					</div>
					</div>
				</div>
				</div>
			</div>
			<a href="{{ URL::to('/ideas/submission/'.$idea->submission_id.'/contribute/delete/'.$idea->id) }}" onclick="return confirm('Are you sure want to remove this idea?')" class="btn btn-secondary">Remove</a>
			<?php
			}
	 ?>
</div>
@endsection

@section('JS')
	<script type="text/javascript">
		// Select Tag
		$(document).ready(function(){
            $(document).on('click','#opt_tag',function(){
                var tag_name = $(this).data('name');
                $('tag_span').text('#'+ tag_name);
                console.log(tag_name);
            });
        });
        $('select').on('change', function(){
            var optionSelected = $(this).find("option:selected");
            var valueSelected = optionSelected.data('tag');
            $('#tag_span').text('# ' + valueSelected);
        });
	</script>

    <script type="text/javascript">
        $(document).on('click', '#submit_idea', function(){
            $(this).addClass('disabled');
        })
    </script>
@endsection