@extends('home')
@section('title')
    {{"Subjects Info"}}
    @endsection
@section('master')
    <section class="container-fluid">
        <div class="row" id="breadcrumb">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>Subjects</h2>
                <hr>
            </div>
        </div>
        <div class="row main">
            <div class="col-md-3 col-xs-12" style="margin-top:10px; background-color:#fff;">
                <h4>What to do?</h4>
                <ul>
                    <li><a href="{{url('/admin/subjects')}}">Subjects</a></li>
                </ul>
            </div>
            <div class="col-md-9 col-xs-12">
                <div class="col-md-12 col-xs-12">
                    <div class="box-body">
                        <form action="{{url('admin/subjects/new')}}" method="post" class="form-horizontal">
                            <div class="form-group">
                                <label for="txtSubjectTitle" class="control-label col-sm-2">Subject Title</label>
                                <div class="col-sm-10"><input type="text" name="txtSubjectTitle" id="txtSubjectTitle" class="form-control" placeholder="English"></div>
                            </div>
                            <div class="form-group">
                                <label for="txtSubjectCode" class="control-label col-sm-2">Subject Code</label>
                                <div class="col-sm-10"><input type="text" name="txtSubjectCode" class="form-control" placeholder="EN" id="txtSubjectCode"></div>
                            </div>
                            <input type="submit" name="btnSubmit" value="Save Subjects" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('js')

@endsection
