<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('auth/signin');
});

Route::auth();

Route::get('/home', 'em_PostsController@getPostsForDashboard');
Route::get('/logout', function(){
    Session::flush();
    if(!Session::has('logged'))
    {
        return view('auth.signin');
    }
});
Route::post('/login','Auth\AuthController@signin');
Route::get('/login',function(){
    Session::flush();
    if(!Session::has('logged'))
    {
        return view('auth.signin');
    }
});
Route::get('/dashboard','em_PostsController@getPostsForDashboard');
Route::get('/archive/class/{clsid}','em_PostsController@getArchive');
Route::get('/teacher/{username}/class/list','ClassController@getTeacherAssignedClass');
Route::get('/teacher/assignment/new','em_PostsController@createAssignmentForm');
Route::post('/teacher/assignment/edit','em_PostsController@editOpinion');
Route::get('/assignment/class/{cid}/post/{pid}','em_PostsController@getOpinionDetails');
Route::post('/teacher/assignment/new','em_PostsController@createOpinion');
Route::post('/response/create','em_PostsController@createResponse');
Route::post('/response/draft/create','em_PostsController@createDraftResponse');
Route::post('/feedback/create','em_PostsController@createFeedback');

Route::get('/student/feedback','em_PostsController@LatestFeedbackforStd');
Route::post('/student/feedback/likes','em_PostsController@RespLikes');

Route::get('admin/dashboard',function(){
    return view('admin.dashboard');
});
//Class tasks for Admin
Route::get('/admin/class','ClassController@ClassList');
Route::get('/admin/class/new',function(){
    return view('admin.class_entry_form');
});
Route::post('/admin/class/new','ClassController@CreateClass');
Route::get('/admin/class/edit/{clsid}','ClassController@getEditClass');
Route::post('/admin/class/edit','ClassController@EditClass');
Route::post('/admin/class/delete','ClassController@DeleteClass');

Route::get('/admin/subjects','SubjectsController@getSubjects');
Route::get('/admin/subjects/new',function(){
   return view('admin.subjects_info');
});
Route::post('/admin/subjects/new','SubjectsController@CreateSubjects');
Route::get('/admin/subjects/edit/{sbjid}','SubjectsController@getEditSubjects');
Route::post('/admin/subjects/edit','SubjectsController@EditSubjects');

Route::get('/admin/categories','CategoryController@getCategories');
Route::get('/admin/categories/new','CategoryController@getCategoryFrmData');
Route::post('/admin/categories/new','CategoryController@CreateCategory');
Route::get('/admin/categories/edit/{catid}','CategoryController@getEditCategory');
Route::post('/admin/categories/edit','CategoryController@EditCategory');
Route::post('/admin/categories/delete','CategoryController@DeleteCategory');

//Session Start and Close
Route::post('/admin/edu_year/create','ClassSessionController@CreateEduYear');


//Teacher creation and modification
Route::get('/admin/teachers','UserController@TeacherList');
Route::get('/admin/teacher/new','UserController@getTeacherFrmData');
Route::post('/admin/teacher/new','UserController@CreateTeacher');
Route::get('/admin/teacher/edit/{tid}','UserController@getEditTeacher');
Route::post('/admin/teacher/edit','UserController@EditTeacher');
Route::post('/admin/teacher/assign/class','ClassController@AssignClass');
Route::get('/admin/teacher/assign/class','ClassController@getAssignClassDt');
Route::post('/admin/teacher/delete','UserController@DeleteTeachers');

//pupil creation and modification
Route::get('/admin/pupil','UserController@PupilList');
Route::get('/admin/pupil/new','UserController@getPupilFrmDt');
Route::post('/admin/pupil/new','UserController@CreatePupil');
Route::get('/admin/pupil/edit/{sid}','UserController@getEditPupil');
Route::post('/admin/pupil/edit','UserController@EditPupil');
Route::post('/admin/pupil/delete','UserController@DeletePupil');

Route::get('/admin/user/chk','UserController@ChkUsername');
/*Route::get('/assignment/class/{cid}/post/{pid}',function($cid,$pid){

});*/