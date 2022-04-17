<div class="container">
    <p><strong>Category: </strong>{{ $category }}</p>
    <p><strong>Submission Gate: </strong>{{ $submission }}</p>
    <p><strong>Date Submit: </strong>{{ $date_submit }}</p>
    <p><strong>Author: </strong>{{ $username }}</p>
    <p><strong>Content: </strong>{!! $content !!}</p>
    <a href="{{ URL::to('/ideas-details/'.$idea_id) }}">Please visit this site to see more about my idea!</a>
</div>