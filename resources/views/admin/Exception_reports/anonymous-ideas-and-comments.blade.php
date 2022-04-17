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
        <a href="{{ route('ideas.without.comments') }}" class="active">
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
        <a href="{{URL::to('/admin/role')}}" class="sub-btn">
            <span class="las la-key"></span>
            <span>Roles</span>
        </a>
    </li>
    @endif
</ul>
@endsection

@section('AdminContent')
            <h1 class="heading">Ideas & Comments Table</h1>
            <p><span class="btn btn-light">Ideas With Comments: {{ count($anonymous_ideas) }}</span>
                &emsp;
                <span class="button-info">Normal Idea: 
                    <?php
                        $count = 0;
                        foreach ($anonymous_ideas as $key => $idea) {
                            if(!$idea->isAnonymous == true)
                            {
                                $count++;
                            }
                        }
                    ?>
                    {{ $count }}
                </span>
                &emsp;
                <span class="button-danger">Anonymous Idea: 
                    <?php
                        $count_anonymous_idea = 0;
                        foreach ($anonymous_ideas as $key => $idea) {
                            if($idea->isAnonymous == true)
                            {
                                $count_anonymous_idea++;
                            }
                        }
                    ?>
                    {{ $count_anonymous_idea }}
                </span>
            </p>
            <div class="tabs-header">
                <a href="{{ route('ideas.without.comments') }}" class="button-tabs">Ideas without a comment</a>
                <a href="{{ route('Anonymous.ideas.and.comments') }}" class="button-tabs-active">Anonymous ideas and comments</a>
            </div>
            <table class="table">
                <thead class="table-dark">
                    <th>#</th>
                    <th>Title</th>
                    <th>Desc</th>
                    <th>Content</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Submission</th>
                    <th>Comments</th>
                    <th>Create Date</th>
                    <th>Update Date</th>
                </thead>
                <tbody>
                    <?php
                        $paginate_ideas = App\Http\Controllers\IdeaController::paginate(collect($anonymous_ideas), 10);
                    ?>
                    @foreach ($paginate_ideas as $key => $idea)
                        @if ($idea->isAnonymous == true)
                        <tr class="table-danger">
                            <td data-label="#">{{ $idea->id }}</td>
                            <td data-label="Title">{{ $idea->title }}</td>
                            <td data-label="Desc">{!! $idea->description !!}</td>
                            <td data-label="Content">{!! $idea->content !!}</td>
                            <td data-label="Author">{{ $idea->user->name }}</td>
                            <td data-label="Category">{{ $idea->category->name }}</td>
                            <td data-label="Submission">{{ $idea->submission->name }}</td>
                            <td data-label="Comments">{{ $idea->comments->count() }}</td>
                            <td data-label="Create Date">{{ $idea->create_date }}</td>
                            <td data-label="Update Date">{{ $idea->last_modified_date }}</td>
                        </tr>
                        @else
                        <tr class="table-info">
                            <td data-label="#">{{ $idea->id }}</td>
                            <td data-label="Title">{{ $idea->title }}</td>
                            <td data-label="Desc">{!! $idea->description !!}</td>
                            <td data-label="Content">{!! $idea->content !!}</td>
                            <td data-label="Author">{{ $idea->user->name }}</td>
                            <td data-label="Category">{{ $idea->category->name }}</td>
                            <td data-label="Submission">{{ $idea->submission->name }}</td>
                            <td data-label="Comments">{{ $idea->comments->count() }}</td>
                            <td data-label="Create Date">{{ $idea->create_date }}</td>
                            <td data-label="Update Date">{{ $idea->last_modified_date }}</td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="pagination justify-content-center mt-3">
                {{ $paginate_ideas->links() }}
            </div>
        </div>
      </div>
@endsection