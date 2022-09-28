<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Admin_Role;
use App\Models\Role;
use App\Http\Requests;
use Session;
use DB;
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

    public function save_warehouse(Request $request){
        $this->AuthLogin();
        $data=array();
        $data['product_id']=$request->product_id;
        $data['brand_product']=$request->brand_product;
        $data['product_price']=$request->product_price;
        $data['product_quantity']=$request->product_quantity;

        // $data['create_at']=$request->product_quantity;
        $product_id=$request->product_id;
        $product_sl=DB::table('tbl_product')->where('product_id',$product_id)->get();
        foreach($product_sl as $pro){
            $pro_sl_old = $pro->product_quantity;
        }
        $proslu = $pro_sl_old + $request->product_quantity;
       
    //            echo '<pre>';
    //     print_r($data);
    //    echo '</pre>';
    //    echo $proslu;
        $prod=array();
        $prod['product_quantity']=$proslu;
        DB::table('tbl_ware')->insert($data);
        DB::table('tbl_product')->where('product_id',$product_id)->update($prod);
        Session::put('message','Thêm đơn hàng nhập kho thành công');
        return Redirect::to('manage-warehouse');
    }

    public function add_warehouse(){
        $this->AuthLogin();
        $category_product=DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand')->orderby('brand_id','desc')->get();
        $product=DB::table('tbl_product')->orderby('product_id','desc')->get();
        return view('admin.warehouse.add_warehouse')->with('category_product',$category_product)->with('brand_product',$brand_product)->with('product',$product);
    }

    public function manage_warehouse(){
        $this->AuthLogin();
        $admin=Admin::orderby('admin_id','desc')->get();
        // $warehouse=DB::table('tbl_ware')->orderby('warehouse_id','desc')->get();
        $warehouse=DB::table('tbl_product')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->join('tbl_ware','tbl_ware.product_id','=','tbl_product.product_id')->orderby('product_id','desc')->paginate(10);
        return view('admin.warehouse.all_warehouse')->with(compact('admin'))->with('ware',$warehouse);
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
