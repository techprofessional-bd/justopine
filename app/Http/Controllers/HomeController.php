<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=DB::table('em_posts')
            ->join('em_postmeta','em_postmeta.posts_id','=','em_posts.id')
            ->join('em_images','em_images.posts_id','=','em_posts.id')
            ->select('em_posts.id','em_posts.title','em_posts.description','em_posts.qstn_to_be_ans','em_posts.post_type','em_posts.post_sts','em_posts.created_dt','em_posts.created_user','em_posts.updated_dt','em_posts.updated_user','em_postmeta.ref_id','em_postmeta.class_code','em_postmeta.category_id','em_postmeta.avail_dt','em_postmeta.deadline_dt','em_images.img_path','em_images.img_name','em_images.img_ext')
            ->get();
        dd($data);
        return view('layouts.dashboard',compact('data'));
        //return view('home');
    }
}
