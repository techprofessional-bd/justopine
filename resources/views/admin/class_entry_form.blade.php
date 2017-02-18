@extends('home')
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
                    <li><a href="{{url('/admin/class')}}">Class Lists</a></li>
                </ul>
            </div>
            <div class="col-md-9 col-xs-12">
                <div class="col-md-12 col-xs-12">
                    <div class="box-body">
                        <form action="{{url('admin/class/new')}}" method="post">
                            <div class="form-group">
                                <label for="title">Class Code</label>
                                <input type="text" name="txtClassCode" class="form-control" placeholder="8E2">
                            </div>
                            <input type="submit" name="btnSubmit" value="Save Class" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('js')

@endsection
