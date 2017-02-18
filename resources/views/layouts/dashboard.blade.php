@extends('home')
@section('title')
    {{"Home"}}
@endsection
@section('master')
    <section class="container-fluid">
        <div class="row" id="breadcrumb">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>My Assignment</h2>
                <hr>
            </div>
        </div>
        <div class="row main">
            <div class="col-md-3 col-xs-12" style="margin-top:10px; background-color:#fff;">
                @if(Session::get('logged')[0]['type']=="TEACHER")
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
                    @elseif(Session::get('logged')[0]['type']=="PUPIL")
                        <div class="row">
                            <h3>Current Opinion Piece</h3>
                            @foreach($curpiece as $cpc)
                                <div><strong><em>{{$cpc->title}}</em></strong></div>
                                <div>{{"Date Set:- "}}{!! date('m/d/Y',strtotime($cpc->avail_dt)) !!}</div>
                                <div>{{"Deadline:- "}}{!! date('m/d/Y',strtotime($cpc->deadline_dt)) !!}</div>
                            @endforeach
                        </div>
                    <div class="row">
                        <h3>Current Teacher Feedback</h3>
                        <div style="border:1px solid">
                            <?php $fbk=chkCurFeedback(Session::get('logged')[0]['id']); ?>
                            @if(count($fbk)>0)
                            {{$fbk->description}}
                                @endif
                        </div>
                    </div>
                @endif
            </div>
            <?php         ?>
            <div class="<?php if(Session::get('logged')[0]['type']=="TEACHER") echo "col-md-6"; else echo "col-md-9";?> col-xs-12">
                <div class="col-md-12 col-xs-12">
                    @if(count($data)>0)
                    @foreach($data as $dr)
                        <div class="assignment-feed row">
                            <div class="container-fluid" style="background-color:#fff">
                                {{--<div class="col-md-3">
                                    <img src="{!! url('design/images/1158.jpg') !!}" width="140" height="130">
                                </div>--}}
                                <div class="col-md-12">
                                    <h4><a href="{!! url('/assignment/class/'.$dr->class_code.'/post/'.$dr->id) !!}" style="color:#265a88">{{$dr->class_code.' - '}}{{$dr->title}}</a></h4>
                                    {!! substr($dr->description,0,250) !!}
                                    <p>Date:<time datetime="{{$dr->avail_dt}}">{{$dr->avail_dt}}</time> Deadline:<time datetime="{{$dr->deadline_dt}}">{{$dr->deadline_dt}}</time></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                        @endif
                </div>
            </div>
            @if(Session::get('logged')[0]['type']=="TEACHER")
            <div class="col-md-3 col-xs-12" style="margin-top:10px; background-color:#fff;">


                    <h4>Archives</h4>
                <div class="right-Bar">
                    @foreach($tdt as $tchrCls)
                        <a href="{{url('/archive/class/'.$tchrCls->class_code)}}">{{$tchrCls->class_code}}</a>
                    @endforeach
                </div>

            </div>
            @endif
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
