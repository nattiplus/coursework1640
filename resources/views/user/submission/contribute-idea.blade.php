@extends('layouts.app')
@section('content')
<div class="container">
    @include('user.breadcrumbs.index', ['submissionId', $submissionId])
</div>
<div class="container mt-5">
    <div class="card p-3 shadow mt-5">
        <form method="post" action="{{ route('store.idea') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="submission_id" value="{{ $submissionId }}">
            <div class="mb3">
                <h1 class="text-center">Give Your Opinions</h1>
            </div>
            <small id="error_message" style="color: red;">
                @if ($errors->any())
                <ul class="col-md-12">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </small>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Your Name</label>
                <?php
                    if($name)
                    { 
                    ?>
                <input type="text" class="form-control" id="exampleFormControlInput1" value="{{ $name }}" readonly>
                <?php    
                    }else
                    { 
                ?>
                <input type="text" class="form-control" id="exampleFormControlInput1" value="Null" readonly>
                <?php    
                    }
                ?>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Category</label>
                <span class="badge rounded-pill bg-success" id="tag_span"></span>
                <select class="form-select" aria-label="Default select" name="category_select">
                    <option selected disabled>>> Select Tag <<</option>
                    <?php
                        $categories = App\Models\Category::all();
                        foreach ($categories as $index => $category) 
                        {?>
                            <option value="{{ $category->id }}" id="opt_tag" data-tag="{{ $category->name }}">{{ $category->name }}</option>
                    <?php    
                        }
                    ?>
                  </select>
                {{-- <input type="text" class="form-control" id="exampleFormControlInput1" value="" > --}}
            </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="exampleFormControlInput1" value="" >
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="ckeditor2" rows="1"></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Your Ideas</label>
                <textarea class="form-control" name="content" id="ckeditor1" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Document</label>
                <input class="form-control" type="file" name="document[]" id="formFile" multiple>
            </div>
            {{-- <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" value="1" id="flexCheckIndeterminate">
                <label class="form-check-label" for="flexCheckIndeterminate">Incognito</label>
            </div> --}}
            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" value="0" id="agree_term_and_conditions">
                <label class="form-check-label" for="flexCheckIndeterminate">Agree with
                <!-- Button trigger modal -->
                    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Terms and Conditions
                    </button>
                </label>
                
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Term & Conditions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <p>The software development contract terms and conditions list what contractual agreement has been made between a company or contractor and the client. A description of the software should be included in this, and a contractor is also known as the developer who the client talked with to develop their product.</p>
                        {{-- <div class="checkbox">
                            <input type="checkbox" value="0" id="agree_term_and_conditions_child">
                            <label for="">I Agree.</label>
                        </div> --}}
                        </div>
                        <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-primary disabled" data-bs-dismiss="modal" id="btn_accept_term_conditions">Ok</button> --}}
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="form-check mt-3">
                <input type="checkbox" name="is_anonymous" id="is_anonymous_idea" class="form-check-input" value="0"/>
                <label class="form-check-label" for="flexCheckIndeterminate">Anonymous Idea</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3 disabled" id="submit_idea">Submit</button>
        </form>
    </div>
</div>
@endsection

@section('JS')
    <script type="text/javascript">
        // Anonymous Comment
        $(document).ready(function(){
            $(document).on('click','#is_anonymous_idea',function(){
                if($(this).prop("checked") == true){
                    $(this).attr('value', 1)
                    // console.log($(this).val());
                }
                else if($(this).prop("checked") == false){
                    $(this).attr('value', 0)
                    // console.log($(this).val());
                }
            });
        });

        // Agree Term and conditions
        $(document).ready(function(){
            $(document).on('click','#agree_term_and_conditions',function(){
                if($(this).prop("checked") == true){
                    $('#submit_idea').removeClass('disabled');
                    // console.log($(this).val());
                }
                else if($(this).prop("checked") == false){
                    $(this).attr('value', 0)
                    $('#submit_idea').addClass('disabled');
                    // console.log($(this).val());
                }
            });
        });

        // // Agree Term and conditions Child Modal
        // $(document).ready(function(){
        //     $(document).on('click','#agree_term_and_conditions_child',function(){
        //         if($(this).prop("checked") == true){
        //             $('#btn_accept_term_conditions').removeClass('disabled');
        //             // console.log($(this).val());
        //         }
        //         else if($(this).prop("checked") == false){
        //             $(this).attr('value', 0)
        //             $('#agree_term_and_conditions').attr('checked', false);
        //             $('#submit_idea').addClass('disabled')
        //             $('#btn_accept_term_conditions').addClass('disabled');
        //             // console.log($(this).val());
        //         }
        //     });
        // });

        // // Agree Term and conditions Child Modal Click Ok
        // $(document).ready(function(){
        //     $(document).on('click','#btn_accept_term_conditions',function(){
        //         $('#submit_idea').removeClass('disabled');
        //         $('#agree_term_and_conditions').attr('checked', true);
        //         if($('#agree_term_and_conditions').prop("checked") == false){
        //             $('#agree_term_and_conditions').attr('checked', true);
        //             // console.log($(this).val());
        //         }
        //     });
        // });

        // Select Tag
        $(document).ready(function(){
            $(document).on('click','#opt_tag',function(){
                var tag_name = $(this).data('name');
                $('tag_span').text('#'+ tag_name);
                console.log(tag_name);
            });
        });
        $('select').on('change', function(){
            var optionSelected = $(this).find("option:selected");
            var valueSelected = optionSelected.data('tag');
            $('#tag_span').text('# ' + valueSelected);
        });
    </script>

    <script type="text/javascript">
        $(document).on('click', '#submit_idea', function(){
            $(this).addClass('disabled');
        })
    </script>
@endsection