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
    <div class="col-md-12">
        <h1 class="heading-custom">Create Role</h1>
        <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
            <form role="form" action="{{ route('role.create.post') }}" method="post">
                {{csrf_field()}}
                
                <small id="error_message" style="color: red;">
                    @if ($errors->any())
                    <ul class="col-md-12">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif
                </small>

                <div class="wrapper">
                    <div class="input-data">      
                        <input type="text" name="role_name" placeholder="Input Field...">
                        <label for="">Role</label>
                    </div>
    
                        <label for="">Routes</label>
                        <div class="form-group" style="height: 350px; overflow-y: auto;">
                            <?php $routeCollection = Illuminate\Support\Facades\Route::getRoutes();?>
                            @foreach ($routeCollection as $route)
                                @if ($route->getName() != '')
                                <div class="checkbox">
                                    <label for="">
                                        <input type="checkbox" name="route[]" value="{{ $route->getName() }}">
                                        {{ $route->getName() }}
                                    </label>
                                </div>
                                @endif   
                            @endforeach
                        </div>

                        <label><input type="checkbox" id="check-all-route">Check All</label>
                        <br>
                    <button type="submit" id="btn_role_create" class="btn btn-primary mt-3">Create</button>
                </div>
        </form>
    </div>
@endsection

@section('JS')
    <script type="text/javascript">
        $('#check-all-route').click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>

    <script type="text/javascript">
        $(document).on('click', '#btn_role_create', function(){
            $(this).addClass('disabled');
        })
    </script>
@endsection