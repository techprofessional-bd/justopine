<h4>Previous Opinion Pieces</h4>
<div class="container-fluid">
    <div class="right-Bar">
        @foreach($tdt as $tchrCls)
        <a href="{{url('/archive/class/'.$tchrCls->class_code)}}">{{$tchrCls->class_code}}</a>
            @endforeach
    </div>
</div>