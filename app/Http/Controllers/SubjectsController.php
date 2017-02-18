<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class SubjectsController extends Controller
{
    public function getSubjects(){
        $subjs=DB::table('em_subjects')->get();
        return view('admin.subjects',compact('subjs'));
    }
    public function CreateSubjects(Request $request){
        $frmDt=$request->all();
        $SubjectArray=array(
            "subject_title"=>$frmDt['txtSubjectTitle'],
            "shrot_code"=>$frmDt['txtSubjectCode'],
        );
        $post=DB::table('em_subjects')->insert($SubjectArray);
        return redirect('/admin/subjects');
    }
    public function getEditSubjects($sbjid){
        $subjs=DB::table('em_subjects')->where('id','=',$sbjid)->get();
        return view('admin.subjects_edit',compact('subjs'));
    }
    public function EditSubjects(Request $request){
        $frmDt=$request->all();
        $SubjectArray=array(
            "subject_title"=>$frmDt['txtSubjectTitle'],
            "shrot_code"=>$frmDt['txtSubjectCode'],
        );
        $post=DB::table('em_subjects')->where('id','=',$frmDt['txtSubjectId'])->update($SubjectArray);

        return redirect('/admin/subjects');
    }
}
