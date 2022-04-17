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
        <a href="{{URL::to('/admin/censor-ideas')}}" class="active">
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
    <h1 class="heading">User Contribute Info</h1>
    <div style="margin-bottom: 30px;">
        <a href="{{ route('idea.cencor') }}" class="button-pink"><i class="las la-arrow-left"></i> Back To Censor Idea</a>
    </div>
    <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>

    <div class="col-md-12">
        @if ($data_users == null && $department_all == null)
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="{{ Auth::user()->department_id }}-tab" data-toggle="tab" href="#department-{{ Auth::user()->department_id }}" role="tab" aria-controls="home" aria-selected="true">{{ App\Models\Department::find(Auth::user()->department_id)->name; }}</a>
        </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="department-{{ Auth::user()->department_id }}" role="tabpanel" aria-labelledby="{{Auth::user()->department_id}}-tab">
                <table class="table">
                    <thead class="table-dark">
                        <th>#</th>
                        <th>Title</th>
                        <th>Decription</th>
                        <th>Content</th>
                        <th>Incognito</th>
                        <th>Action</th>
                    </thead>
                    <tbody>No Idea Found</tbody>
                </table>
            </div>
          </div>
        @endif
        @if ($data_users)
        <div class="tabs-header">
            <a href="{{ route('ideas.info') }}" class="button-tabs-active" id="{{ Auth::user()->department_id }}">{{ App\Models\Department::find(Auth::user()->department_id)->name; }}</a>
        </div>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="department-{{ Auth::user()->department_id }}" role="tabpanel" aria-labelledby="{{Auth::user()->department_id}}-tab">
                <table class="table">
                    <thead class="table-dark">
                        <th>#</th>
                        <th>FullName</th>
                        <th>PhoneNumber</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Country</th>
                        <th>Type</th>
                        <th>Idea Contribute</th>
                        <th>Action</th>
                    </thead>
                    <?php
                        $paginate_data_users = App\Http\Controllers\IdeaController::paginate(collect($data_users), 5);
                    ?>
                    @foreach($paginate_data_users as $key => $user)
                        @if ($user->ideas->isEmpty())
                        <tbody class="table-danger">
                            <td data-label="#">{{ $user->id}}</td>
                            <td data-label="FullName">{{ $user->name }}</td>
                            <td data-label="PhoneNumber">{{ $user->phonenumber }}</td>
                            <td data-label="Email">{{ $user->email }}</td>
                            <td data-label="Address">{{ $user->address }}</td>
                            <td data-label="Country">{{ $user->country }}</td>
                            <td data-label="Type">{{ $user->type }}</td>
                            <td data-label="Idea Contribute">
                                @if ($user->ideas->isEmpty())
                                    <button class="button-danger">Not Contribute Idea</button>
                                @else
                                    <button class="button-success">Have Contributed {{ $user->ideas->count() }} ideas</button>
                                @endif
                            </td>
                            <td data-label="Action">
                                @if ($user->ideas->isEmpty())
                                    <!-- Button trigger modal -->
                                    {{-- <div class="container-modal">
                                        <a href="#" class="button-dark-pink btn-modal-1" data-title="" data-description="hello"><i class="las la-envelope"></i> Encourage</a>
                                    </div> --}}
                                    <button class="button-dark-pink btn btn-modal-1" data-target="#modal-{{ $user->id }}"><i class="las la-envelope"></i> Encourage</button>
                                    {{-- Modal --}}
                                    <div class="modal" id="modal-{{ $user->id }}">
                                        <div class="header">
                                            <div class="title">Send Encourage Email</div>
                                            <button class="btn modal-btn" data-target="#modal-{{ $user->id }}">&times;</button>
                                        </div>
                                        <div class="body">
                                            <form method="POST" action="{{ route('ideas.encourage.post') }}">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
        
                                                <div class="data-input">
                                                    <label>Send To</label>
                                                    <input type="text" readonly name="email_address" value="{{ $user->email }}">
                                                </div>
                                                <div class="data-textarea">
                                                    <label>Message</label>
                                                    <textarea rows="5" name="message_content_encourage" required></textarea>
                                                </div>
                                                <div class="btn">
                                                    <div class="inner"></div>
                                                    <button type="submit" id="btn_encourage_email" class="btn">Send</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div id="overlay"></div>

                                @else
                                    <a href="{{ route('ideas.user.delete', $user->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                @endif     
                            </td>
                        </tbody>
                        @else
                        <tbody class="table-success">
                            <td data-label="#">{{ $user->id }}</td>
                            <td data-label="FullName">{{ $user->name }}</td>
                            <td data-label="PhoneNumber">{{ $user->phonenumber }}</td>
                            <td data-label="Email">{{ $user->email }}</td>
                            <td data-label="Address">{{ $user->address }}</td>
                            <td data-label="Country">{{ $user->country }}</td>
                            <td data-label="Type">{{ $user->type }}</td>
                            <td data-label="Idea Contribute">
                                @if ($user->ideas->isEmpty())
                                    <button class="button-danger">Not Contribute Idea</button>
                                @else
                                    <button class="button-success">Have Contributed {{ $user->ideas->count() }} ideas</button>
                                @endif
                            </td>
                            <td data-label="Action">
                                @if ($user->ideas->isEmpty())
                                    <button class="button-dark-pink"><i class="fas fa-envelope"></i> Encourage</button>
                                @else
                                    <a href="{{ route('ideas.user.delete', $user->id) }}" onclick="return confirm('Are you sure?')" class="button-danger"><i class="las la-trash"></i></a>
                                @endif     
                            </td>
                        </tbody>
                        @endif
                    @endforeach
                </table>
                <div class="pagination justify-content-center mt-3">
                    {{ $paginate_data_users->links() }}
                </div>
            </div>
          </div>
        @else
          <h1 class="heading">No data found</h1>
        @endif
    </div>
@endsection

@section('JS')
    <script type="text/javascript">
        const btns = document.querySelectorAll("[data-target]");
        const close_btns = document.querySelectorAll(".modal-btn");
        const overlay = document.querySelector("#overlay");

        btns.forEach((btn) =>{
            btn.addEventListener('click', () => {
                document.querySelector(btn.dataset.target).classList.add("active");
                overlay.classList.add('active');
            });
        });

        close_btns.forEach((btn) =>{
            btn.addEventListener('click', () => {
                // document.querySelector(btn.dataset.target).classList.remove("active");
                btn.closest(".modal").classList.remove("active");
                overlay.classList.remove('active');
            });
        });

        window.onclick = (e) => {
            if(e.target == overlay){
                const modals = document.querySelectorAll('.modal');
                modals.forEach(modal => modal.classList.remove("active"));
                overlay.classList.remove("active");
            }
        }
    </script> 

    <script type="text/javascript">
        $(document).on('click', '#btn_encourage_email', function(){
            var message = $("#message_content").val();
            if(message != "")
            {
                $('#btn_encourage_email').addClass('disabled');
            }
            
            // if($("#message_content").val() != "")
            // {
            //     console.log('Validate');
            //     $('#btn_encourage_email').addClass('disabled');      
            // }
            // else
            // {
            //     console.log('Not Validate');
            // }
        })
    </script> 
@endsection

{{-- @section('JS')
    <script type="text/javascript">
        /* Modal */
        var btn_modal = document.querySelector('.btn-modal')
        var container = document.querySelector('.container')

        btn_modal.addEventListener('click', function(){
            container.classList.toggle('show-modal')
        })
    </script>
@endsection --}}

{{--         <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach ($department_all as $key => $department)
                @if ($key == 0)
                <a href="#" class="button-tabs-active">{{ $department->name }}</a>
                @else
                <a href="#" class="button-tabs">{{ $department->name }}</a>
                @endif
            @endforeach
          </ul>
          <div class="tab-content" id="myTabContent">
            @foreach ($department_all as $key => $department)
                @if ($key == 0)
                <div class="tab-pane fade show active" id="department-{{ $department->id }}" role="tabpanel" aria-labelledby="{{ $department->id }}-tab">
                    <?php 
                        $users_per_department = App\Models\Department::find($department->id)->users;
                    ?>
                    <table class="table">
                        <thead class="table-dark">
                            <th>#</th>
                            <th>FullName</th>
                            <th>PhoneNumber</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Country</th>
                            <th>Type</th>
                            <th>Idea Contribute</th>
                            <th>Action</th>
                        </thead>
                        @foreach($users_per_department as $key => $user)
                            @if ($user->ideas->isEmpty())
                            <tbody class="table-danger">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phonenumber }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->country }}</td>
                                <td>{{ $user->type }}</td>
                                <td>
                                    @if ($user->ideas->isEmpty())
                                        <button class="btn btn-danger disabled">Not Contribute Idea</button>
                                    @else
                                        <button class="btn btn-success disabled">Have Contributed {{ $user->ideas->count() }} ideas</button>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->ideas->isEmpty())
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fas fa-envelope"></i> Encourage
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Send Encourage Mail</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <form method="POST" action="{{ route('ideas.encourage.post') }}">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Message:</label>
                                                    <input class="form-control" id="message-text" name="email_address" value="{{ $user->email }}" readonly>
                                                  </div>
                                                <div class="form-group">
                                                  <label for="message-text" class="col-form-label">Message:</label>
                                                  <textarea class="form-control" id="message-text" rows="5" name="message_content"></textarea>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Send message</button>
                                                  </div>
                                            </form>
                                            </div>           
                                          </div>
                                        </div>
                                    </div>
                                    @else
                                        <button class="btn btn-warning"><i class="fas fa-eye"></i></button>
                                        <a href="{{ route('ideas.user.delete', $user->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                    @endif     
                                </td>
                            </tbody>
                            @else
                            <tbody class="table-info">
                                <td>{{$user->id}}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phonenumber }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->country }}</td>
                                <td>{{ $user->type }}</td>
                                <td>
                                    @if ($user->ideas->isEmpty())
                                        <button class="btn btn-danger disabled">Not Contribute Idea</button>
                                    @else
                                        <button class="btn btn-success disabled">Have Contributed {{ $user->ideas->count() }} ideas</button>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->ideas->isEmpty())
                                        <button class="btn btn-info disabled"><i class="fas fa-envelope"></i> Encourage</button>
                                    @else
                                        <button class="btn btn-warning"><i class="fas fa-eye"></i></button>
                                        <a href="{{ route('ideas.user.delete', $user->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                    @endif     
                                </td>
                            </tbody>
                            @endif
                        @endforeach
                    </table>
                </div>
                @else
                <div class="tab-pane fade" id="department-{{ $department->id }}" role="tabpanel" aria-labelledby="{{ $department->id }}-tab">
                    <?php 
                        $users_per_department = App\Models\Department::find($department->id)->users;
                    ?>
                    <table class="table">
                        <thead class="table-dark">
                            <th>#</th>
                            <th>FullName</th>
                            <th>PhoneNumber</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Country</th>
                            <th>Type</th>
                            <th>Idea Contribute</th>
                            <th>Action</th>
                        </thead>
                        @foreach($users_per_department as $key => $user)
                            @if ($user->ideas->isEmpty())
                            <tbody class="table-danger">
                                <td>{{$user->id}}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phonenumber }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->country }}</td>
                                <td>{{ $user->type }}</td>
                                <td>
                                    @if ($user->ideas->isEmpty())
                                        <button class="btn btn-danger disabled">Not Contribute Idea</button>
                                    @else
                                        <button class="btn btn-success disabled">Have Contributed {{ $user->ideas->count() }} ideas</button>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->ideas->isEmpty())
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fas fa-envelope"></i> Encourage
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Send Encourage Mail</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <form method="POST" action="{{ route('ideas.encourage.post') }}">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Message:</label>
                                                    <input class="form-control" id="message-text" name="email_address" value="{{ $user->email }}" readonly>
                                                  </div>
                                                <div class="form-group">
                                                  <label for="message-text" class="col-form-label">Message:</label>
                                                  <textarea class="form-control" id="message-text" rows="5" name="message_content"></textarea>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Send message</button>
                                                  </div>
                                            </form>
                                            </div>           
                                          </div>
                                        </div>
                                    </div>
                                    @else
                                        <button class="btn btn-warning"><i class="fas fa-eye"></i></button>
                                        <a href="{{ route('ideas.user.delete', $user->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                    @endif     
                                </td>
                            </tbody>
                            @else
                            <tbody class="table-info">
                                <td>{{$user->id}}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phonenumber }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->country }}</td>
                                <td>{{ $user->type }}</td>
                                <td>
                                    @if ($user->ideas->isEmpty())
                                        <button class="btn btn-danger disabled">Not Contribute Idea</button>
                                    @else
                                        <button class="btn btn-success disabled">Have Contributed {{ $user->ideas->count() }} ideas</button>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->ideas->isEmpty())
                                        <button class="btn btn-info disabled"><i class="fas fa-envelope"></i> Encourage</button>
                                    @else
                                        <button class="btn btn-warning"><i class="fas fa-eye"></i></button>
                                        <a href="{{ route('ideas.user.delete', $user->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                    @endif     
                                </td>
                            </tbody>
                            @endif
                        @endforeach
                    </table>
                </div>
                @endif
            @endforeach
          </div> --}}