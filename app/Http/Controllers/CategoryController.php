<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function getCategories(){
        $dataList=DB::table('em_category')->get();
        return view('admin.category',compact('dataList'));
    }
    public function getCategoryFrmData(){
       /* $subjs=DB::table('em_subjects')->get();*/
        return view('admin.category_info');
    }
    public function CreateCategory(Request $request){
        $frmDt=$request->all();
        $catArray=array(
            "category_title"=>$frmDt['txtCatTitle'],
        );
        $catpost=DB::table('em_category')->insert($catArray);
        return redirect('/admin/categories');
    }
    public function getEditCategory($catid){
        $cat=DB::table('em_category')->where('id','=',$catid)->get();
        /*$subjs=DB::table('em_subjects')->get();*/
        return view('admin.category_edit',compact('cat'));
    }
    public function EditCategory(Request $request){
        $frmDt=$request->all();
        $catArray=array(
            "category_title"=>$frmDt['txtCatTitle'],
        );
        $catpost=DB::table('em_category')->where('id','=',$frmDt['txtCatId'])->update($catArray);
        return redirect('/admin/categories');
    }
    public function DeleteCategory(Request $request){
        $delDt=$request->all();
        DB::table('em_category')->where('id', $delDt['txtCategoryId'])->delete();
        session::flash('message','Category deleted successfully');
        return redirect('/admin/categories');
    }
}
