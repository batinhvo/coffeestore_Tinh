<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Admin_Role;
use App\Models\Role;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
class AuthController extends Controller
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
    public function add_manage(){
        $this->AuthLogin();
        return view('admin.manage.add_manage');
    }
    public function all_manage(){
        $this->AuthLogin();
        $admin=Admin::orderby('admin_id','desc')->get();
        return view('admin.manage.all_manage')->with(compact('admin'));
    }
    public function register_auth(){
        $this->AuthLogin();
        return view('admin.custom_auth.register');
    }
    public function register(Request $request){
        $this->AuthLogin();
        $data=$request->all();
        $admin = new Admin();
        $admin->admin_name=$data['admin_name'];
        $admin->admin_phone=$data['admin_phone'];
        $admin->admin_email=$data['admin_email'];
        $admin->admin_password=md5($data['admin_password']);
        $get_image=$request->file('admin_image');
        if($get_image){
            $get_name_image=$get_image->getClientOriginalName();
            $name_image=current(explode('.',$get_name_image));
            $new_image=$name_image.rand(0,999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/admin/',$new_image);
            $admin->admin_image=$new_image;
        }
        
        
        
        $admin->save();
        
        return redirect('/all-manage')->with('message','Đăng kí tài khoản nhân viên thành công');
    }
    
}
