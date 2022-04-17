@extends('layouts.app')
@section('content')
<div class="container mt-5">
	<h3>Category</h3>
	<div class="row">
		@foreach($categories as $category)
		<div class="col-md-4">
			<ul class="list-group">
			  <li class="list-group-item list-group-item-dark d-flex justify-content-between align-items-center">
			      <a href="{{URL::to('/ideas/submission/'. $category->id)}}" class="list-group-item list-group-item-action" aria-current="true">
				    <div class="d-flex w-100 justify-content-between">
				      <h5 class="mb-1">{{ $category->name }}</h5>
{{-- 				      <span class="badge bg-success rounded-pill">Open</span> --}}
				    </div>
				    <small>{{ $category->description }}</small>
				  </a>
			  </li>
			</ul>
		</div>
		@endforeach
	</div>
</div>
@endsection