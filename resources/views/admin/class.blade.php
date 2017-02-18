@extends('home')
@section('title')
    {{"Class"}}
@endsection
@section('master')
    <section class="container-fluid">
        <div class="row" id="breadcrumb">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>Class Lists</h2>
                <hr>
            </div>
        </div>
        <div class="row main">
            <div class="col-md-3 col-xs-12" style="margin-top:10px; background-color:#fff;">
                <h4>What to do?</h4>
                <ul>
                    <li><a href="{{url('/admin/class/new')}}">Create Class</a></li>
                </ul>
            </div>
            <div class="col-md-9 col-xs-12">
                <div class="col-md-12 col-xs-12">
                    <div class="box-body">
                        <table class="table table-responsive table-bordered">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Class Code</th>
                                <th>Modify</th>
                            </tr>
                            @foreach($dataList as $data)
                                <tr>
                                    <td>{!! $data->id!!}</td>
                                    <td>{!! $data->short_form !!}</td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="col-md-6 text-right">
                                                <a href="{!!url('/admin/class/edit/'.$data->id)!!}"><button class="btn btn-primary">Edit</button></a></div>
                                            <div class="col-md-6 text-left">
                                                <form class="delete" method="POST" action="{{url('/admin/class/delete')}}">
                                                    <input name="txtClassId" type="hidden" value="{{$data->id}}">
                                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-danger" value="Delete">Delete</button>
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
    <script>
        function ClassDelete() {
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
    </script>
@endsection
