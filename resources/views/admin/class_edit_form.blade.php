@extends('home')
@section('master')
    <section class="container-fluid">
        <div class="row" id="breadcrumb">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>Class Modify</h2>
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
                        @foreach($cls as $class)
                        <form action="{{url('admin/class/edit/')}}" method="post">
                            <div class="form-group">
                                <label for="title">Class Code</label>
                                <input type="hidden" name="txtClassId" value="{{$class->id}}">
                                <input type="text" name="txtClassCode" class="form-control" value="{{$class->short_form}}">
                            </div>
                            <input type="submit" name="btnSubmit" value="Update Class" class="btn btn-primary">
                        </form>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('js')

@endsection
