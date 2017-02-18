@extends('home')
@section('title')
    {{"Create Assignment - JustOpine"}}
@endsection
@section('master')
<section class="container-fluid">
    <div class="row" id="breadcrumb">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h2>Assign an Opinion Piece</h2>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-xs-12">

                <h3>Latest Activities</h3>
                <?php $i=1; ?>
                @if(count($dt)>0)
                    @foreach($dt as $act)
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                {{$act->class_code}}{{"-"}}{{$act->title}}
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <?php
                                $c=getStdList($act->class_code);
                                $resp=getResponses($act->id);
                                ?>
                                <a href="#" class="js-open-modal" data-modal-id="popup<?php echo $i; ?>"><meter value="<?php echo count($resp); ?>" min="0" max="<?php echo count($c); ?>">2 out of 10</meter></a>
                            </div>
                        </div>
                        <?php $i++; ?>
                    @endforeach
                @endif
        </div>
        <div class="col-md-9 col-xs-12">
            <div class="col-md-12 col-xs-12">
                <div class="assignment-form-div container-fluid">
                    <div class="alert"></div>
                    <form id="frmOpinion" action="{{url('/teacher/assignment/new')}}" class="opinion-form" method="post">
                        <input type="hidden" id="token" value="{{ csrf_token() }}">
                        <div class="form-group" style="margin-top:25px;">
                            <label for="class" class="col-sm-12 control-label" style="margin-top:15px;">Class:</label>
                            <div class="col-sm-10" style="margin-top:7px;">
                                <select class="form-control" name="ddlClassId" id="ddlClassId" required="required">
                                    <option>Select Class</option>
                                    @foreach($cls as $class)
                                    <option value="{{$class->class_code}}">{{$class->class_code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:25px;">
                            <label for="title" class="col-sm-12 control-label" style="margin-top:15px;">Title of Opinion Piece:</label>
                            <div class="col-sm-10" style="margin-top:7px;">
                                <input type="text" class="col-sm-12 form-control" name="OpinionTitle" id="OpinionTitle" required="required">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:25px;">
                            <label for="opinion" class="col-sm-12 control-label" style="margin-top:15px;">Text of Opinion Piece:</label>
                            <div class="col-sm-10" style="margin-top:7px;">
                                <textarea id="opinion" class="ckeditor form-control" cols="50" rows="4" name="opinion" required="required"></textarea>
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
                                    @foreach($cat as $category)
                                    <option value="{{$category->id}}">{{$category->category_title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top:25px;">
                            <label for="qstn" class="col-sm-12 control-label" style="margin-top:15px;">Question to be answered:</label>
                            <div class="col-sm-10" style="margin-top:7px;">
                                <input type="text" class="col-sm-12 form-control" name="qstn" id="Qstn" required="required">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:25px;">
                            <div class="col-sm-5" style="margin-top:7px;">
                                <input type="text" class="col-sm-3 form-control" name="txtAvailDt" id="txtAvailDt" placeholder="Date Set" required="required">
                            </div>
                            <div class="col-sm-5" style="margin-top:7px;">
                                <input type="text" class="col-sm-3 form-control" name="txtDeadlineDt" id="txtDeadlineDt" placeholder="Deadline" required="required">
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
                </div>
            </div>
        </div>

    </div>
    <?php $i=1; ?>
    @if(Session::get('logged')[0]['type']=="TEACHER")
        @foreach($dt as $act)
            <div id="popup<?php echo $i; ?>" class="modal-box">
                <header> <a href="#" class="js-modal-close close">X</a>
                    <h3>Class Submission</h3>
                </header>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>{{$act->class_code}} - {{$act->title}} Due: {!! date('m/d/Y',strtotime($act->deadline_dt)) !!}</h4>
                            <div class="col-md-1 col-xs-12">
                                &nbsp;
                            </div>
                            <div class="col-md-11 col-xs-12">
                                <div class="container">
                                    <h4>Pupils Submitted</h4>
                                    <p>
                                        <?php
                                        $getresp=DB::select(DB::Raw('select em_postmeta.ref_id, em_postmeta.posts_id, em_posts.created_user, em_students.username,em_students.current_class_code, concat(em_students.f_name," ",em_students.l_name)name from em_postmeta inner JOIN em_posts on em_posts.id=em_postmeta.posts_id inner join em_users on em_users.id=em_posts.created_user inner join em_students on em_students.username=em_users.username where em_postmeta.ref_id='.$act->id.' and em_students.current_class_code='.$act->class_code));
                                        ?>
                                        @if(count($getresp)>0)
                                            @foreach($getresp as $resp)
                                                <a href="">{{$resp->name}}</a>
                                            @endforeach
                                        @else
                                            {{"No One has Send Response"}}
                                        @endif
                                    </p>
                                </div>
                                <div class="container">
                                    <h4>Pupils Unsubmitted</h4>
                                    <p>
                                    <?php
                                    $getnonresp=DB::select(DB::Raw('select concat(em_students.f_name," ",em_students.l_name)name, em_students.username from em_students where em_students.current_class_code='.$act->class_code.' and em_students.username NOT IN (select em_users.username from em_users INNER JOIN em_posts on em_posts.created_user=em_users.id INNER join em_postmeta on em_postmeta.posts_id=em_posts.id where em_postmeta.ref_id='.$act->id.')'));

                                    ?>
                                    <ul>
                                        @if(count($getnonresp)>0)
                                            @foreach($getnonresp as $nonresp)
                                                <li><a href="" style="text-decoration:underline;">{{$nonresp->name}}</a></li>
                                            @endforeach
                                        @else
                                            {{"No One is left to send response"}}
                                        @endif
                                    </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer> <a href="#" class="btn btn-small js-modal-close">Close</a> </footer>
            </div>
            <?php $i++; ?>
        @endforeach
    @endif
</section>
@endsection
@section('js')
    <script type="text/javascript">
        CKEDITOR.replace( 'opinion' );
        /* CKEDITOR.replace( 'opinion', {
         extraPlugins:'imageuploader'
         });*/
    </script>
    <script type="text/javascript">
        /*$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $(".opinion-form").submit(function (e) {
                for ( instance in CKEDITOR.instances )
                    CKEDITOR.instances[instance].updateElement();
                var form_data = $(this).serialize();
                //console.log(form_data);
                $.ajax({//make ajax request to cart_process.php
                    url: "{{url('/teacher/assignment/new')}}",
                    type: "POST",
                    dataType: "json", //expect json value from server
                    data: form_data,
                    success: function (data) {
                        alert(data.msg);
                        window.location.href="{!! url('/dashboard') !!}";
                    },
                    error:function(data){

                    }
                });
                console.log(form_data);
            });
        });*/
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

@endsection