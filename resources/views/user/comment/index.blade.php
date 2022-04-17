@if ($data_comments->isNotEmpty())
<h4 class="mt-5">Comments ({{ App\Models\Comment::where('idea_id', $data_comments[0]->idea_id)->count() }})</h4>
@else
<h4 class="mt-5">Comments (0)</h4>    
@endif
@foreach($data_comments as $comment)
    @if ($comment->comment_id == 0 && $comment->user->id != null)
    <div class="d-flex mt-3">
        <div class="flex-shrink-0">
        <img src="https://i.pinimg.com/originals/0c/3b/3a/0c3b3adb1a7530892e55ef36d3be6cb8.png" alt="User Image" width="40">
        </div>
        <div class="flex-grow-1 ms-3">
        @if ($comment->isAnonymous == true)        
            <button type="button" class="btn btn-sm btn-outline-dark" disabled><strong>Anonymous</strong></button>
        @else
            <button type="button" class="btn btn-sm btn-outline-info" disabled><strong>{{ $comment->user->name }}</strong></button>
        @endif
        <p>{{ $comment->content }}</p>
        @if ($comment->idea->submission->final_closure_date >= Carbon\Carbon::now())
        <p>
            <a href="" class="btn btn-sm btn-secondary btn-show-reply-form" data-id="{{ $comment->id }}">Reply</a>
        </p>
        <form action="" method="POST" role="form" class="form-Reply form-reply-{{ $comment->id }}" style="display: none;">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="">Reply Content</label>
                <textarea id="content-reply-{{ $comment->id }}" class="form-control" rows="3" placeholder="Type Something Here (*)"></textarea>
                <small id="comment-reply-error" class="help-blog" style="color: red;"></small>
            </div>
            <div class="form-check mt-3">
                <input type="checkbox" name="is_anonymous" id="is_anonymous_reply_content" class="form-check-input" value="0"/>
                <label class="form-check-label" for="flexCheckIndeterminate">Anonymous Idea</label>
            </div>
            <button type="submit" data-id="{{ $comment->id }}" class="btn btn-primary btn-send-comment-reply">Send Comment</button>
        </form> 
        @endif
        </div>
    </div>
    @endif
    @foreach($comment->replies as $child_comment)
        <div class="d-flex" style="margin-left: 50px;">
            <div class="flex-shrink-0 user-reply-{{ $child_comment->comment_id }}">
            <img src="https://i.pinimg.com/originals/0c/3b/3a/0c3b3adb1a7530892e55ef36d3be6cb8.png" alt="User Image" width="40">
            </div>
            <div class="flex-grow-1 ms-3 user-reply-{{ $child_comment->comment_id }}">
            @if ($child_comment->isAnonymous == true)        
            <button type="button" class="btn btn-sm btn-outline-dark" disabled><strong>Anonymous</strong></button>
            @else
                <button type="button" class="btn btn-sm btn-outline-info" disabled><strong>{{ $child_comment->user->name }}</strong></button>
            @endif
            <p>{{ $child_comment->content }}</p>
            </div>
        </div>
    @endforeach
@endforeach