<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0"/>
        <title>JustOpine</title>
        <link rel="stylesheet" href="{!! URL::asset('design/stylesheet/landing.css') !!}">
        <link href="http://fonts.googleapis.com/css?family=Roboto:400,700,400italic,700italic" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//code.jquery.com/qunit/qunit-1.18.0.css">
        <link rel='shortcut icon' href="{!! URL::asset('design/images/favicon.ico') !!}" type='image/x-icon'/ >
    </head>
    <body>

    <div class="landing-top">
        <div class="landing-container">
            <form class="landing-container-secondview" action="{{ url('/login') }}" method="POST" autocomplete="off">
                {!! csrf_field() !!}
                <img class="back-icon landing-back-icon" src="{!! url('design/images/back.png') !!}">
                <h3>Enter your username and password to log in.</h3>
                    <span class="input-container">
                        <p>Username:</p>
                        <input type="text" name="txtUserName" class="sign-in-input">
                    </span>
                    <span class="input-container">
                        <p>Password:</p>
                        <input type="password" name="txtPassword" class="sign-in-input">
                    </span>
                <input type="submit" class="sign-in-submit" value="SUBMIT">
            </form>
            <div class="landing-container-firstview">
                <img class="landing-logo" src="{!! url('design/images/logo.png') !!}">
                <h2 class="tag-line">A space to express your opinions.</h2>
                <button class="sign-in">SIGN IN</button>
            </div>
        </div>
    </div>
    <div class="landing-info">
        <p>JustOpine is a web application for schools that allows pupils to discuss various topics, moderated by their teachers. Here, pupils are afforded the opportunity to ask questions independently to enable them to interrogate, contest and have a response to what they read.</p>
        <p>The vision of JustOpine is to broaden the cultural reference point of all pupils, irrespective of socioeconomic background, through providing them with accessible, high quality information in the form of a supplementary educational tool.</p>
    </div>


    @include('layouts.js')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="{!! URL::asset('design/js/script.js') !!}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#btnPreSign").on("click",function(e){
            $("a#btnPreSign").slideToggle("slow");
            $(".sign-in-msg p").html('<h4>Enter your username and password to log in.</h4>')
            $("#frmLogin form").css('display','block');
        })
    </script>
    </body>
</html>