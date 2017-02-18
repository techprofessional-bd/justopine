<?php
/**
 * Created by PhpStorm.
 * User: SM
 * Date: 9/2/2016
 * Time: 11:49 PM
 */


function getStdList($code){
    $stdlist=DB::table('em_students')
        ->where('current_class_code','=',$code)
        ->select()
        ->get();
    return $stdlist;
}
function getResponses($pid){
    $resp=DB::table('em_postmeta')
        ->where('em_postmeta.ref_id','=',$pid)
        ->get();
    return $resp;
}
function getCategoryName($catid){
    $cat=DB::table('em_category')->where('em_category.id','=',$catid)->select('em_category.category_title')->first();
    return $cat;
}
function chkfeedbacks($rspns){
    $feedbk=DB::table('em_posts')
        ->join('em_postmeta','em_posts.id','=','em_postmeta.posts_id')
        ->where('em_posts.post_type','=','FEEDBACK')
        ->where('em_postmeta.ref_id','=',$rspns)
        ->select('em_posts.id','em_posts.title','em_posts.description','em_posts.qstn_to_be_ans','em_posts.post_type','em_posts.post_sts','em_posts.created_dt','em_posts.created_user','em_posts.updated_dt','em_posts.updated_user','em_postmeta.ref_id','em_postmeta.class_code','em_postmeta.category_id','em_postmeta.avail_dt','em_postmeta.deadline_dt')
        ->first();

    return $feedbk;
}
function chkResponses($rspns){
    $responses=DB::table('em_posts')
        ->join('em_postmeta','em_posts.id','=','em_postmeta.posts_id')
        ->where('em_posts.post_type','=','RESPONSE')
        ->where('em_postmeta.ref_id','=',$rspns)
        ->where('em_posts.created_user','=',Session::get('logged')[0]['id'])
        ->select('em_posts.id','em_posts.title','em_posts.description','em_posts.qstn_to_be_ans','em_posts.post_type','em_posts.post_sts','em_posts.created_dt','em_posts.created_user','em_posts.updated_dt','em_posts.updated_user','em_postmeta.ref_id','em_postmeta.class_code','em_postmeta.category_id','em_postmeta.avail_dt','em_postmeta.deadline_dt')
        ->get();
    return $responses;
}
function chkCurFeedback($uid){
    $responses=DB::table('em_posts')
        ->join('em_postmeta','em_posts.id','=','em_postmeta.posts_id')
        ->where('em_posts.post_type','=','RESPONSE')
        ->where('em_posts.created_user','=',$uid)
        ->select('em_posts.id','em_posts.title','em_posts.description','em_posts.qstn_to_be_ans','em_posts.post_type','em_posts.post_sts','em_posts.created_dt','em_posts.created_user','em_posts.updated_dt','em_posts.updated_user','em_postmeta.ref_id','em_postmeta.class_code','em_postmeta.category_id','em_postmeta.avail_dt','em_postmeta.deadline_dt')
        ->orderBy('em_posts.created_dt','desc')
        ->first();
    if(count($responses)>0){
        $fdbk=chkfeedbacks($responses->id);
        return $fdbk;
    }
}
function agreed($pid,$uid){
    $agreed=DB::table('em_postsemo')->where('agrees','=','1')->where('username','=',$uid)->where('em_postsemo.posts_id','=',$pid)->get();
    return $agreed;
}
function liked($pid){
    $agreed=DB::table('em_postsemo')->where('agrees','=','1')->where('em_postsemo.posts_id','=',$pid)->get();
    return $agreed;
}
function disagreed($pid,$uid){
    $disagreed=DB::table('em_postsemo')->where('disagrees','=','1')->where('username','=',$uid)->where('em_postsemo.posts_id','=',$pid)->get();
    return $disagreed;
}
function disliked($pid){
    $disagreed=DB::table('em_postsemo')->where('disagrees','=','1')->where('em_postsemo.posts_id','=',$pid)->get();
    return $disagreed;
}