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
                        <form action="{{url('/admin/teacher/new')}}" method="post">
                            <div class="form-group">
                                <label for="txtFirstName" class="col-sm-2">First Name</label>
                                <input type="text" name="txtFirstName" id="txtFirstName" class="form-control col-sm-6" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label for="txtLastName" class="col-sm-2">Last Name</label>
                                <input type="text" name="txtLastName"  id="txtLastName" class="form-control col-sm-6" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <label for="ddlDesignation" class="col-sm-2">Designation</label>
                                <select name="ddlDesignation"  id="ddlDesignation" class="form-control col-sm-6">
                                    <option>Select Designation</option>
                                    @foreach($desig as $ds)
                                        <option value="{{$ds->short_code}}">{{$ds->title}}</option>
                                        @endforeach
                                </select>
                            </div>
                            {{--<div class="form-group">
                                <label for="ddlSubjects" class="col-sm-2">Subjects</label>
                                <select name="ddlSubjects"  id="ddlSubjects" class="form-control col-sm-6">
                                    <option>Select Subject</option>
                                    @foreach($subjects as $sub)
                                        <option value="{{$sub->shrot_code}}">{{$sub->subject_title}}</option>
                                    @endforeach
                                </select>
                            </div>--}}
                            <div class="form-group">
                                <label for="txtEmail" class="col-sm-2">Email</label>
                                <input type="email" name="txtEmail"  id="txtEmail" class="form-control col-sm-10" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="txtUsername" class="col-sm-2">User Name</label>
                                <input type="text" name="txtUsername"  id="txtUsername" class="form-control" placeholder="Username" onchange="return chkUsername(this.value)"><div class="chkNotice"></div>
                            </div>
                            <div class="form-group">
                                <label for="txtPassword" class="col-sm-2">User Password</label>
                                <input type="password" name="txtPassword"  id="txtPassword" class="form-control col-sm-10" placeholder="*******">
                            </div>
                            <input type="submit" name="btnSubmit" value="Save Teachers" class="btn btn-primary form-control">
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
    </script>
@endsection
