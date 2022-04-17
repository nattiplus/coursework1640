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
        <a href="{{URL::to('/admin/role')}}" class="active">
            <span class="las la-key"></span>
            <span>Roles</span>
        </a>
    </li>
    @endif
</ul>
@endsection

@section('AdminContent')
    <h1 class="heading">Role</h1>
    <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
        <a href="{{URL::to('/admin/role/create')}}" class="button-pink"><i class="las la-plus"></i> Create New</a>
    <table class="table">
        <thead class="table-dark">
            <th>#</th>
            <th>Role</th>
            <th>Create Date</th>
            <th>Update Date</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php
                foreach($roles as $role)
                {
            ?>
                <tr>
                    <td data-label="#">{{ $role->id }}</td>
                    <td data-label="Role">{{ $role->name }}</td>
                    <td data-label="Create Date">{{ $role->created_at }}</td>
                    <td data-label="Update Date">{{ $role->updated_at }}</td>
                    <td data-label="Action">
                        <a href="{{ route('role.update', $role->id) }}" class="button-primary"><i class="las la-pen"></i></a>
                        
                        {{-- <a href="{{ route('role.details', $role->id) }}" class="button-warning"><i class="fas fa-eye"></i></a> --}}
                        
                        <a href="{{ route('role.delete', $role->id) }}" onclick="return confirm('Are you sure?')" class="button-danger"><i class="las la-trash"></i></a>
                    </td>
                </tr>
            <?php    
                }
            ?>

        </tbody>
 
    </table>
    <div class="pagination justify-content-center mt-3">
        {{ $roles->links() }}
    </div>

@endsection