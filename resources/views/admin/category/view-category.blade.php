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
        <a href="{{URL::to('/admin/view-category')}}" class="active">
            <span class="las la-list"></span>
            <span>Category</span>
        </a>
    </li>
    @endif

    @if (Auth::user()->can('view.submission'))
    <li>
        <a href="{{URL::to('/admin/view-submission')}}">
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
        <h1 class="heading">Category</h1>
        <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
        <a href="{{URL::to('/admin/create-category')}}" class="button-pink"><i class="las la-plus"></i> Create New</a>
        <table class="table">
            <thead class="table-dark">
                <th>#</th>
                <th>Category Name</th>
                <th>Create Date</th>
                <th>Update Date</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach($all_category as $key => $cate)
                <tr>
                    <td data-label="#">{{$cate->id}}</td>
                    <td data-label="Category Name">{{$cate->name}}</td>
                    <td data-label="Create Date">{{$cate->created_at}}</td>
                    <td data-label="Update Date">{{$cate->updated_at}}</td>
                    <td data-label="Action">
                        <a href="{{URL::to('/admin/edit-category/'.$cate->id)}}" class="button-primary"><i class="las la-pen"></i></a>
                        
                        {{-- <a href="#" class="btn btn-warning"><i class="fas fa-eye"></i></a> --}}
                        
                        @if ($cate->ideas->isEmpty())
                        <a href="{{URL::to('/admin/delete-category/'.$cate->id)}}" onclick="return confirm('Are you sure?')" class="button-danger"><i class="las la-trash"></i></a>
                        @else
                        <a href="{{URL::to('/admin/delete-category/'.$cate->id)}}" onclick="return confirm('Are you sure?')" class="button-danger disabled"><i class="las la-trash"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination justify-content-center mt-3">
            {{ $all_category->links() }}
        </div>
@endsection