@extends('home')
@section('master')
    <section class="container-fluid">
        <div class="row" id="breadcrumb">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>Modify Teachers Information</h2>
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
                        @foreach($dataList as $dt)
                        <form action="{{url('/admin/teacher/edit')}}" method="post">
                            <input type="hidden" name="txtTeachersId" id="txtTeachersId" value="{{$dt->id}}">
                            <div class="form-group">
                                <label for="txtFirstName" class="col-sm-2">First Name</label>
                                <input type="text" name="txtFirstName" id="txtFirstName" class="form-control col-sm-6" placeholder="First Name" value="{{$dt->f_name}}">
                            </div>
                            <div class="form-group">
                                <label for="txtLastName" class="col-sm-2">Last Name</label>
                                <input type="text" name="txtLastName"  id="txtLastName" class="form-control col-sm-6" placeholder="Last Name" value="{{$dt->l_name}}">
                            </div>
                            <div class="form-group">
                                <label for="ddlDesignation" class="col-sm-2">Designation</label>
                                <select name="ddlDesignation"  id="ddlDesignation" class="form-control col-sm-6">
                                    <option>Select Designation</option>
                                    @foreach($desig as $ds)
                                        <option value="{{$ds->short_code}}" @if($dt->designation==$ds->short_code) {{'selected="selected"'}} @endif>{{$ds->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="txtEmail" class="col-sm-2">Email</label>
                                <input type="email" name="txtEmail"  id="txtEmail" class="form-control col-sm-10" placeholder="Email" value="{{$dt->email}}">
                            </div>
                            <div class="form-group">
                                <label for="txtUsername" class="col-sm-2">User Name</label>
                                <input type="hidden" name="txtUsername"  id="txtUsername" class="form-control col-sm-10" placeholder="Username" value="{{$dt->username}}">
                                <input type="text" class="form-control col-sm-10" placeholder="Username" value="{{$dt->username}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="txtPassword" class="col-sm-2">User Password</label>
                                <input type="password" name="txtPassword"  id="txtPassword" class="form-control col-sm-10" placeholder="*******">
                            </div>
                            <div class="form-group">
                                <label for="ddlSts" class="col-sm-2">User Status</label>
                                <select name="ddlSts" id="ddlSts" class="form-control">
                                    <option value="A" @if($dt->user_sts=="A") {{'selected="selected"'}}@endif>Active</option>
                                    <option value="U" @if($dt->user_sts=="U") {{'selected="selected"'}}@endif>Inactive</option>
                                </select>
                            </div>
                            <input type="submit" name="btnSubmit" value="Save Teachers" class="btn btn-primary form-control">
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
