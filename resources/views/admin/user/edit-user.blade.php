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
        <h1 class="heading-custom">Update Account</h1>
        <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
            <form role="form" action="{{URL::to('/admin/update-user/'.$user->id)}}" method="post">
                {{csrf_field()}}
                <div class="wrapper">
                    <div class="input-data">      
                        <input id="name" type="text" class="form-control" name="fullname" value="{{$user->name}}">
                        <label for="">FullName</label>
                    </div>

                    <div class="input-data">      
                        <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}">
                        <label for="">Email</label>
                    </div>

                    <div class="input-data">      
                        <input id="password" name="password" value="{{$user->password}}">
                        <label for="">{{ __('Password') }}</label>
                    </div>

                    <div class="input-data">      
                        <input type="text" class="form-control" name="phone" value="{{$user->phonenumber}}">
                        <label for="">{{ __('Phone') }}</label>
                    </div>

                    <div class="input-data">      
                        <input type="text" class="form-control" name="address" value="{{$user->address}}">
                        <label for="">{{ __('Address') }}</label>
                    </div>

                    <div class="input-data">      
                        <input type="text" class="form-control" name="country" value="{{$user->country}}">
                        <label for="">{{ __('Country') }}</label>
                    </div>

                    <div class="input-data">      
                        <select class="form-control input-sm m-bot15" name="user_type">
                            @if($user->type == "Internal")
                            <option selected value="{{ $user->type }}">{{ $user->type }}</option>
                            <option value="External">External</option>
                            @else
                            <option selected value="{{ $user->type }}">{{ $user->type }}</option>
                            <option value="Internal">Internal</option>
                            @endif
                        </select>
                        <label for="">{{ __('Type') }}</label>
                    </div>

                    <div class="input-data">      
                        <select class="form-control input-sm m-bot15" name="user_dept">
                            @foreach($user_dept as $key => $dept)
                                @if($dept->id==$user->department_id)
                                <option selected value="{{$dept->id}}">{{$dept->name}}</option>
                                @else
                                <option value="{{$dept->id}}">{{$dept->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="">{{ __('Department') }}</label>
                    </div>

                    <label for="">{{ __('Role:') }}</label>
                    <?php
                    $count = 0;          
                  ?>
                  @if($all_role->isNotEmpty())
                      @foreach ($all_role as $key => $my_role)
                          <?php
                              if($roles->isNotEmpty())
                              {
                                  if($count < count($roles))
                                  {
                                      if($roles[$count]->id == $my_role->id)
                                      {?>
                                          <div>
                                              <label for="" class="col-md-12">
                                                  <input type="checkbox" name="role_select[]" value="{{ $my_role->id }}" multiple checked>
                                                  {{ $my_role->name }}
                                              </label>
                                          </div>
                              <?php
                                  $count++;    
                                      }
                                      else { ?>
                                          <div>
                                              <label for="" class="col-md-12">
                                                  <input type="checkbox" name="role_select[]" value="{{ $my_role->id }}" multiple>
                                                  {{ $my_role->name }}
                                              </label>
                                          </div>
  
                              <?php    
                                      }
                                  }
                                  else{ ?>
                                      <div>
                                          <label for="" class="col-md-12">
                                              <input type="checkbox" name="role_select[]" value="{{ $my_role->id }}" multiple>
                                              {{ $my_role->name }}
                                          </label>
                                      </div>
  
                              <?php    
                                  }
                              }
                              else {?>
                                  <div>
                                      <label for="" class="col-md-12">
                                          <input type="checkbox" name="role_select[]" value="{{ $my_role->id }}" multiple>
                                          {{ $my_role->name }}
                                      </label>
                                  </div>
                          <?php    
                              }
                          ?>
                      @endforeach        
                  @else
                  <p style="color: red;">Role Not Create Yet</p>
                  @endif
                        <br>
                    <button type="submit" id="btn_account_edit" class="btn btn-primary mt-3">Save</button>
                </div>



                {{-- <div class="card-body">
           <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">FullName</label>
                <input type="text" class="form-control" name="fullname" value="{{$user->name}}">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" value="{{$user->email}}">
            </div> --}}
            {{-- <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" value="{{$user->phonenumber}}">
            </div> --}}
            {{-- <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Address</label>
                <input type="text" class="form-control" name="address" value="{{$user->address}}">
            </div> --}}
            {{-- <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Country</label>
                <input type="text" class="form-control" name="country" value="{{$user->country}}">
            </div> --}}
            {{-- <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Password</label>
                <input type="text" class="form-control" name="password" value="{{$user->password}}">
            </div> --}}
            {{-- <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Type</label>
                <select class="form-control input-sm m-bot15" name="user_type">
                    @if($user->type == "Internal")
                    <option selected value="{{ $user->type }}">{{ $user->type }}</option>
                    <option value="External">External</option>
                    @else
                    <option selected value="{{ $user->type }}">{{ $user->type }}</option>
                    <option value="Internal">Internal</option>
                    @endif
                </select>
            </div> --}}
            {{-- <div class="form-group">
                <label for="exampleInputFile">Department</label>
                <select class="form-control input-sm m-bot15" name="user_dept">
                    @foreach($user_dept as $key => $dept)
                        @if($dept->id==$user->department_id)
                        <option selected value="{{$dept->id}}">{{$dept->name}}</option>
                        @else
                        <option value="{{$dept->id}}">{{$dept->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div> --}}
            {{-- <div class="mb-3">
                <label for="Role" class="col-md-12 col-form-label text-md-end">{{ __('Role:') }}</label> --}}
                {{-- @if($roles)
                    @foreach($roles as $role)
                    <label for="" class="col-md-12">
                        <input type="checkbox" name="role_select[]" value="{{ $role->id }}" multiple checked>
                        {{ $role->name }}
                    </label>
                    @endforeach
                @endif
                @if ($roles->isEmpty())
                    @foreach ($all_role as $my_role)
                        <label for="" class="col-md-12">
                            <input type="checkbox" name="role_select[]" value="{{ $my_role->id }}" multiple>
                            {{ $my_role->name }}
                        </label>
                    @endforeach
                @endif --}}
                
            {{-- </div>
                <button type="submit" class="btn btn-primary mt-3">Update</button>
                </div>
            </div> --}}
        </form>
@endsection

@section('JS')
    <script type="text/javascript">
        $(document).on('click', '#btn_account_edit', function(){
            $(this).addClass('disabled');
        })
    </script>
@endsection