@extends('normal_layout')
@section('content')
<section id=""><!--form-->
		<div class="container col-sm-12">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/trang-chu')}}">Trang chủ</a></li>
				  <li class="active">Thanh toán giỏ hàng</li>
				</ol>
			</div><!--/breadcrums-->
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Đăng nhập tài khoản</h2>
						<form action="{{URL::to('/login-customer')}}" method="post">
                            {{csrf_field()}}
							<input type="text" name="email_account" placeholder="Email" />
							<input type="password" name="password_account" placeholder="Password" />
							<span>
								<input type="checkbox" name="password_account" class="checkbox"> 
								Ghi nhớ đăng nhập
							</span>
							<button type="submit" class="btn btn-default">Đăng nhập</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">Hoặc</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Đăng ký tài khoản</h2>
						<form action="{{URL::to('/add-customer')}}" method="post">
                            {{csrf_field()}}
							<input required type="text" name="customer_name" placeholder="Họ tên"/>
							<input required type="email" name="customer_email" placeholder="Email"/>
							<input required type="password" name="customer_password" placeholder="Password"/>
                            <input required type="text" name="customer_phone" placeholder="Số điện thoại"/>
							<button type="submit" class="btn btn-default">Đăng ký</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
@endsection