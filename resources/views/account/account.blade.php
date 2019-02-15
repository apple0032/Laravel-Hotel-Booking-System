@extends('main')

@section('title', '| Account Center')

@section('content')

	<style>
		.footer_section{
			display: none;
		}

		.dropdown-menu{
			font-size: 16px !important;
		}

		@import url(https://fonts.googleapis.com/css?family=Montserrat:400,700);
		/*body {*/
			/*outline: none;*/
			/*width: 100%;*/
			/*height: 100%;*/
			/*margin: 50px auto;*/
			/*background: #f9f9f9;*/
			/*box-sizing: border-box;*/
			/*font-family: "Noto Sans TC", sans-serif !important;*/
			/*font-size: 150%;*/
		/*}*/

		.wrapper {
			width: 100%;
			height: 100%;
			margin: 0 auto;
			margin-top: 40px;
			margin-bottom: 50px;
		}

		#box {
			width: 100%;
			height: auto;
			margin: 0 auto;
			background: #ffffff;
			border: thin solid #ededed;
		}



		#box > h3 {
			text-transform: uppercase;
			text-align: center;
			font-size: 0.9em;
			color: #666;
			margin: 0 0 35px 0;
		}

		#box > form {
			width: 100%;
			height: auto;
			margin: 0 auto;
			text-align: center;
		}

		#box > form > input {
			display: inline-block;
			width: 260px;
			height: 50px;
			margin: 5px auto;
			padding: 15px;
			box-sizing: border-box;
			font-size: 1em;
			border: 1.5px solid #cccccc;
			transition: all 0.2s ease;
		}

		#box > form > input:focus {
			border: thin solid #015b7e;
			outline: none;
		}

		::-webkit-input-placeholder {
			color: #ccc;
			font-weight: 700;
			font-size: 0.9em;
		}

		#box > a {
			display: block;
			margin: 0;
			padding: 5px 0 15px 0;
			width: 260px;
			height: 20px;
			margin: 0 auto;
			text-align: right;
			text-transform: uppercase;
			font-size: 0.7em;
			color: #ccc;
			font-weight: 400;
		}

		#box > form > input {
			width: 260px;
			height: 50px;
			background: #017a9d;
			border: none;
			outline: none;
			margin: 0 auto;
			display: block;
			color: #017a9d;
			/*text-transform: uppercase;*/
			text-align: center;
			margin-bottom: 20px;
			border-radius: 3px;
			cursor: pointer;
			font-weight: 700;
			font-size: 1.1em;
			transition: all 0.2s ease;
			letter-spacing: 1px;
		}

		#box > input:hover {
			background: #014965;
		}

		#box > .signup {
			width: 100%;
			height: auto;
			border: none;
			background: #e2e2e2;
			outline: none;
			margin: 0 auto;
			padding: 20px;
			display: block;
			color: #090909;
			text-transform: uppercase;
			text-align: center;
			box-sizing: border-box;
			font-size: 1em;
		}

		#box > .signup p, a {
			font-size: 1em;
			text-decoration: none;
		}

		#box > .signup p {
			color: #929292;
		}

		#box > .signup a {
			text-decoration: none;
			color: #015b7e;
			font-size: 1.3em;
			padding-left: 25px;
		}

		.login_image{
			background-color: #2e6da4;
			width: 100%;
			text-align: center;
			padding-top: 8px;
			padding-bottom: 8px;
		}

		.login_image i{
			color:white;
			font-size: 40px;
		}

		.reg_form{
			background-color: #cccccc !important;
		}

		.form_gender{
			width: 260px;
			margin: 0 auto;
		}

		.profile_pic{
			text-align: center;
			margin-bottom: 30px;
		}

		.profile_pic img{
			width: 250px;
			max-width: 100%;
			height: auto;
		}

		.profile_img_upload{
			background-color: #90dbf2 !important;
			border: 1px solid black !important;
		}
	</style>

	<meta name="csrf-token" content="{{ csrf_token() }}"/>

	<div class="wrapper">
		<div id="box">
			<div class="login_image">
				<i class="fas fa-user-circle"></i>
			</div>
			<br>
			<h3>請填寫資料</h3>

			<div class="profile_pic">
				@if($user->profile_image == null)
					<img src="{{URL::to('/')}}/images/no_profile_pic.jpg">
				@else
					<img src="{{URL::to('/')}}/images/users/profile_img/{{$user->id}}/{{$user->profile_image}}">
				@endif
			</div>

			<form method="POST" action="update" accept-charset="UTF-8" data-parsley-validate="" enctype="multipart/form-data">

				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<input name="profile_img" type="file" class="profile_img_upload">
				<input class="form-control reg_form" name="email" type="email" id="email" placeholder="登入電郵" value="{{$user->email}}" readonly style="cursor: no-drop; background-color: rgba(215,86,84,0.3) !important;">
				<input class="form-control reg_form" name="name" type="text" id="name" placeholder="名稱" value="{{$user->name}}">
				<input class="form-control reg_form" name="phone" type="text" id="phone" placeholder="電話" value="{{$user->phone}}">
				<select class="form-control reg_form form_gender" name="gender" id="gender">
					<option value ="M" @if($user->gender == 'M') selected @endif>M</option>
					<option value ="F" @if($user->gender == 'F') selected @endif>F</option>
				</select>

				<input class="form-control reg_form" name="password" type="password" value="" id="password" placeholder="密碼">
				<input class="form-control reg_form" name="password_confirmation" type="password" value="" id="password_confirmation" placeholder="確認密碼">

				<input onclick="this.style.backgroundColor = '#69c061';" type="submit" value="UPDATE" style="color:white">
			</form>


			<div class="signup">
				<p>請勿向其他人透露您的密碼。</p>
			</div>
		</div>
	</div>


@endsection