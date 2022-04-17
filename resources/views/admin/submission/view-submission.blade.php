@extends('layouts.adminlayout')

@section('sidebar-menu')
<ul>
    @if (Auth::user()->can('admin.dashboard'))
    <li>
        <!-- <a href="" class="active"> -->
        <a href="{{URL::to('/admin/dashboard')}}">
            <span class="las la-igloo"></span>
            <span>Dashboard</span>
        </a>
    </li>
    @endif

    @if (Auth::user()->can('exception.report'))
    <li>
        <a href="{{ route('ideas.without.comments') }}">
            <span class="las la-flag"></span>
            <span>Exception Report</span>
        </a>
    </li>
    @endif

    @if (Auth::user()->can('view.category'))
    <li>
        <a href="{{URL::to('/admin/view-category')}}">
            <span class="las la-list"></span>
            <span>Category</span>
        </a>
    </li>
    @endif

    @if (Auth::user()->can('view.submission'))
    <li>
        <a href="{{URL::to('/admin/view-submission')}}" class="active">
            <span class="lab la-envira"></span>
            <span>Submission</span>
        </a>
    </li>
    @endif

    @if (Auth::user()->can('idea.cencor'))
    <li>
        <a href="{{URL::to('/admin/censor-ideas')}}" class="sub-btn">
            <span class="las la-lightbulb"></span>
            <span>Idea</span>
        </a>
    </li>
    @endif

    @if (Auth::user()->can('view.department'))
    <li>
        <a href="{{URL::to('/admin/view-department')}}">
            <span class="las la-users"></span>
            <span>Department</span>
        </a>
    </li>
    @endif

    @if (Auth::user()->can('view.user'))
    <li>
        <a href="{{URL::to('/admin/view-user')}}" class="sub-btn">
            <span class="las la-user-circle"></span>
            <span>Accounts</span>
        </a>
    </li>
    @endif

    @if (Auth::user()->can('view.role'))
    <li>
        <a href="{{URL::to('/admin/role')}}" class="sub-btn">
            <span class="las la-key"></span>
            <span>Roles</span>
        </a>
    </li>
    @endif
</ul>
@endsection

@section('AdminContent')
    <h1 class="heading">Submisson</h1>
    <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
        <a href="{{URL::to('/admin/create-submission')}}" class="button-pink"><i class="las la-plus"></i> Create New</a>
        <table class="table">
        <thead class="table-dark">
            <th>#</th>
            <th>Submission Name</th>
            <th>Description</th>
            <th>Closure Date</th>
            <th>Final Closure Date</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($all_submission as $key => $submission)
            <tr>
                <td data-label="#">{{$submission->id}}</td>
                <td data-label="Submission Name">{{$submission->name}}</td>
                <td data-label="Description">{{$submission->description}}</td>
                <td data-label="Closure Date">{{$submission->closure_date}}</td>
                <td data-label="Final Closure Date">{{$submission->final_closure_date}}</td>
                <td data-label="Action">
                    <a href="{{URL::to('/admin/edit-submission/'.$submission->id)}}" class="button-primary"><i class="las la-pen"></i></a>
                    
                    {{-- <a href="#" class="btn btn-warning"><i class="fas fa-eye"></i></a> --}}
                    
                    <a href="{{URL::to('/admin/delete-submission/'.$submission->id)}}" onclick="return confirm('Are you sure?')" class="button-danger"><i class="las la-trash"></i></a>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
 
    </table>
    <div class="pagination justify-content-center mt-3">
        {{ $all_submission->links() }}
    </div>

@endsection