<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        @include('layouts.head')
    </head>
    <body style="background: url('{!! URL::asset('images/bg.jpg') !!}') no-repeat center;">
    <div class="bg-log">
        <div class="container">
            <div class="row">
                <div class="Absolute-Center is-Responsive">
                    <div id="logo-container">
                        <img src="{!! URL::asset('images/logo.png') !!}" width="100%">
                    </div>
                    <div class="sign-in-msg">
                        <p>A space to express your opinion</p>
                    </div>
                    <div class="sign-in-box">
                        <a href="#" id="btnPreSign" class="btn btn-primary btn-lg">Sign In</a>
                    </div>
                    <div class="col-sm-12 col-md-10 col-md-offset-1" id="frmLogin"></div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.js')
    <script>
        $("#btnPreSign").on("click",function(e){
            $("a#btnPreSign").slideToggle("slow");
            $(".sign-in-msg p").html('<h4>Enter your username and password to log in.</h4>')
            $("#frmLogin").append('<form action="" id="loginForm"><div class="form-group input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input class="form-control" type="text" name="username" placeholder="username"/></div><div class="form-group input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span><input class="form-control" type="password" name="password" placeholder="password"/></div><div class="form-group"><button type="button" class="btn btn-def btn-block">Login</button></div></form>');
        })
    </script>
    </body>
</html>