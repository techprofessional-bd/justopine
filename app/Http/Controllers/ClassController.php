<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class ClassController extends Controller
{
    public function index(){

    }
    public function create(){

    }
    public function store(){

    }
    public function getTeacherAssignedClass(){
        $tid=Session::get('logged')[0]['user'];
        $teacher=DB::table('em_teachers')->where('username','=',$tid)->first();

        $tdt=DB::table('em_assigned_class')
            ->where('em_assigned_class.teacher_id','=',$teacher->id)
            ->where('em_assigned_class.assign_sts','=','YES')
            ->select()
            ->get();
        return view('layouts.teacher_assign_class',compact('tdt'));
    }

    public function ClassList(){
        $dataList=DB::table('em_class')->get();
        return view('admin.class',compact('dataList'));
    }
    public function CreateClass(Request $request){
        $cls=$request->all();
        $clsArray=array("short_form"=>$cls['txtClassCode']);
        $posts=DB::table('em_class')->insert($clsArray);
        return redirect('/admin/class');
    }
    public function getAssignClassDt(){
        $teacherdt=DB::table('em_teachers')->get();
        $clsdt=DB::table('em_class')->get();
        return view('admin.assign_class',compact('teacherdt','clsdt'));
    }
    public function AssignClass(Request $request){
        $frmDt=$request->all();
        foreach($frmDt['chkClasses'] as $cls){
            $postArray=array(
                'teacher_id'=>$frmDt['ddlTeachers'],
                'class_code'=>$cls,
                'assign_sts'=>"YES",
                'start_dt'=>date('Y-m-d',strtotime($frmDt['txtStartDt'])),
                'end_dt'=>date('Y-m-d',strtotime($frmDt['txtEndDt'])),
            );
            $postuser=DB::table('em_assigned_class')->insert($postArray);
        }
        return redirect('/admin/teacher/assign/class');
    }
    public function getEditClass($clsid){
        $cls=DB::table('em_class')->where('id','=',$clsid)->get();
        return view('admin.class_edit_form',compact('cls'));
    }
    public function EditClass(Request $request){
        $frmDt=$request->all();
        $postArray=array(
            'short_form'=>$frmDt['txtClassCode'],
        );
        $updt=DB::table('em_class')->where('id','=',$frmDt['txtClassId'])->update($postArray);
        return redirect('/admin/class');
    }
    public function destroy($id)
    {

                DB::table('em_class')->where('id', $id)->delete();
                session::flash('message','Class deleted successfully');
                return redirect('/admin/class');

    }
    public function DeleteClass(Request $request){
        $delDt=$request->all();
        DB::table('em_class')->where('id', $delDt['txtClassId'])->delete();
        session::flash('message','Class deleted successfully');
        return redirect('/admin/class');
    }
}
