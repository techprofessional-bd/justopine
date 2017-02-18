@extends('home')
@section('master')
    <section class="container-fluid">
        <div class="row" id="breadcrumb">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h2>{{Session::get('logged')[0]['name']}}</h2>
                <hr>
            </div>
        </div>
        <div class="row main">
            <div class="col-md-3 col-xs-12" style="margin-top:10px; background-color:#fff;">
                <h4>Welcome Admin</h4>
            </div>
            <div class="col-md-9 col-xs-12">
                <div class="col-md-12 col-xs-12">

                </div>
            </div>
        </div>

    </section>
@endsection
@section('js')
    <script>
        $(function(){

            var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

            $('a[data-modal-id]').click(function(e) {
                e.preventDefault();
                $("body").append(appendthis);
                $(".modal-overlay").fadeTo(500, 0.7);
                //$(".js-modalbox").fadeIn(500);
                var modalBox = $(this).attr('data-modal-id');
                $('#'+modalBox).fadeIn($(this).data());
            });


            $(".js-modal-close, .modal-overlay").click(function() {
                $(".modal-box, .modal-overlay").fadeOut(500, function() {
                    $(".modal-overlay").remove();
                });

            });

            $(window).resize(function() {
                $(".modal-box").css({
                    top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
                    left: ($(window).width() - $(".modal-box").outerWidth()) / 2
                });
            });

            $(window).resize();

        });
    </script>
@endsection
