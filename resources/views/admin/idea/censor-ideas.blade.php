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
<h1 class="heading">Censor Ideas</h1>
    <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
    <a href="{{ route('ideas.info') }}" class="button-pink"><i class="las la-info"></i> User Contribute Info</a>
    <div class="col-md-12">
        @if ($data_idea == null && $department_all == null)
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
        @if ($data_idea)
        <div class="tabs-header">
            <a href="{{ route('idea.cencor') }}" class="button-tabs-active" id="{{ Auth::user()->department_id }}">{{ App\Models\Department::find(Auth::user()->department_id)->name; }}</a>
        </div>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="department-{{ Auth::user()->department_id }}" role="tabpanel" aria-labelledby="{{Auth::user()->department_id}}-tab">
                <table class="table">
                    <thead class="table-dark">
                        <th>#</th>
                        <th>Title</th>
                        <th>Decription</th>
                        <th>Content</th>
                        <th>Author</th>
                        <th>Submission Gate</th>
                        <th>Action</th>
                    </thead>
                    <?php
                        $paginate_data_idea = App\Http\Controllers\IdeaController::paginate(collect($data_idea), 10);
                    ?>
                    @foreach($paginate_data_idea as $key => $idea)
                        <tbody>
                            <td data-label="#">{{$idea['id']}}</td>
                            <td data-label="Title">{{$idea['title']}}</td>
                            <td data-label="Description">{{$idea['description']}}</td>
                            <td data-label="Content">{{$idea['content']}}</td>
                            <td data-label="Author">{{ App\Models\User::find($idea['user_id'])->name }}</td>
                            <td data-label="Submission Gate">{{ App\Models\Submission::find($idea['submission_id'])->name }}</td>
                            <td data-label="Action">
                                @if ($idea['isApprove'] != true)
                                <a href="{{URL::to('/admin/approve/'.$idea['id'])}}" class="button-primary" style="display: inline-block;"><i class="las la-pen"></i></a>
                                <a href="{{URL::to('/admin/unApprove/'.$idea['id'])}}" onclick="return confirm('Are you sure?')" class="button-danger" style="display: inline-block;"><i class="las la-trash"></i></a>
                                @else
                                <button class="button-success" disabled>Approved</button>
                                @endif      
                            </td>
                        </tbody>
                     @endforeach
                </table>
                <div class="pagination justify-content-center mt-3">
                    {{ $paginate_data_idea->links() }}
                </div>
            </div>
          </div>
        @else
        <h1 class="heading">No Data Found</h1>
        @endif
    </div>
@endsection
{{--         @else
        <div class="tabs-header">
            @foreach ($department_all as $key => $department)
            @if ($key == 0)
                <a href="#" class="button-tabs-active">{{ $department->name }}</a>
            @else
                <a href="#" class="button-tabs">{{ $department->name }}</a>
            @endif
        @endforeach
        </div>
          <div class="tab-content" id="myTabContent">
            @foreach ($department_all as $key => $department)
                @if ($key == 0)
                <div class="tab-pane fade show active" id="department-{{ $department->id }}" role="tabpanel" aria-labelledby="{{ $department->id }}-tab">
                    <?php 
                        $ideas_per_department = array();
                        $users = App\Models\Department::find($department->id)->users;
                        foreach ($users as $key => $user) {
                            $ideas = App\Models\User::find($user->id)->ideas;
                            foreach ($ideas as $key => $idea) {
                                array_push($ideas_per_department, $idea);
                            }
                        } 
                    ?>
                    <table class="table">
                        <thead class="table-dark">
                            <th>#</th>
                            <th>Title</th>
                            <th>Decription</th>
                            <th>Content</th>
                            <th>Incognito</th>
                            <th>Action</th>
                        </thead>
                        @if($ideas_per_department)
                            @foreach($ideas_per_department as $index => $idea)
                            <tbody>
                                <td>{{$idea->id}}</td>
                                <td>{{$idea->title}}</td>
                                <td>{{$idea->description}}</td>
                                <td>{{$idea->content}}</td>
                                <td> </td>
                                <td>
                                    @if ($idea->isApprove == NULL)
                                    <a href="{{URL::to('/admin/approve/'.$idea->id)}}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                    <a href="{{URL::to('/admin/unApprove/'.$idea->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                    @else
                                    <button class="btn btn-success" disabled>Approved</button>
                                    @endif      
                                </td>
                            </tbody>
                            @endforeach
                        @endif
                    </table>
                </div>
                @else
                <div class="tab-pane fade" id="department-{{ $department->id }}" role="tabpanel" aria-labelledby="{{ $department->id }}-tab">
                    <?php 
                    $ideas_per_department = array();
                    $users = App\Models\Department::find($department->id)->users;
                    foreach ($users as $key => $user) {
                        $ideas = App\Models\User::find($user->id)->ideas;
                        foreach ($ideas as $key => $idea) {
                            array_push($ideas_per_department, $idea);
                        }
                    } 
                    ?>
                    <table class="table">
                        <thead class="table-dark">
                            <th>#</th>
                            <th>Title</th>
                            <th>Decription</th>
                            <th>Content</th>
                            <th>Incognito</th>
                            <th>Action</th>
                        </thead>
                        @if($ideas_per_department)
                            @foreach($ideas_per_department as $index => $idea)
                            <tbody>
                                <td>{{$idea->id}}</td>
                                <td>{{$idea->title}}</td>
                                <td>{{$idea->description}}</td>
                                <td>{{$idea->content}}</td>
                                <td> </td>
                                <td>
                                    @if ($idea->isApprove == NULL)
                                    <a href="{{URL::to('/admin/approve/'.$idea->id)}}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                    <a href="{{URL::to('/admin/unApprove/'.$idea->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                    @else
                                    <button class="btn btn-success" disabled>Approved</button>
                                    @endif      
                                </td>
                            </tbody>
                            @endforeach
                        @endif
                    </table>
                </div>
                @endif
            @endforeach
          </div> --}}