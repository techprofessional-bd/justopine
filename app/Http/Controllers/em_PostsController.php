<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class em_PostsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data=DB::table('em_posts')
            ->join('em_postmeta','em_postmeta.posts_id','=','em_posts.id')
            ->join('em_images','em_images.posts_id','=','em_posts.id')
            ->select('em_posts.id','em_posts.title','em_posts.description','em_posts.qstn_to_be_ans','em_posts.post_type','em_posts.post_sts','em_posts.created_dt','em_posts.created_user','em_posts.updated_dt','em_posts.updated_user','em_postmeta.ref_id','em_postmeta.class_code','em_postmeta.category_id','em_postmeta.avail_dt','em_postmeta.deadline_dt','em_images.img_path','em_images.img_name','em_images.img_ext')
            ->get();
        return view('layouts.dashboard',compact('data'));
    }
    public function create(){
        //
    }
    public function getNxtId($tbl, $col)
    {

        $lastId = DB::table($tbl)->max($col);

        return $lastId + 1;
    }
    public function store(Request $request){

        //if(Request::ajax()) {
            //$dt=$request->all();
            /*if ($dt['postType'] == "OPINION") {*/
                /*$postArray = array(
                    'title' => $dt['OpinionTitle'],
                    'description' => $dt['opinion'],
                    'qstn_to_be_ans' => $dt['qstn'],
                    'post_type' => "",
                    'post_sts' => "P",
                    'created_dt' => date('Y-m-d'),
                    'created_user' => Session::get('logged')[0]['id'],
                );
                $posts = DB::table('em_posts')->insert($postArray);
                dd($posts);
                $last_insert_post_id = $posts->id;
                $postMetaArray = array(
                    'posts_id' => $last_insert_post_id,
                    'class_code' => $dt['ddlClassId'],
                    'category_id' => $dt['ddlCategory'],
                    'avail_dt' => $dt['txtAvailDt'],
                    'deadline_dt' => $dt['txtDeadlineDt'],
                );*/
               //$postmeta = DB::table('em_postmeta')->insert($postMetaArray);
               // dd($dt['ddlClassId']);
                return Response::json($request->all());
            //}

       //}

    }
    public function getPostsForDashboard(){
        if(Session::get('logged')[0]['type']=="TEACHER") {
            $data = DB::table('em_posts')
                ->join('em_postmeta', 'em_postmeta.posts_id', '=', 'em_posts.id')
                ->where('em_posts.post_type', '=', 'OPINION')
                ->where('em_posts.created_user', '=', Session::get('logged')[0]['id'])
                ->select('em_posts.id', 'em_posts.title', 'em_posts.description', 'em_posts.qstn_to_be_ans', 'em_posts.post_type', 'em_posts.post_sts', 'em_posts.created_dt', 'em_posts.created_user', 'em_posts.updated_dt', 'em_posts.updated_user', 'em_postmeta.ref_id', 'em_postmeta.class_code', 'em_postmeta.category_id', 'em_postmeta.avail_dt', 'em_postmeta.deadline_dt')
                ->get();
            $usr=Session::get('logged')[0]['id'];
            //dd($data);
            $dt=$this->getActivitiesList($usr);
            $tid=Session::get('logged')[0]['user'];
            $teacher=DB::table('em_teachers')->where('username','=',$tid)->first();

            $tdt=DB::table('em_assigned_class')
                ->where('em_assigned_class.teacher_id','=',$teacher->id)
                ->where('em_assigned_class.assign_sts','=','YES')
                ->select()
                ->get();
            //dd($dt);
            return view('layouts.dashboard',compact('data','dt','tdt'));
        }
        elseif(Session::get('logged')[0]['type']=="PUPIL"){
            $std=DB::table('em_students')->where('em_students.username','=',Session::get('logged')[0]['user'])->first();
            //dd(Session::get('logged')[0]['id']);
            $data = DB::table('em_posts')
                ->join('em_postmeta', 'em_postmeta.posts_id', '=', 'em_posts.id')
                ->where('em_posts.post_type', '=', 'OPINION')
                ->where('em_postmeta.class_code', '=', $std->current_class_code)
                ->select('em_posts.id', 'em_posts.title', 'em_posts.description', 'em_posts.qstn_to_be_ans', 'em_posts.post_type', 'em_posts.post_sts', 'em_posts.created_dt', 'em_posts.created_user', 'em_posts.updated_dt', 'em_posts.updated_user', 'em_postmeta.ref_id', 'em_postmeta.class_code', 'em_postmeta.category_id', 'em_postmeta.avail_dt', 'em_postmeta.deadline_dt')
                ->get();
            $curpiece = DB::table('em_posts')
                ->join('em_postmeta', 'em_postmeta.posts_id', '=', 'em_posts.id')
                ->where('em_posts.post_type', '=', 'OPINION')
                ->where('em_postmeta.class_code', '=', $std->current_class_code)
                ->select('em_posts.id', 'em_posts.title', 'em_posts.description', 'em_posts.qstn_to_be_ans', 'em_posts.post_type', 'em_posts.post_sts', 'em_posts.created_dt', 'em_posts.created_user', 'em_posts.updated_dt', 'em_posts.updated_user', 'em_postmeta.ref_id', 'em_postmeta.class_code', 'em_postmeta.category_id', 'em_postmeta.avail_dt', 'em_postmeta.deadline_dt')
                ->orderBy('em_posts.created_dt','desc')
                ->limit(1)
                ->get();
            $usr=Session::get('logged')[0]['id'];

            //dd($data);
            $dt=$this->getActivitiesList($usr);

            //dd($dt);
            return view('layouts.dashboard',compact('data','dt','curpiece'));
        }
    }
    public function getOpinionDetails($cid,$pid){
        $cls=DB::table('em_class')->get();
        $cat=DB::table('em_category')->select('id','category_title')->get();
        $getresp=DB::select(DB::Raw('select em_postmeta.ref_id, em_postmeta.posts_id,em_postmeta.category_id, em_posts.created_user,em_posts.created_dt,em_posts.qstn_to_be_ans,em_posts.description, em_students.username,em_students.current_class_code, concat(em_students.f_name," ",em_students.l_name)name from em_postmeta inner JOIN em_posts on em_posts.id=em_postmeta.posts_id inner join em_users on em_users.id=em_posts.created_user inner join em_students on em_students.username=em_users.username where em_postmeta.ref_id='.$pid));
        //dd($getresp);
        $opinionDtl=DB::table('em_posts')
            ->join('em_postmeta','em_postmeta.posts_id','=','em_posts.id')
            ->where('em_posts.id','=',$pid)
            ->select('em_posts.id', 'em_posts.title', 'em_posts.description', 'em_posts.qstn_to_be_ans', 'em_posts.post_type', 'em_posts.post_sts', 'em_posts.created_dt', 'em_posts.created_user', 'em_posts.updated_dt', 'em_posts.updated_user', 'em_postmeta.ref_id', 'em_postmeta.class_code', 'em_postmeta.category_id', 'em_postmeta.avail_dt', 'em_postmeta.deadline_dt')
            ->get();

        return view('layouts.assignment',compact('getresp','cls','cat','opinionDtl'));
    }
    public function LatestFeedbackforStd(){
        $cls=DB::table('em_class')->get();
        $pupilCls=DB::table('em_students')->where('em_students.username','=',Session::get('logged')[0]['user'])->first();
        $agree=DB::table('em_postsemo')->where('agrees','=','1')->get();
        $disagree=DB::table('em_postsemo')->where('disagrees','=','1')->get();

        $disagreed=DB::table('em_postsemo')->where('disagrees','=','1')->where('username','=',Session::get('logged')[0]['user'])->get();
        $getRespEmo=DB::table('em_postsemo')->where('username','=',Session::get('logged')[0]['user'])->get();
        $opinionDtl=DB::table('em_posts')
        ->join('em_postmeta','em_postmeta.posts_id','=','em_posts.id')
        ->where('em_postmeta.class_code','=',$pupilCls->current_class_code)
        ->where('em_postmeta.avail_dt','<=',Carbon::now())
            ->where('em_postmeta.deadline_dt','>=',Carbon::now())
            ->select('em_posts.id', 'em_posts.title', 'em_posts.description', 'em_posts.qstn_to_be_ans', 'em_posts.post_type', 'em_posts.post_sts', 'em_posts.created_dt', 'em_posts.created_user', 'em_posts.updated_dt', 'em_posts.updated_user', 'em_postmeta.ref_id', 'em_postmeta.class_code', 'em_postmeta.category_id', 'em_postmeta.avail_dt', 'em_postmeta.deadline_dt')
        ->limit(1)->get();
        if(count($opinionDtl)>0) {
            $getresp = DB::select(DB::Raw('select em_postmeta.ref_id, em_postmeta.posts_id,em_postmeta.category_id, em_posts.created_user,em_posts.created_dt,em_posts.qstn_to_be_ans,em_posts.description, em_students.username,em_students.current_class_code, concat(em_students.f_name," ",em_students.l_name)name from em_postmeta inner JOIN em_posts on em_posts.id=em_postmeta.posts_id inner join em_users on em_users.id=em_posts.created_user inner join em_students on em_students.username=em_users.username where em_postmeta.ref_id=' . $opinionDtl[0]->id . ' and em_students.current_class_code=' . $pupilCls->current_class_code));
        }
        else{
            $getresp=DB::select(DB::Raw('select em_postmeta.ref_id, em_postmeta.posts_id,em_postmeta.category_id, em_posts.created_user,em_posts.created_dt,em_posts.qstn_to_be_ans,em_posts.description, em_students.username,em_students.current_class_code, concat(em_students.f_name," ",em_students.l_name)name from em_postmeta inner JOIN em_posts on em_posts.id=em_postmeta.posts_id inner join em_users on em_users.id=em_posts.created_user inner join em_students on em_students.username=em_users.username where em_students.current_class_code='.$pupilCls->current_class_code));
        }
        return view('layouts.feedback',compact('getresp','pupilCls','opinionDtl','cls','agree','disagree','getRespEmo'));
    }
    public function createAssignmentForm(){
        $tchr=DB::table('em_teachers')->where('username','=',Session::get('logged')[0]['user'])->first();
        $cls=DB::table('em_assigned_class')->where('em_assigned_class.teacher_id','=',$tchr->id)
            ->where('em_assigned_class.assign_sts','=','YES')
            ->get();
        $cat=DB::table('em_category')->where('sub_code','=',$tchr->subjects)->get();
        //dd($cat);
        $data=DB::table('em_posts')
            ->join('em_postmeta','em_postmeta.posts_id','=','em_posts.id')
            ->join('em_images','em_images.posts_id','=','em_posts.id')
            ->select('em_posts.id','em_posts.title','em_posts.description','em_posts.qstn_to_be_ans','em_posts.post_type','em_posts.post_sts','em_posts.created_dt','em_posts.created_user','em_posts.updated_dt','em_posts.updated_user','em_postmeta.ref_id','em_postmeta.class_code','em_postmeta.category_id','em_postmeta.avail_dt','em_postmeta.deadline_dt','em_images.img_path','em_images.img_name','em_images.img_ext')
            ->get();
        $usr=Session::get('logged')[0]['id'];
        //dd($usr);
        $dt=$this->getActivitiesList($usr);
        return view('layouts.assignment_form',compact('cls','cat','dt'));
    }
    public function createResponse(Request $request){
        $master_id = $this->getNxtId('em_posts', 'id');
        if($request->ajax()) {
            $frmDt = $request->all();
            //if ($frmDt['postType'] == "RESPONSE") {
                $postArray = array(
                    'id' => $master_id,
                    'description' => $frmDt['response'],
                    'qstn_to_be_ans' => $frmDt['answer'],
                    'post_type' => $frmDt['postType'],
                    'post_sts' => "P",
                    'created_dt' => date('Y-m-d'),
                    'created_user' => Session::get('logged')[0]['id'],
                );
                $postMetaArray = array(
                    'posts_id' => $master_id,
                    'class_code' => $frmDt['ClassId'],
                    'ref_id' => $frmDt['RefId'],
                    'category_id' => $frmDt['Category'],
                );
                $posts = DB::table('em_posts')->insert($postArray);
                $postmeta = DB::table('em_postmeta')->insert($postMetaArray);
                $response = array(
                    //'_token' => $request->header('X-CSRF-Token'),
                    'status' => 'success',
                    'msg' => 'Response created successfully',
                );
                return response()->json($response);  // <<<<<<<<< see this line
            //}
        }
    }
    public function createDraftResponse(Request $request){
        $master_id = $this->getNxtId('em_posts', 'id');
        if($request->ajax()) {
            $frmDt = $request->all();
            //if ($frmDt['postType'] == "RESPONSE") {
            $postArray = array(
                'id' => $master_id,
                'description' => $frmDt['response'],
                'qstn_to_be_ans' => $frmDt['answer'],
                'post_type' => $frmDt['postType'],
                'post_sts' => "U",
                'created_dt' => date('Y-m-d'),
                'created_user' => Session::get('logged')[0]['id'],
            );
            $postMetaArray = array(
                'posts_id' => $master_id,
                'class_code' => $frmDt['ClassId'],
                'ref_id' => $frmDt['RefId'],
                'category_id' => $frmDt['Category'],
            );
            $posts = DB::table('em_posts')->insert($postArray);
            $postmeta = DB::table('em_postmeta')->insert($postMetaArray);
            $response = array(
                //'_token' => $request->header('X-CSRF-Token'),
                'status' => 'success',
                'msg' => 'Response created successfully',
            );
            return response()->json($response);  // <<<<<<<<< see this line
            //}
        }
    }
    public function createFeedback(Request $request){
        $master_id = $this->getNxtId('em_posts', 'id');
        if($request->ajax()){
            $frmDt=$request->all();
            $postArray = array(
                'id'=>$master_id,
                'description' => $frmDt['feedback'],
                'post_type' => $frmDt['postType'],
                'post_sts' => "P",
                'created_dt' => date('Y-m-d'),
                'created_user' => Session::get('logged')[0]['id'],
            );
            $postMetaArray = array(
                'posts_id' => $master_id,
                'class_code' => $frmDt['ClassId'],
                'ref_id'=>$frmDt['RefId'],
                'category_id' => $frmDt['Category'],
            );
            $posts = DB::table('em_posts')->insert($postArray);
            $postmeta=DB::table('em_postmeta')->insert($postMetaArray);
            $response = array(
                //'_token' => $request->header('X-CSRF-Token'),
                'status' => 'success',
                'msg' => 'Feedback created successfully',
            );
            return response()->json($response);
        }
    }
    public function createOpinion(Request $request){
        $master_id = $this->getNxtId('em_posts', 'id');
        //if($request->ajax()){
            $frmDt=$request->all();
            //if ($frmDt['postType'] == "OPINION") {
                $postArray = array(
                    'id'=>$master_id,
                    'title' => $frmDt['OpinionTitle'],
                    'description' => $frmDt['opinion'],
                    'qstn_to_be_ans' => $frmDt['qstn'],
                    'post_type' => $frmDt['postType'],
                    'post_sts' => "P",
                    'created_dt' => date('Y-m-d'),
                    'created_user' => Session::get('logged')[0]['id'],
                );

                $postMetaArray = array(
                    'posts_id' => $master_id,
                    'class_code' => $frmDt['ddlClassId'],
                    'category_id' => $frmDt['ddlCategory'],
                    'avail_dt' => date('Y-m-d',strtotime($frmDt['txtAvailDt'])),
                    'deadline_dt' => date('Y-m-d',strtotime($frmDt['txtDeadlineDt'])),
                );
                $posts = DB::table('em_posts')->insert($postArray);
                $postmeta=DB::table('em_postmeta')->insert($postMetaArray);
                $response = array(
                    //'_token' => $request->header('X-CSRF-Token'),
                    'status' => 'success',
                    'msg' => 'Opinion created successfully',
                );
                //return response()->json($response);  // <<<<<<<<< see this line
                return redirect('/dashboard');
        //}
    }
    public function editOpinion(Request $request){
        //if($request->ajax()){
            $frmDt=$request->all();
            $postArray = array(
                'title' => $frmDt['OpinionTitle'],
                'description' => $frmDt['opinion'],
                'qstn_to_be_ans' => $frmDt['qstn'],
                'post_type' => "OPINION",
                'post_sts' => "P",
                'updated_dt' => date('Y-m-d'),
                'updated_user' => Session::get('logged')[0]['id'],
            );
            $postMetaArray = array(
                'class_code' => $frmDt['ddlClassId'],
                'category_id' => $frmDt['ddlCategory'],
                'avail_dt' => date('Y-m-d',strtotime($frmDt['txtAvailDt'])),
                'deadline_dt' => date('Y-m-d',strtotime($frmDt['txtDeadlineDt'])),
            );
            $posts = DB::table('em_posts')->where('em_posts.id','=',$frmDt['txtPostId'])->update($postArray);
            $postmeta=DB::table('em_postmeta')->where('em_postmeta.posts_id','=',$frmDt['txtPostId'])->update($postMetaArray);
            $response = array(
                //'_token' => $request->header('X-CSRF-Token'),
                'status' => 'success',
                'msg' => 'Updated successfully',
            );
            //return response()->json($response);
        //}
        return redirect('/assignment/class/'.$frmDt['ddlClassId'].'/post/'.$frmDt['txtPostId']);
    }
    public function chkIfExists($id){
        $data=DB::table('em_posts')
            ->where('em_posts.id','=',$id)->first();
        return $data;
    }
    public function getActivitiesList($uid){
        $dt=DB::table('em_posts')
            ->join('em_postmeta','em_posts.id','=','em_postmeta.posts_id')
            ->where('em_posts.created_user','=',$uid)
            ->where('em_posts.post_type','=','OPINION')
            ->where('em_posts.post_sts','=','P')
            ->select('em_posts.id','em_posts.title','em_posts.description','em_posts.qstn_to_be_ans','em_posts.post_type','em_posts.post_sts','em_posts.created_dt','em_posts.created_user','em_posts.updated_dt','em_posts.updated_user','em_postmeta.ref_id','em_postmeta.class_code','em_postmeta.category_id','em_postmeta.avail_dt','em_postmeta.deadline_dt')
            ->orderBy('em_posts.created_dt','desc')
            ->get();
        //dd($dt);
        return $dt;
    }
    public function chkFeedbacks($rspns){
        $feedbk=DB::table('em_posts')
            ->join('em_postmeta','em_posts.id','=','em_postmeta.posts_id')
            ->where('em_posts.post_type','=','FEEDBACK')
            ->where('em_postmeta.ref_id','=',$rspns)
            ->select('em_posts.id','em_posts.title','em_posts.description','em_posts.qstn_to_be_ans','em_posts.post_type','em_posts.post_sts','em_posts.created_dt','em_posts.created_user','em_posts.updated_dt','em_posts.updated_user','em_postmeta.ref_id','em_postmeta.class_code','em_postmeta.category_id','em_postmeta.avail_dt','em_postmeta.deadline_dt')
            ->get();
        return $feedbk;
    }
    public function RespLikes(Request $request){
        $frmDt=$request->all();
        $postEmoInsert=array(
            "username"=>$frmDt['txtUsername'],
            "posts_id"=>$frmDt['txtPostsId'],
            "agrees"=>$frmDt['txtAgrees'],
            "disagrees"=>$frmDt['txtDisagrees']
        );
        $postEmoUpdate=array(
            "agrees"=>$frmDt['txtAgrees'],
            "disagrees"=>$frmDt['txtDisagrees']
        );
        $chk=DB::table('em_postsemo')->where('em_postsemo.posts_id','=',$frmDt['txtPostsId'])->where('em_postsemo.username','=',$frmDt['txtUsername'])->get();
        if(count($chk)<1){
            $insert=DB::table('em_postsemo')->insert($postEmoInsert);
        }
        else{
            $update=DB::table('em_postsemo')->where('username','=',$frmDt['txtUsername'])->where('posts_id','=',$frmDt['txtPostsId'])->update($postEmoUpdate);
        }
        return redirect('/student/feedback');
    }
    public function getArchive($clsid){

        $data = DB::table('em_posts')
            ->join('em_postmeta', 'em_postmeta.posts_id', '=', 'em_posts.id')
            ->where('em_posts.post_type', '=', 'OPINION')
            ->where('em_postmeta.class_code','=',$clsid)
            ->where('em_postmeta.deadline_dt','<',Carbon::now())
            ->where('em_posts.created_user','=',Session::get('logged')[0]['id'])
            ->select('em_posts.id', 'em_posts.title', 'em_posts.description', 'em_posts.qstn_to_be_ans', 'em_posts.post_type', 'em_posts.post_sts', 'em_posts.created_dt', 'em_posts.created_user', 'em_posts.updated_dt', 'em_posts.updated_user', 'em_postmeta.ref_id', 'em_postmeta.class_code', 'em_postmeta.category_id', 'em_postmeta.avail_dt', 'em_postmeta.deadline_dt')
            ->get();
        $usr=Session::get('logged')[0]['id'];
        //dd($data);
        $dt=$this->getActivitiesList($usr);
        $tid=Session::get('logged')[0]['user'];
        $teacher=DB::table('em_teachers')->where('username','=',$tid)->first();

        $tdt=DB::table('em_assigned_class')
            ->where('em_assigned_class.teacher_id','=',$teacher->id)
            ->where('em_assigned_class.assign_sts','=','YES')
            ->select()
            ->get();
        return view('layouts.archive_opinion',compact('data','dt','teacher','tid','tdt','clsid'));
    }
    public function getTeachersClass(){
        $tid=Session::get('logged')[0]['user'];
        $teacher=DB::table('em_teachers')->where('username','=',$tid)->first();

        $tdt=DB::table('em_assigned_class')
            ->where('em_assigned_class.teacher_id','=',$teacher->id)
            ->where('em_assigned_class.assign_sts','=','YES')
            ->select()
            ->get();
        return view('layouts.archives',compact('tdt'));
    }
}
