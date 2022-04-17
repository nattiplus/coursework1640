@extends('layouts.app')
@section('content')
<div class="container">
    @include('user.breadcrumbs.index', ['idea', $idea->id])
</div>
<div class="container mt-5">
    <div class="card p-3 shadow mt-5">
        <div class="container position-relative">
            <div class="card-title text-end">
                <?php
                $viewers = App\Models\Viewer::where('idea_id', $idea->id)->count();
                ?>
                @if ($viewers)
                <p><i class="fas fa-eye " style="color: black;"></i> {{ $viewers }}</p>
                @else
                <p><i class="fas fa-eye " style="color: black;"></i> 0</p>    
                @endif
            </div>
            <div class="row" >
                <div class="col-md-10 right">
                    <img src="https://i.pinimg.com/originals/0c/3b/3a/0c3b3adb1a7530892e55ef36d3be6cb8.png" alt="" width="120" height="120">
                    <div class="text">
                        <h2>{{ $idea->title }}</h2>
                        @if ($idea->isAnonymous == true)        
                        <button type="button" class="btn btn-outline-dark" disabled><h5>Author: Anonymous</h5></button>
                        @else
                        <button type="button" class="btn btn-outline-info" disabled><h5>Author: {{ $user->name }}</h5></button>
                        @endif
                    </div>
                </div>
                <div class="col-md-2 left">
                    {{-- <div>
                        <h5>0</h5>
                        <p><i class="fas fa-thumbs-up fa-2x" style="color: green;"></i></p>
                    </div>
                    <div>
                        <h5>0</h5>
                        <p><i class="fas fa-thumbs-down fa-2x" style="color: red;"></i></p>
                    </div> --}}
                    @if ($reaction_types->isNotEmpty())
                        @include('user.reaction.index', ['reaction_types'=>$reaction_types])
                    @else
                        <button type="button" class="btn btn-outline-danger" disabled><h5>Reaction is not available.</h5></button>
                    @endif
                </div>
            </div>

            <div class="card-title mt-3">
                {!!$idea->content!!}
            </div>

            <?php
                foreach($fileupload as $file)
                {
                    $file = storage_path('uploads/documents/'. $file->file_path);
                    if(file_exists($file))
                    { ?>
                        <div class="card-title text-center" style="border-bottom: 1px solid gray;padding: 50px 0;">
                                {{--                             <form action="{{ URL::to('/ideas-details/getdocuments/'. $id) }}" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-primary">Download document</button>
                            </form>  --}}   

                        <a href="{{ URL::to('/ideas/details/getdocuments/'. $id) }}" class="btn buttons-zip">Download as Zip <i class="fas fa-file-download"></i></a>

                        </div>    
            <?php   break;}
                }
            ?>
            @if ($idea->submission->final_closure_date >= Carbon\Carbon::now())
            <form action="" method="POST" role="form" class="mt-3 form-prevent-multiple-submits">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="hidden" name="idea_id" value="{{ $id }}">
                    <textarea name="content" id="comment-content" class="form-control" rows="3" placeholder="Type Something Here (*)"></textarea>
                    <small id="comment-error" class="help-blog" style="color: red;"></small>
                </div>
                <div class="form-check mt-3">
                    <input type="checkbox" name="is_anonymous" id="is_anonymous" class="form-check-input" value="0"/>
                    <label class="form-check-label" for="flexCheckIndeterminate">Anonymous Idea</label>
                </div>
                <button type="submit" class="btn btn-primary" id="btn-comment">Send Comment</button>
            </form>
            @else
            <h6 style="color: red;">Comment For This Idea Has Been Expired</h6>
            @endif

            <div id="comment">
                @include('user.comment.index', ['data_comments'=>$idea->comments])
            </div>
        </div>

    </div>
</div>
@endsection

@section('JS')
    <!-- Using Ajax for Comment -->
    <script type="text/javascript">
        var _csrf = '{{ csrf_token() }}';
        // Anonymous Comment
        $(document).ready(function(){
            $(document).on('click','#is_anonymous',function(){
                if($(this).prop("checked") == true){
                    $(this).attr('value', 1)
                }
                else if($(this).prop("checked") == false){
                    $(this).attr('value', 0)
                }
            });
        });
        //Comment
          $('#btn-comment').click(function(ev){
            let _commentUrl = '{{ route("ajax.comment", $id) }}';
            ev.preventDefault();
            $("#btn-comment").attr("disabled", true);
            let content = $('#comment-content').val();
            let is_anonymous = $('#is_anonymous').val();
            $.ajax({
              url: _commentUrl,
              type: 'POST',
              data:{
                content: content,
                anonymous: is_anonymous,
                _token: _csrf
              },
              success: function(res){
                if(res.error)
                {
                  $('#comment-error').html(res.error)
                  $("#btn-comment").attr("disabled", false);
                }else{
                  $('#comment-error').html('')
                  $('#comment-content').val('')
                  $('#comment').html(res)
                  console.log($('#comment').html(res));
                  $("#btn-comment").attr("disabled", false);
                }
              }
            });
          })
        
        // Show Reply Form
        $(document).on('click','.btn-show-reply-form',function(ev){
            ev.preventDefault();
            var id = $(this).data('id');
            var form_reply = '.form-reply-' + id;
            $('.form-Reply').slideUp();
            $(form_reply).slideDown();
        })

        // Anonymous Comment Reply
        $(document).ready(function(){
            $(document).on('click','#is_anonymous_reply_content',function(){
                if($(this).prop("checked") == true){
                    $(this).attr('value', 1)
                }
                else if($(this).prop("checked") == false){
                    $(this).attr('value', 0)
                }
            });
        });
        // Send Reply Comment
        $(document).on('click','.btn-send-comment-reply',function(ev){
            let _commentUrl = '{{ route("ajax.comment", $id) }}';
            ev.preventDefault();
            var id = $(this).data('id');
            var comment_reply_id = '#content-reply-' + id;
            var btn_reply = $(this);
            var content_reply = $(comment_reply_id).val();
            let is_anonymous_reply = $('#is_anonymous_reply_content').val();

            $.ajax({
              url: _commentUrl,
              type: 'POST',
              data:{
                content: content_reply,
                anonymous: is_anonymous_reply,
                reply_id: id,
                _token: _csrf
              },
              beforeSend: function(){
                btn_reply.addClass('disabled');
              },
              success: function(res){
                if(res.error)
                {

                  $('#comment-reply-error').html(res.error)
                  btn_reply.removeClass('disabled');
                }else{
                  $('#comment-reply-error').html('')
                  $('#comment-content').val('')
                  btn_reply.removeClass('disabled');
                  $('#comment').html(res)
                }
              }
            });
        })
    </script>

    {{-- Reaction --}}
    <script type="text/javascript">
      $(document).on('click', '#btn-reaction', function(ev){
          ev.preventDefault();
          var _type = $(this).data('type');
          var _post = $(this).data('id');
          var _idea = $(this).data('idea');
          var _csrf = '{{ csrf_token() }}';
          var btn_reaction = $(this);
          var btn_reaction_new = $('#btn-reaction-new');
          // console.log(btn_reaction_new, btn_reaction);
          var _url = '{{ route("create.reaction", $id) }}';
          $.ajax({
              url: _url,
              type: 'POST',
              data:{
                  content: _post,
                  _token: _csrf
              },
              beforeSend:function(){
                  btn_reaction.addClass('disabled');
              },
              success:function(res){
                  if(res.bool == true)
                  {
                      btn_reaction.removeClass('disabled').addClass('active');
                      // btn_reaction.removeAttr('id');
                      var _prevCount = $("."+_type+"-count").text();
                      _prevCount++;
                      $("." +_type+"-count").text(_prevCount);
                  }
                  if(res.bool == false)
                  {
                      btn_reaction.removeClass('disabled').removeClass('active');
                      // btn_reaction.removeAttr('id');
                      var _prevCount = $("."+_type+"-count").text();
                      _prevCount--;
                      // console.log(_prevCount);
                      $("." +_type+"-count").text(_prevCount);
                      btn_reaction.attr('id', 'btn-reaction-new');
                      $("." +_type+"-count").attr('class', _type+"-count-new");;
                  }
              }
          });
      })

      $(document).on('click', '#btn-reaction-new', function(ev){
          ev.preventDefault();
          var _type = $(this).data('type');
          var _post = $(this).data('id');
          var _idea = $(this).data('idea');
          var _csrf = '{{ csrf_token() }}';
          var btn_reaction = $(this);
          var btn_reaction_old = $('#btn-reaction');
          var _type_old = $(btn_reaction_old).data('type');
          var _url = '{{ route("create.reaction", $id) }}';
          $.ajax({
              url: _url,
              type: 'POST',
              data:{
                  content: _post,
                  _token: _csrf
              },
              beforeSend:function(){
                  btn_reaction.addClass('disabled');
              },
              success:function(res){
                  if(res.bool == true)
                  {
                      btn_reaction.removeClass('disabled').addClass('active');
                      // old btn
                      btn_reaction_old.removeClass('active');
                      var _prevCount_old = $("."+_type_old+"-count").text();
                      _prevCount_old--;
                      // console.log(_prevCount_old);
                      $("." +_type_old+"-count").text(_prevCount_old);
                      btn_reaction_old.attr('id', 'btn-reaction-new');
                      $("." +_type_old+"-count").attr('class', _type_old+"-count-new");
                      // btn_reaction.removeAttr('id');
                      var _prevCount = $("."+_type+"-count-new").text();
                      _prevCount++;
                      $("." +_type+"-count-new").text(_prevCount);
                      btn_reaction.attr('id', 'btn-reaction');
                      $("." +_type+"-count-new").attr('class', _type+"-count");;
                  }
                  // if(res.bool == false)
                  // {
                  //     btn_reaction.removeClass('disabled').removeClass('active');
                  //     // btn_reaction.removeAttr('id');
                  //     var _prevCount = $("."+_type+"-count-new").text();
                  //     _prevCount--;
                  //     console.log(_prevCount);
                  //     $("." +_type+"-count-new").text(_prevCount);
                  // }
              }
          });
      })
  </script>
@endsection