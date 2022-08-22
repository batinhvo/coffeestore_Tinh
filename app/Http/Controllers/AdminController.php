<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use App\Models\Order;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Post;
use Illuminate\Support\Facades\Redirect;
session_start();
class AdminController extends Controller
{
    public function AuthLogin(){
        $admin_id=Session::get('admin_id');
        if($admin_id){
           return Redirect::to('dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }
    public function index(){
        return view('admin_login');
    }

    public function show_dashboard(){
        // $this->AuthLogin();
        // $order=Order::count();
        // $post=Post::count();
        // $product=Product::count();
        // $sum=Order::where('order_status',2)->sum('order_total');
        // return view('admin.dashboard')->with(compact('sum','order','post','product'));
        return view('admin_layout');
    }

    public function dashboard(Request $request){
        $admin_email=$request->admin_email;
        $admin_password=md5($request->admin_password);
        $result= DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        if($result){
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            //Session::put('admin_image',$result->admin_image);
            return Redirect::to('/dashboard');
        }
        else {
            Session::put('message','Mật khẩu hoặc tài khoản bị sai');
            return Redirect::to('/admin');
        }
    }

    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
       // Session::put('admin_image',null);
        return Redirect::to('/admin');
    }
}

