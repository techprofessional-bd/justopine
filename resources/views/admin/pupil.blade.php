@extends('home')
@section('master')
    <section class="container-fluid">
        <div class="row" id="breadcrumb">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>Pupil Lists</h2>
                <hr>
            </div>
        </div>
        <div class="row main">
            <div class="col-md-3 col-xs-12" style="margin-top:10px; background-color:#fff;">
                <h4>What to do?</h4>
                <ul>
                    <li><a href="{{url('/admin/pupil/new')}}">Add Pupil</a></li>
   {{--                 <li><a href="{{url('/admin/pupil/assign/class')}}">Assign Class</a></li>--}}
                </ul>
            </div>
            <div class="col-md-9 col-xs-12">
                <div class="col-md-12 col-xs-12">
                    <div class="box-body">
                        <table class="table table-responsive table-bordered">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Current Class</th>
                                <th>Username</th>
                                <th>Modify</th>
                            </tr>
                            @foreach($dataList as $data)
                                <tr>
                                    <td>{!! $data->id!!}</td>
                                    <td>{!! $data->f_name.' '.$data->l_name !!}</td>
                                    <td>{!! $data->current_class_code !!}</td>
                                    <td>{!! $data->username !!}</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="col-md-6 text-right">
                                                <a href="{!!url('/admin/pupil/edit/'.$data->id)!!}"><button class="btn btn-primary">Edit</button></a></div>
                                            <div class="col-md-6 text-left">
                                                <form class="delete" method="POST" action="{{url('/admin/pupil/delete')}}">
                                                    <input name="txtUsername" type="hidden" value="{{$data->username}}">
                                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-danger" value="Delete"  >Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('js')

@endsection
