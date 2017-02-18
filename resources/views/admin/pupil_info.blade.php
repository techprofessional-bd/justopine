@extends('home')
@section('master')
    <section class="container-fluid">
        <div class="row" id="breadcrumb">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>Add Pupil Information</h2>
                <hr>
            </div>
        </div>
        <div class="row main">
            <div class="col-md-3 col-xs-12" style="margin-top:10px; background-color:#fff;">
                <h4>What to do?</h4>
                <ul>
                    <li><a href="{{url('/admin/pupil')}}">Pupils</a></li>
                    <li><a href="{{url('/admin/pupil/new')}}">Add Pupil Info</a></li>
                </ul>
            </div>
            <div class="col-md-8 col-xs-12" style="background-color:#fff; margin-left:10px; ">
                <div class="col-md-12 col-xs-12" style="padding-top:20px;">
                    <div class="container-fluid">
                        <form action="{{url('/admin/pupil/new')}}" method="post" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="txtFirstName" class="control-label col-sm-2">First Name</label>
                                <div class="col-sm-10"><input type="text" name="txtFirstName" id="txtFirstName" class="form-control" placeholder="First Name"></div>
                            </div>
                            <div class="form-group">
                                <label for="txtLastName" class="control-label col-sm-2">Last Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="txtLastName"  id="txtLastName" class="form-control" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ddlClass" class="control-label col-sm-2">Current Class</label>
                                <div class="col-sm-10">
                                    <select name="ddlClass"  id="ddlClass" class="form-control">
                                        <option>Select Class</option>
                                        @foreach($cls as $class)
                                            <option value="{{$class->short_form}}">{{$class->short_form}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{--<div class="form-group">
                                <label for="txtStudentId" class="control-label col-sm-2">Student Id</label>
                                <div class="col-sm-10">
                                    <input type="text" name="txtStudentId" id="txtStudentId" class="form-control" placeholder="Student Id">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtSocialId" class="control-label col-sm-2">Social Id</label>
                                <div class="col-sm-10"><input type="text" name="txtSocialId"  id="txtSocialId" class="form-control" placeholder="Social Id"></div>
                            </div>--}}
                            <div class="form-group">
                                <label for="txtEmail" class="control-label col-sm-2">Email</label>
                                <div class="col-sm-10"><input type="email" name="txtEmail"  id="txtEmail" class="form-control" placeholder="Email"></div>
                            </div>
                            <div class="form-group">
                                <label for="txtUsername" class="control-label col-sm-2">Username</label>
                                <div class="col-sm-10"><input type="text" name="txtUsername"  id="txtUsername" class="form-control" placeholder="Username" onchange="return chkUsername(this.value)"><div class="chkNotice"></div></div>
                            </div>
                            <div class="form-group">
                                <label for="txtPassword" class="control-label col-sm-2">Password</label>
                                <div class="col-sm-10"><input type="password" name="txtPassword"  id="txtPassword" class="form-control" placeholder="*******"></div>
                            </div>
                            <div class="col-sm-12" align="right"><input type="submit" name="btnSubmit" value="Save Pupil" class="btn btn-primary"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('js')
    <script>
        function chkUsername(str){
            $.get("{{url('/admin/user/chk')}}",{"UserName":str},function(data){
                if(data.status=="YES"){
                    $("#txtUsername").focus();
                    $(".chkNotice").html('<i style="color:red">'+data.msg+'</i>');
                }
                else{
                    $(".chkNotice").html('<i style="color:GREEN">'+data.msg+'</i>');
                }
            });
        }
    </script>
@endsection
