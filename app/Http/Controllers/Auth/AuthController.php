<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
//use DB;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        /*return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);*/
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        /*return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);*/
    }
    public function signin(Request $request){
        $dt=$request->all();
        $qry=DB::table('em_users')->where('username','=',$dt['txtUserName'])->where('password','=',sha1($dt['txtPassword']))->where('user_sts','=',"A")->first();
        if(count($qry)==1) {
            $user = [];
            $user['id']=$qry->id;
            $user['user'] = $qry->username;
            $user['email'] = $qry->email;
            $user['name'] = $qry->name;
            $user['type'] = $qry->user_type;
            $request->session()->push('logged', $user);
            if($user['type']=="ADMIN"){return redirect('/admin/dashboard');}
            else{return redirect('/dashboard');}
        }
        else{
            return redirect('/')->with(Session::flash('alert-info','Username or Password doesn&acute;t match'));
        }

    }
}
