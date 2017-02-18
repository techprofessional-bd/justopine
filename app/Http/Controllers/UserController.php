<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index(){

    }
    public function create(){

    }
    public function store(){

    }
    public function TeacherList(){
        $dataList=DB::table('em_teachers')->get();
        return view('admin.teacher',compact('dataList'));
    }
    public function getTeacherFrmData(){
        $desig=DB::table('em_designation')->get();
        /*$subjects=DB::table('em_subjects')->get();*/
        return view('admin.teacher_entry_form',compact('desig'/*,'subjects'*/));
    }
    public function CreateTeacher(Request $request){
        $frmDt=$request->all();
        $postArray = array(
            'f_name' => $frmDt['txtFirstName'],
            'l_name' => $frmDt['txtLastName'],
            'designation' => $frmDt['ddlDesignation'],
            'join_dt' => "P",
            'username' => $frmDt['txtUsername'],
        );
        $userArray= array(
            'username' => $frmDt['txtUsername'],
            'email' => $frmDt['txtEmail'],
            'password' => sha1($frmDt['txtPassword']),
            'name' => $frmDt['txtFirstName'].' '.$frmDt['txtLastName'],
            'user_type' => "TEACHER",
            'user_sts' => "A",
        );

        $posts = DB::table('em_teachers')->insert($postArray);
        $postuser=DB::table('em_users')->insert($userArray);

        return redirect('/admin/teachers');
    }
    public function PupilList(){
        $dataList=DB::table('em_students')->get();
        return view('admin.pupil',compact('dataList'));
    }
    public function getEditTeacher($tid){
        $dataList=DB::table('em_teachers')
                ->join('em_users','em_users.username','=','em_teachers.username')
                ->where('em_teachers.id','=',$tid)
                ->select('em_teachers.id','em_teachers.f_name','em_teachers.l_name','em_teachers.designation','em_teachers.subjects','em_teachers.join_dt','em_teachers.username','em_users.email','em_users.name','em_users.user_type','em_users.user_sts')
                ->get();
        $desig=DB::table('em_designation')->get();
        return view('admin.teacher_edit_form',compact('dataList','desig'));
    }
    public function EditTeacher(Request $request){
        $frmDt=$request->all();

        $postArray = array(
            'f_name' => $frmDt['txtFirstName'],
            'l_name' => $frmDt['txtLastName'],
            'designation' => $frmDt['ddlDesignation'],
        );
        if($frmDt['txtPassword']==""){
            $userArray= array(
                'email' => $frmDt['txtEmail'],
                'name' => $frmDt['txtFirstName'].' '.$frmDt['txtLastName'],
                'user_sts' => $frmDt['ddlSts'],
            );
            $posts = DB::table('em_teachers')->where('username','=',$frmDt['txtUsername'])->update($postArray);
            $postuser=DB::table('em_users')->where('username','=',$frmDt['txtUsername'])->update($userArray);
        }
        else{
            $userArray= array(
                'email' => $frmDt['txtEmail'],
                'password' => sha1($frmDt['txtPassword']),
                'name' => $frmDt['txtFirstName'].' '.$frmDt['txtLastName'],
                'user_sts' => $frmDt['ddlSts'],
            );
            $posts = DB::table('em_teachers')->where('username','=',$frmDt['txtUsername'])->update($postArray);
            $postuser=DB::table('em_users')->where('username','=',$frmDt['txtUsername'])->update($userArray);

        }
        return redirect('/admin/teachers');
    }
    public function getPupilFrmDt(){
        $cls=DB::table('em_class')->get();
        return view('admin.pupil_info',compact('cls'));
    }
    public function CreatePupil(Request $request){
        $frmDt=$request->all();
        $pupilArray=array(
            "username"=>$frmDt['txtUsername'],
            "f_name"=>$frmDt['txtFirstName'],
            "l_name"=>$frmDt['txtLastName'],
            "current_class_code"=>$frmDt['ddlClass'],
        );
        $userArray=array(
            "username"=>$frmDt['txtUsername'],
            "email"=>$frmDt['txtEmail'],
            "password"=>sha1($frmDt['txtPassword']),
            "name"=>$frmDt['txtFirstName'].' '.$frmDt['txtLastName'],
            "user_type"=>"PUPIL",
            "user_sts"=>"A",
        );
        $pupil=DB::table('em_students')->insert($pupilArray);
        $user=DB::table('em_users')->insert($userArray);
        return redirect('/admin/pupil');
    }
    public function getEditPupil($sid){
        $ppls=DB::table('em_students')
            ->join('em_users','em_users.username','=','em_students.username')
            ->where('em_students.id','=',$sid)
            ->select('em_students.id','em_students.f_name','em_students.l_name','em_students.current_class_code','em_students.username','em_users.email','em_users.name','em_users.user_type','em_users.user_sts')
            ->get();
        $cls=DB::table('em_class')->get();
        return view('admin.pupil_edit',compact('ppls','cls'));
    }
    public function EditPupil(Request $request){
        $frmDt=$request->all();

        $postArray = array(
            "f_name"=>$frmDt['txtFirstName'],
            "l_name"=>$frmDt['txtLastName'],
            "current_class_code"=>$frmDt['ddlClass'],
        );
        if($frmDt['txtPassword']==""){
            $userArray= array(
                'email' => $frmDt['txtEmail'],
                'name' => $frmDt['txtFirstName'].' '.$frmDt['txtLastName'],
            );
            $posts = DB::table('em_students')->where('username','=',$frmDt['txtUsername'])->update($postArray);
            $postuser=DB::table('em_users')->where('username','=',$frmDt['txtUsername'])->update($userArray);
        }
        else{
            $userArray= array(
                'email' => $frmDt['txtEmail'],
                'password' => sha1($frmDt['txtPassword']),
                'name' => $frmDt['txtFirstName'].' '.$frmDt['txtLastName'],
            );
            $posts = DB::table('em_students')->where('username','=',$frmDt['txtUsername'])->update($postArray);
            $postuser=DB::table('em_users')->where('username','=',$frmDt['txtUsername'])->update($userArray);

        }
        return redirect('/admin/pupil');
    }
    public function DeletePupil(Request $request){
        $delDt=$request->all();
        DB::table('em_students')->where('username', $delDt['txtUsername'])->delete();
        DB::table('em_users')->where('username',$delDt['txtUsername'])->delete();
        session::flash('message','pupil deleted successfully');
        return redirect('/admin/pupil');
    }
    public function DeleteTeachers(Request $request){
        $delDt=$request->all();
        DB::table('em_teachers')->where('username', $delDt['txtUsername'])->delete();
        DB::table('em_users')->where('username',$delDt['txtUsername'])->delete();
        session::flash('message','Teacher deleted successfully');
        return redirect('/admin/teachers');
    }
    public function ChkUsername(){
        $id=Input::get('UserName');
        $username=DB::table('em_users')->where('username','=',$id)->get();
        if(count($username)>0){
            $response = array(
                //'_token' => $request->header('X-CSRF-Token'),
                'status' => 'YES',
                'msg' => 'Username is not available',
            );

        }
        else{
            $response = array(
                //'_token' => $request->header('X-CSRF-Token'),
                'status' => 'NO',
                'msg' => 'OK',
            );
        }
        return response()->json($response);
    }
}
