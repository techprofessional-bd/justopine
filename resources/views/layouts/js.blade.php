<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/core.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{!! URL::asset('design/js/bootstrap.js')!!}" type="text/javascript" charset="utf-8" async defer></script>
<script src="{!! URL::asset('design/js/bootstrap.min.js')!!}" type="text/javascript" charset="utf-8" async defer></script>
<script src="{!! URL::asset('design/editor/ckeditor/ckeditor.js')!!}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function(){
        var avail_date=$('input[name="txtAvailDt"]'); //our date input has the name "date"
        var deadline_date=$('input[name="txtDeadlineDt"]');
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
