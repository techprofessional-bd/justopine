@extends('home')
@section('title')
    {{"Assigned Class for Teacher"}}
@endsection
@section('master')
    <section class="container-fluid">
        <div class="row" id="breadcrumb">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>Classes</h2>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <?php
                        $i=1;
                    ?>
                    @foreach($tdt as $t)
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <a href="#" class="panel-title" data-toggle="collapse" data-target="#feedback-form<?php echo $i;?>">Class - {{$t->class_code}}</a>
                                <?php $stdlist=getStdList($t->class_code); ?>
                                <div style="float:right;">Total Students: <?php echo count($stdlist); ?></div>
                            </div>


                            <div class="collapse" id="feedback-form<?php echo $i;?>">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Surname</th>
                                        <th>First Name</th>
                                        <th>Username</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($stdlist as $clsStd)
                                        <tr>
                                            <th scope="row">{{$clsStd->id}}</th>
                                            <td>{{$clsStd->l_name}}</td>
                                            <td>{{$clsStd->f_name}}</td>
                                            <td>{{$clsStd->username}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                        <?php $i++; ?>
                    @endforeach
{{--                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Class - 9E4</h3>
                                <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
                            </div>
                            <div class="panel-body">Panel content</div>
                        </div>
                    </div>--}}
                </div>
            </div>

        </div>

    </section>
@endsection
@section('js')

    @endsection