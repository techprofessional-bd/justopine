<h3>Latest Activities</h3>
@foreach($dt as $act)
<div class="row">
    <div class="col-sm-6 col-xs-12">
        {{$act->title}}
    </div>
    <div class="col-sm-6 col-xs-12">
        <?php
            $c=getStdList($act->class_code);
            $resp=getResponses($act->id);
        ?>
        <a href="#"><meter value="<?php echo count($resp); ?>" min="0" max="<?php echo count($c); ?>">2 out of 10</meter></a>
    </div>
</div>
@endforeach
