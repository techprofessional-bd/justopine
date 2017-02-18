@foreach($dt as $dr)
<div class="assignment-feed row">
    <div class="container-fluid">
        <div class="col-md-3">
            <img src="images/1158.jpg" width="140" height="130">
        </div>
        <div class="col-md-9">
            <h4><a href="{!! url('/assignment/class/'.$dr->class_code.'/post/'.$dr->id) !!}">{{$dr->title}}</a></h4>
            <p>{{$dr->description}}</p>
            <p>Date:<time datetime="2017-02-14">2017-02-14</time> Deadline:<time datetime="2017-02-14">2017-02-14</time></p>
        </div>
    </div>
</div>
@endforeach
