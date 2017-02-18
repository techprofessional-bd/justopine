<?php
/**
 * Created by PhpStorm.
 * User: SM
 * Date: 9/2/2016
 * Time: 11:49 PM
 */

function getStdList($ccode){
    $stdlist=DB::table('em_students')
        ->where('current_class_code','=',$ccode)
        ->select()
        ->get()->paginate(15);
    return $stdlist;
}
function getCategoryName($catid){
    $cat=DB::table('em_category')->where('em_category.id','=',$catid)->select('em_category.category_title')->first();
    return $cat;
}