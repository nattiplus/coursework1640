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
        <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
            <form role="form" action="{{URL::to('/admin/save-category')}}" method="post">
                {{csrf_field()}}
            <h1 class="heading-custom">Create Category</h1>
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
                    <input type="text" name="cate_name" id="">
                    <label for="">Category Name</label>
                </div>
                <div class="input-data">      
                    <input type="text" name="cate_desc" id="">
                    <label for="">Description</label>
                </div>
                <div class="input-data">      
                    <input type="date" name="create_date" id="">
                    <label for="">Create Date</label>
                </div>
                <button type="submit" name="add_category" id="btn_category_create" class="btn btn-primary mt-3">Create</button>
            </div>


            {{-- <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Category Name</label>
                <input type="text" class="form-control" name="cate_name">
            </div> --}}
            {{-- <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Category Desc</label>
                <input type="text" class="form-control" name="cate_desc">
            </div> --}}
            {{-- <div class="form-check mt-3">
                <input class="form-check-input" type="Date" value="" name="create_date">
                <label class="form-check-label" for="flexCheckIndeterminate">Create Date</label>
            </div>

            <button type="submit" name="add_category" class="btn btn-primary mt-3">Create</button> --}}
        </form>
@endsection

@section('JS')
    <script type="text/javascript">
        $(document).on('click', '#btn_category_create', function(){
            $(this).addClass('disabled');
        })
    </script>
@endsection