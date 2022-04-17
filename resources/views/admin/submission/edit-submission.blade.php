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
    <div class="col-md-12">
        <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
            <form role="form" action="{{URL::to('/admin/update-submission/'.$submission->id)}}" method="post">
                {{csrf_field()}}

            <h1 class="heading-custom">Update Submisson</h1>
            <div class="wrapper">
                <div class="input-data">      
                    <input type="text" name="tag_name" id="" value="{{$submission->name}}">
                    <label for="">Submission Name</label>
                </div>
                <div class="input-data">      
                    <input type="text" name="tag_desc" id="" value="{{$submission->description}}">
                    <label for="">Description</label>
                </div>
                <div class="input-data">      
                    <?php
                        $closure_date = Carbon\Carbon::parse($submission->closure_date)->format('Y-m-d\TH:i');
                        $final_closure_date = Carbon\Carbon::parse($submission->final_closure_date)->format('Y-m-d\TH:i');
                    ?>
                    <input type="datetime-local" name="closure_date" id="" value="{{ $closure_date }}">
                    <label for="">Closure Date</label>
                </div>
                <div class="input-data">      
                    <input type="datetime-local" name="final_date" id="" value="{{ $final_closure_date }}">
                    <label for="">Final Closure Date</label>
                </div>
                <button type="submit" name="add_tag" id="btn_submission_update" class="btn btn-primary mt-3">Save</button>
            </div>
        </form>
    </div>
@endsection

@section('JS')
    <script type="text/javascript">
        $(document).on('click', '#btn_submission_update', function(){
            $(this).addClass('disabled');
        })
    </script>
@endsection
