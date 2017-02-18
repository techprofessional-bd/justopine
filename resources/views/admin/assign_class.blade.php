@extends('home')
@section('master')
    <section class="container-fluid">
        <div class="row" id="breadcrumb">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>Add Teachers Information</h2>
                <hr>
            </div>
        </div>
        <div class="row main">
            <div class="col-md-3 col-xs-12" style="margin-top:10px; background-color:#fff;">
                <h4>What to do?</h4>
                <ul>
                    <li><a href="{{url('/admin/teachers')}}">Teachers' List</a></li>
                    <li><a href="{{url('/admin/teacher/assign/class')}}">Assign Class</a></li>
                </ul>
            </div>
            <div class="col-md-8 col-xs-12" style="background-color:#fff; margin-left:10px; ">
                <div class="col-md-12 col-xs-12">
                    <div class="box-body">
                        <form action="{{url('/admin/teacher/assign/class')}}" method="post">
                            <div class="form-group">
                                <label for="ddlTeachers" class="col-sm-2">Teacher</label>
                                <select class="form-control" id="ddlTeachers" name="ddlTeachers">
                                    <option>Select Teacher</option>
                                    @foreach($teacherdt as $tdt)
                                        <option value="{{$tdt->id}}">{{$tdt->f_name.' '.$tdt->l_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                @foreach($clsdt as $cdt)
                                <label><input type="checkbox" name="chkClasses[]"  id="chkClasses" value="{{$cdt->short_form}}">{{$cdt->short_form}} </label>
                                    @endforeach
                            </div>
                            <div class="form-group">
                                <label for="txtStartDt">Session Start</label>
                                <input type="text" name="txtStartDt" id="txtStartDt" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="txtEndDt">Session End</label>
                                <input type="text" name="txtEndDt" id="txtEndDt" class="form-control">
                            </div>
                            <input type="submit" name="btnSubmit" value="Assign Class" class="btn btn-primary form-control">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            var avail_date=$('input[name="txtStartDt"]'); //our date input has the name "date"
            var deadline_date=$('input[name="txtEndDt"]');
            var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
            avail_date.datepicker({
                format: 'mm/dd/yyyy',
                container: container,
                todayHighlight: true,
                autoclose: true,
            })
            deadline_date.datepicker({
                format: 'mm/dd/yyyy',
                container: container,
                todayHighlight: true,
                autoclose: true,
            })
        })
    </script>
@endsection
