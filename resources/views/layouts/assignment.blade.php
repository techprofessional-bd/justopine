@extends('home')
@section('title')
        {{"Assignment"}}
    @endsection
@section('master')
<section class="container-fluid">
    <div class="row" id="breadcrumb">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h2>Have Your Say</h2>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-xs-12">
            <h4>Responses from Pupil</h4>
            <div class="container-fluid">
                <div class="right-Bar">
                    @foreach($getresp as $resp)
                        <a href="#{{$resp->username}}">{{$resp->name}}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-9 col-xs-12">
            @foreach($opinionDtl as $opinion)
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="assignment-feed row">
                        <div class="container-fluid">
                            <div class="col-md-12">
                                <h4 style="color:#595900;" class="col-md-10 col-xs-12">{{$opinion->title}}</h4>
                                @if(Session::get('logged')[0]['type']=="TEACHER")
                                <div class="col-md-2 col-xs-12">
                                    <a href="#" class="js-open-modal" data-modal-id="editpopup"><img src="{!! url('design/images/edit.png') !!}" width="25%"> </a>
                                </div>
                                @endif
                                <div class="col-md-12">{!! $opinion->description !!}</div>
                                <div class="col-md-12">
                                    <a href="#" role="button" class="btn btn-primary" id="category">

                                        <?php $cat=getCategoryName($opinion->category_id);?>
                                        {{$cat->category_title}}
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php
                $chkrspns=chkResponses($opinion->id);
            ?>
        @if(Session::get('logged')[0]['type']=="PUPIL" && count($chkrspns)<1)
            <div class="row">
                <div class="response-create-box col-md-12 col-xs-12">
                    <form class="form-vertical" role="form" method="post" action="#" class="response-form">
                        <input type="hidden" id="token" value="{{ csrf_token() }}" name="_token">
                        <input type="hidden" name="txtRefId" id="txtRefId" value="{{$opinion->id}}">
                        <input type="hidden" name="ddlClassId" id="ddlClassId" value="{{$opinion->class_code}}">
                        <input type="hidden" name="ddlCategory" id="ddlCategory" value="{{$opinion->category_id}}">
                        <div class="form-group" style="margin-top:25px;">
                            <label for="answer" class="col-sm-12 control-label" style="margin-top:15px;">Describe your opinion in three words.</label>
                            <div class="col-sm-10" style="margin-top:7px;">
                                <input type="text" required="required" class="col-sm-12 form-control" id="answer" name="answer" placeholder="Describe your opinion in three words." value="">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:25px;">
                            <label for="message" class="col-sm-12 control-label" style="margin-top:15px;">Should junior doctors go on strike? (Maximum of 250 words)</label>
                            <div class="col-sm-10" style="margin-top:7px;">
                                <textarea required="required" class="col-sm-12 form-control" rows="4" name="response" id="response"></textarea>
                            </div>
                        </div>
                        <div id="words-left col-sm-12"></div>
                        <input type="hidden" name="postType" id="postType" value="RESPONSE" >
                        <div class="form-group">
                            <div class="col-md-12" style="margin-top:15px;">
                                <input id="btnResponseDraft" name="draft" type="button" value="Save as Draft" class="btn btn-primary" onclick="return responseDraft();">
                                <input id="btnResponseSubmit" name="submit" type="button" value="Submit" class="btn btn-primary" onclick="return responseSubmit();">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
            <div class="row">
                <?php $i=1; ?>
                @foreach($getresp as $rspns)
                <div class="responses col-md-12 col-xs-12" id="{{$rspns->username}}">
                    <div class="user-info">
                        <img src="{!! url('design/images/avatar.png') !!}" width="45" height="45" align="left">
                        <div class="">
                            <label>{{$rspns->name}}</label><br>
                            <div>{!! date('m/d/Y',strtotime($rspns->created_dt)) !!}</div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="answers col-md-12 col-xs-12">
                            <strong><em>{{$rspns->qstn_to_be_ans}}</em></strong>
                            <p>{{$rspns->description}}</p>
                        </div>
                        <?php
                            $chkfeedbacks=chkfeedbacks($rspns->posts_id);
                        ?>
                        @if(count($chkfeedbacks)==1 && (Session::get('logged')[0]['type']=="TEACHER"||Session::get('logged')[0]['type']=="PUPIL"))
                            <a type="button" data-toggle="collapse" data-target="#feedback-form<?php echo $i; ?>" style="">Feedback</a>
                            <div id="feedback-form<?php echo $i; ?>" class="collapse">
                                <blockquote cite="">
                                    <h4>{{$chkfeedbacks->title}}</h4>
                                    <p>{{$chkfeedbacks->description}}</p>
                                </blockquote>
                            </div>
                        @elseif(Session::get('logged')[0]['type']=="TEACHER" && count($chkfeedbacks)<1)
                            <a type="button" data-toggle="collapse" data-target="#feedback-form<?php echo $i; ?>" style="">Feedback</a>
                        <div id="feedback-form<?php echo $i; ?>" class="collapse">
                            <blockquote cite="">
                                <form class="form-vertical" role="form" method="post" action="index.php">
                                    <input type="hidden" id="token" value="{{ csrf_token() }}" name="_token">
                                    <input type="hidden" name="txtRefId" id="txtRefId" value="{{$rspns->posts_id}}">
                                    <input type="hidden" name="ddlClassId" id="ddlClassId" value="{{$rspns->current_class_code}}">
                                    <input type="hidden" name="ddlCategory" id="ddlCategory" value="{{$rspns->category_id}}">
                                    <div class="form-group" style="margin-top:25px;">
                                        <label for="feedback" class="col-sm-12 control-label" style="margin-top:15px;">Feedback</label>
                                        <div class="col-sm-10" style="margin-top:7px;">
                                            <textarea class="col-sm-12 form-control" rows="4" name="feedback" id="feedback" maxlength="250"></textarea>
                                        </div>
                                    </div>
                                    <div id="words-left col-sm-12"></div>
                                    <input type="hidden" id="postType" name="postType" class="postType" value="FEEDBACK">
                                    <div class="form-group">
                                        <div class="col-md-12" style="margin-top:15px;">
                                            <input id="btnFeedback" name="btnFeedback" type="button" value="Send Feedback" onclick="return createFeedback();" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </blockquote>
                        </div>
                        @endif

                    </div>
                </div>
                        <?php $i++; ?>
                @endforeach
            </div>

            @endforeach
        </div>

    </div>
    <div id="editpopup" class="modal-box">
        @foreach($opinionDtl as $opinion)
        <header> <a href="#" class="js-modal-close close">X</a>
            <h3>Edit Opinion Piece</h3>
        </header>
        <div class="modal-body">
            {{--<div class="row">
                <div class="col-md-12">--}}
                    <form id="frmOpinion" action="{{url('/teacher/assignment/edit')}}" class="opinion-form" method="post">
                        <input type="hidden" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" id="txtPostId" name="txtPostId" value="{{$opinion->id}}">
                        <div class="form-group" style="margin-top:25px;">
                            <label for="class" class="col-sm-12 control-label" style="margin-top:15px;">Class:</label>
                            <div class="col-sm-10" style="margin-top:7px;">
                                <select class="form-control" name="ddlClassId" id="ddlClassId" required="required">
                                    <option>Select Class</option>
                                    @foreach($cls as $class)
                                        <option value="{{$class->short_form}}" @if($opinion->class_code==$class->short_form) {{ 'selected="selected"'}}@endif>{{$class->short_form}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:25px;">
                            <label for="title" class="col-sm-12 control-label" style="margin-top:15px;">Title of Opinion Piece:</label>
                            <div class="col-sm-10" style="margin-top:7px;">
                                <input required="required" type="text" class="col-sm-12 form-control" name="OpinionTitle" id="OpinionTitle" value="{{$opinion->title}}">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:25px;">
                            <label for="opinion" class="col-sm-12 control-label" style="margin-top:15px;">Text of Opinion Piece:</label>
                            <div class="col-sm-10" style="margin-top:7px;">
                                <textarea required="required" id="opinion" class="ckeditor form-control" cols="50" rows="4" name="opinion">{{$opinion->description}}</textarea>
                            </div>
                        </div>
                        <div id="words-left col-sm-12"></div>
                        <!-- <div class="form-group" style="margin-top:25px;">
                            <label for="answer" class="col-sm-12 control-label" style="margin-top:15px;">Image URL:</label>
                            <div class="col-sm-10" style="margin-top:7px;">
                                 <input type="text" class="col-sm-12 form-control" name="" id="">
                            </div>
                        </div> -->
                        <div class="form-group" style="margin-top:25px;">
                            <label for="answer" class="col-sm-12 control-label" style="margin-top:15px;">Category:</label>
                            <div class="col-sm-10" style="margin-top:7px;">
                                <select class="form-control" name="ddlCategory" id="ddlCategory" required="required">
                                    <option>Select Category</option>
                                    <?php
                                    $cats=DB::table('em_category')->select('id','category_title')->get();
                                            ?>
                                    @foreach($cats as $category)
                                        <option value="{{$category->id}}" @if($opinion->category_id==$category->id) {{ 'selected="selected"'}}@endif>{{$category->category_title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top:25px;">
                            <label for="qstn" class="col-sm-12 control-label" style="margin-top:15px;">Question to be answered:</label>
                            <div class="col-sm-10" style="margin-top:7px;">
                                <input required="required" type="text" class="col-sm-12 form-control" name="qstn" id="Qstn" value="{{$opinion->qstn_to_be_ans}}">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:25px;">
                            <div class="col-sm-5" style="margin-top:7px;">
                                <input required="required" type="text" class="col-sm-3 form-control" name="txtAvailDt" id="txtAvailDt" placeholder="Date Set" value="{!! date('m/d/Y',strtotime($opinion->avail_dt)) !!}">
                            </div>
                            <div class="col-sm-5" style="margin-top:7px;">
                                <input required="required" type="text" class="col-sm-3 form-control" name="txtDeadlineDt" id="txtDeadlineDt" value="{!! date('m/d/Y',strtotime($opinion->deadline_dt)) !!}" placeholder="Deadline">
                            </div>
                        </div>
                        <input type="hidden" name="postType" id="postType" value="OPINION" >
                        <div class="form-group">
                            <div class="col-md-12" style="margin-top:15px;">
                                {{--<button name="btnSubmit" type="submit" class="btn btn-primary" id="btnSubmit">Save Opinion Piece</button>--}}
                                <input id="btnSubmit" name="btnSubmit" type="submit" value="Save Opinion Piece" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                {{--</div>
            </div>--}}
        </div>
        <footer> <a href="#" class="btn btn-small js-modal-close">Close</a> </footer>
            @endforeach
    </div>
</section>
    @endsection
@section('js')
    <script type="text/javascript">


        //$(document).ready(function () {
            function responseSubmit() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{url('/response/create')}}",
                    type: "POST",
                    dataType: "json", //expect json value from server
                    data: {'_token':$('input[name=_token]').val(),'RefId':$("#txtRefId").val(),'ClassId':$("#ddlClassId").val(),'Category':$("#ddlCategory").val(),'answer':$("#answer").val(),'response':$("#response").val(),'postType':$("#postType").val()},
                    success: function (data) {
                        alert(data.msg);
                        window.location.href="{!! url('/home') !!}";
                    },
                    error:function(data){
                        alert('Could not save response')
                    }
                });
            }
        function responseDraft() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{url('/response/draft/create')}}",
                type: "POST",
                dataType: "json", //expect json value from server
                data: {'_token':$('input[name=_token]').val(),'RefId':$("#txtRefId").val(),'ClassId':$("#ddlClassId").val(),'Category':$("#ddlCategory").val(),'answer':$("#answer").val(),'response':$("#response").val(),'postType':$("#postType").val()},
                success: function (data) {
                    alert(data.msg);
                    window.location.href="{!! url('/home') !!}";
                },
                error:function(data){
                    alert('Could not save response')
                }
            });
        }
        function createFeedback() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{url('/feedback/create')}}",
                type: "POST",
                dataType: "json", //expect json value from server
                data: {'_token':$('input[name=_token]').val(),'RefId':$("#txtRefId").val(),'ClassId':$("#ddlClassId").val(),'Category':$("#ddlCategory").val(),'feedback':$("#feedback").val(),'postType':$("#postType").val()},
                success: function (data) {
                    alert(data.msg);
                    window.location.href="{!! url('/home') !!}";
                },
                error:function(data){
                    alert('Could not save response')
                }
            });
        }
        //});
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $(".opinion-form1").submit(function (e) {
                for ( instance in CKEDITOR.instances )
                    CKEDITOR.instances[instance].updateElement();
                var form_data = $(this).serialize();
                //console.log(form_data);
                $.ajax({
                    url: "{{url('/teacher/assignment/edit')}}",
                    type: "POST",
                    dataType: "json", //expect json value from server
                    data: form_data,
                    success: function (data) {
                        alert(data.msg);
                        window.location.href="{!! url('/home') !!}";
                    },
                    error:function(data){

                    }
                });
                console.log(form_data);
            });
        });
    </script>
    <script>
        $(function(){

            var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

            $('a[data-modal-id]').click(function(e) {
                e.preventDefault();
                $("body").append(appendthis);
                $(".modal-overlay").fadeTo(500, 0.7);
                //$(".js-modalbox").fadeIn(500);
                var modalBox = $(this).attr('data-modal-id');
                $('#'+modalBox).fadeIn($(this).data());
            });


            $(".js-modal-close, .modal-overlay").click(function() {
                $(".modal-box, .modal-overlay").fadeOut(500, function() {
                    $(".modal-overlay").remove();
                });

            });

            $(window).resize(function() {
                $(".modal-box").css({
                    top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
                    left: ($(window).width() - $(".modal-box").outerWidth()) / 2
                });
            });

            $(window).resize();

        });
    </script>
    <script type="text/javascript">
        CKEDITOR.replace( 'editor1' );
        /*CKEDITOR.replace( 'editor1', {
            extraPlugins:'imageuploader'
        });*/
    </script>

@endsection