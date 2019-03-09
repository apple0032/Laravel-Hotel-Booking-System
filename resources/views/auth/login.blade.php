@extends('main')

@section('title', '| Login')

@section('content')
	<style>
		.navbar, .footer_section{
			display: none;
		}

		@import url(https://fonts.googleapis.com/css?family=Montserrat:400,700);
		body {
			outline: none;
			width: 100%;
			height: 100%;
			margin: 50px auto;
			background: #f9f9f9;
			box-sizing: border-box;
			font-family: "Montserrat", sans-serif;
			font-size: 140%;
		}

		.wrapper {
			width: 100%;
			height: 100%;
			margin: 0 auto;
			margin-top: 100px;
		}

		#box {
			max-width: 450px;
			height: auto;
			margin: 0 auto;
			background: #fff;
			/*border: thin solid #ededed;*/
			box-shadow: 0 1px 4px rgba(41, 51, 57, .5);
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
			font-size: 0.8em;
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
			color: #fff;
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
			background: #2e6da4d6;
			outline: none;
			margin: 0 auto;
			padding: 15px;
			display: block;
			color: #e1dfdf;
			text-transform: uppercase;
			text-align: center;
			box-sizing: border-box;
			font-size: 0.8em;
			margin-top: 30px;
		}

		#box > .signup p, a {
			font-size: 0.8em;
			text-decoration: none;
		}

		#box > .signup p {
			color: #fff;
		}

		#box > .signup a {
			text-decoration: none;
			color: #c4c4c4;
			font-size: 1em;
			/*padding-left: 25px;*/
			border: 1px solid #c4c4c4;
			margin-left: 30px;
			padding: 3px 15px;
			border-radius: 3px;
		}

		.login_image{
			background-color: #2e6da4;
			width: 100%;
			text-align: center;
			padding-top: 8px;
			padding-bottom: 8px;
		}

	</style>

	<meta name="csrf-token" content="{{ csrf_token() }}"/>

	<div class="wrapper">
		<div id="box">
			<div class="login_image">
			<img src="{{asset('/images/logo2_s.png')}}" class="nav_logo">
		</div>
			<br>
			<h3>Please sign in</h3>

			<form method="POST" action="login" accept-charset="UTF-8">

				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input class="form-control" name="email" type="email" id="email" placeholder="EMAIL">
				<input class="form-control" name="password" type="password" value="" id="password" placeholder="PASSWORD">

			<u><a href="{{ url('password/reset') }}">forgot ?</a></u><br><br>


			<input onclick="this.style.backgroundColor = '#69c061';" type="submit" value="LOGIN"/>
			</form>


			<div class="signup">
				<p>not a member ? <a href="{{ url('auth/register') }}">sign up</a></p>
			</div>
		</div>
	</div>

@endsection