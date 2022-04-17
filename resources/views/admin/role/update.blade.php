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
    <h1 class="heading-custom">Update Role</h1>
        <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
            <form role="form" action="{{ route('role.update.post', $role->id) }}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{ $role->id }}">
                
                <div class="wrapper">
                    <div class="input-data">      
                        <input type="text" name="role_name" placeholder="Input Field..." value="{{ $role->name }}">
                        <label for="">Role</label>
                    </div>
    
                        <label for="">Routes</label>
                        <div class="form-group" style="height: 350px; overflow-y: auto;">
                            <?php 
                            $routeCollection = Illuminate\Support\Facades\Route::getRoutes();
                            $count = 0;
                            
                        ?>
                        @foreach ($routeCollection as $route)
                            <div class="checkbox">
                                @if ($route->getName() != '')
                                    @if ($myroutes)
                                        @if ($count < count($myroutes))
                                            @if($myroutes[$count] == $route->getName())
                                                <label for="Route_List">
                                                    <input type="checkbox" name="route[]" value="{{ $route->getName() }}" checked>
                                                    {{ $route->getName() }}
                                                </label>
                                            <?php $count++; ?>
                                            @elseif($myroutes[$count] != $route->getName())
                                                <label for="Route_List">
                                                    <input type="checkbox" name="route[]" value="{{ $route->getName() }}">
                                                    {{ $route->getName() }}
                                                </label>
                                            @endif
                                        @else
                                        <label for="Route_List">
                                            <input type="checkbox" name="route[]" value="{{ $route->getName() }}">
                                            {{ $route->getName() }}
                                        </label>                                
                                        @endif
                                    @endif
                                    @if($myroutes == null)
                                        <label for="Route_List">
                                            <input type="checkbox" name="route[]" value="{{ $route->getName() }}">
                                            {{ $route->getName() }}
                                        </label>
                                    @endif
                                @endif
                            </div> 
                        @endforeach
                        </div>

                        <label><input type="checkbox" id="check-all-route">Check All</label>
                        <br>
                    <button type="submit" id="btn_role_update" class="btn btn-primary mt-3">Save</button>
                </div>
        </form>
@endsection

@section('JS')
    <script type="text/javascript">
        $('#check-all-route').click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>

    <script type="text/javascript">
        $(document).on('click', '#btn_role_update', function(){
            $(this).addClass('disabled');
        })
    </script>
@endsection