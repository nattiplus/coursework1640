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
        <a href="{{URL::to('/admin/view-user')}}" class="active">
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
        <h1 class="heading-custom">Create Accounts</h1>
        <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
            <form role="form" action="{{ route('save.user') }}" method="POST">
                @csrf

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
                        <input id="name" type="text" id="account-name" class="form-control" name="name" value="{{ old('name') }}">
                        <label for="">{{ __('Name') }}</label>
                    </div>

                    <div class="input-data">      
                        <input id="email" type="email" id="account-email" class="form-control" name="email" value="{{ old('email') }}" >
                        <label for="">{{ __('Email Address') }}</label>
                    </div>

                    <div class="input-data">      
                        <input id="password" type="password" id="account-password" class="form-control" name="password" >
                        <label for="">{{ __('Password') }}</label>
                    </div>

                    <div class="input-data">      
                        <input id="password-confirm" type="password" id="account-confirm-password" class="form-control" name="password_confirmation">
                        <label for="">{{ __('Confirm Password') }}</label>
                    </div>

                    <div class="input-data">      
                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                        <label for="">{{ __('Phone') }}</label>
                    </div>

                    <div class="input-data">      
                        <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                        <label for="">{{ __('Address') }}</label>
                    </div>

                    <div class="input-data">      
                        <input type="text" class="form-control" name="country" value="{{ old('country') }}">
                        <label for="">{{ __('Country') }}</label>
                    </div>

                    <div class="input-data">      
                        <select class="form-control input-sm m-bot15" name="user_type" value="{{ old('user_type') }}">
                            <option value="Internal" selected>Internal</option>
                            <option value="External">External</option>
                        </select>
                        <label for="">{{ __('Type') }}</label>
                    </div>

                    <div class="input-data">      
                        <select class="form-control input-sm m-bot15" name="user_dept" value="{{ old('user_dept') }}">
                            @foreach($user_dept as $key => $dept)
                            <option value="{{$dept->id}}">{{$dept->name}}</option>
                            @endforeach
                        </select>
                        <label for="">{{ __('Department') }}</label>
                    </div>

                    <label for="">{{ __('Role:') }}</label>
                        @foreach($roles as $role)
                        <div>
                            <label for="">
                                <input type="checkbox" name="role_select[]" value="{{ $role->id }}" multiple>
                                {{ $role->name }}
                            </label>
                        </div>
                        @endforeach
                        <br>
                    <button type="submit" id="btn_account_create" class="btn btn-primary mt-3">Create</button>
                </div>

                

                {{-- <div class="card-body"> --}}
            {{-- <div class="mb3">
                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> --}}
            {{-- <div class="mb3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> --}}
            {{-- <div class="mb3">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> --}}
            {{-- <div class="mb3">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div> --}}
            {{-- <div class="mb-3">
                <label for="exampleFormControlInput1" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>
                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
            </div> --}}
            {{-- <div class="mb-3">
                <label for="exampleFormControlInput1" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
                <input type="text" class="form-control" name="address" value="{{ old('address') }}">
            </div> --}}
            {{-- <div class="mb-3">
                <label for="exampleFormControlInput1" class="col-md-4 col-form-label text-md-end">{{ __('Country') }}</label>
                <input type="text" class="form-control" name="country" value="{{ old('country') }}">
            </div> --}}
            {{-- <div class="mb-3 mt-3">
                <label for="exampleFormControlInput1" class="col-md-4 col-form-label text-md-end">{{ __('Type') }}</label>
                <select class="form-control input-sm m-bot15" name="user_type" value="{{ old('user_type') }}">
                    <option value="Internal" selected>Internal</option>
                    <option value="External">External</option>
                </select>
            </div> --}}
             {{-- <div class="mb-3 mt-3">
                <label for="exampleFormControlInput1" class="col-md-4 col-form-label text-md-end">{{ __('Department') }}</label>
                <select class="form-control input-sm m-bot15" name="user_dept" value="{{ old('user_dept') }}">
                    @foreach($user_dept as $key => $dept)
                    <option value="{{$dept->id}}">{{$dept->name}}</option>
                    @endforeach
                </select>
            </div> --}}
            {{-- <div class="mb-3">
                <label for="Role" class="col-md-12 col-form-label text-md-end">{{ __('Role:') }}</label>
                @foreach($roles as $role)
                <label for="" class="col-md-12">
                    <input type="checkbox" name="role_select[]" value="{{ $role->id }}" multiple>
                    {{ $role->name }}
                </label>
                @endforeach
            </div>
            <button type="submit" name="add_user" class="btn btn-primary mt-3">Create</button> --}}
        </form>
@endsection

@section('JS')
    <script type="text/javascript">
        $(document).on('click', '#btn_account_create', function(){
            $(this).addClass('disabled');
        })
    </script>
@endsection