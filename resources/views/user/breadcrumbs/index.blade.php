@if (Route::getCurrentRoute()->getName() == 'list.ideas' || Route::getCurrentRoute()->getName() == 'list.ideas.all' || Route::getCurrentRoute()->getName() == 'list.ideas.most-popular-ideas' || Route::getCurrentRoute()->getName() == 'list.ideas.most-viewed-ideas' || Route::getCurrentRoute()->getName() == 'list.ideas.latest-ideas' || Route::getCurrentRoute()->getName() == 'list.ideas.latest-comments')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">List Of Ideas</li>
        </ol>
    </nav>
@elseif (Route::getCurrentRoute()->getName() == 'idea.details')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('list.ideas') }}">List Of Ideas</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $idea->title }}</li>
    </ol>
</nav>
@elseif (Route::getCurrentRoute()->getName() == 'submission.idea')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Submission</li>
    </ol>
</nav>
@elseif (Route::getCurrentRoute()->getName() == 'submission.List')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('submission.idea') }}">Submission</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $submission->name }}</li>
    </ol>
</nav>
@elseif (Route::getCurrentRoute()->getName() == 'submission.Details')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('submission.idea') }}">Submission</a></li>
    <li class="breadcrumb-item"><a href="{{ route('submission.List', $idea->submission_id) }}">{{ $idea->submission->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Idea "{{ $idea->title }}"</li>
    </ol>
</nav>
@elseif (Route::getCurrentRoute()->getName() == 'Idea.Contribute')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('submission.idea') }}">Submission</a></li>
    <li class="breadcrumb-item"><a href="{{ route('submission.List', $submissionId) }}">{{ App\Models\Submission::find($submissionId)->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Contribute Idea</li>
    </ol>
</nav>
@endif
