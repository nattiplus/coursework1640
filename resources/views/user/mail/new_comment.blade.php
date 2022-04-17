<div class="container">
    <p><strong>Idea: </strong>{{ $idea_title }}</p>
    <p><strong>Comment From: </strong>{{ $username }}</p>
    <p><strong>Date Comment: </strong>{{ $comment_date }}</p>
    <p><strong>Content: </strong>{!! $content !!}</p>
    <a href="{{ URL::to('/ideas-details/'.$idea_id) }}">Please visit this site to see more about this comment!</a>
</div>