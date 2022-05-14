<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">	
	<title>Register | Criminal Detector</title>
<!-- Compiled and minified CSS -->
<link rel="stylesheet" href="{{asset('css/materialize.min.css')}}">
<!-- ICONS -->
<link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">
<!-- Compiled and minified JavaScript -->
<script src="{{asset('js/materialize.min.js')}}"></script>
	<!-- CSS Styles -->
	<style type="text/css">
		*{
			margin: 0;
			box-sizing: border-box;
		}

		html,body{
			height: 100vh;
			background: linear-gradient(#0d47a1 50%, #e0e0e0 50%);
			background-repeat: no-repeat;
			color: #636b6f;
		}

		.invalid-feedback{
			color: red;
			padding-left: 45px !important;
		}

		.btn-block{
			width: 100% !important;
		}

		i{
			line-height: 1 !important;
		}
	</style>
</head>
<body>
	<div class="row">
		<div class="col s12 m6 l3" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%,-50%);">
			<div class="card">
				<div class="card-content">
					<span class="card-title center">
						<h5>Registration Portal</h5>
						<br>
						<sub>Please, fill the following information to get registered.</sub>
					</span>
					<br>
					<form action="/register" method="POST">
						{{csrf_field()}}
						<div class="input-field">
							<i class="mdi mdi-account prefix"></i>
							<label for="name">Full Name</label>
							<input type="text" id="name" name="name" required autofocus>
							@if($errors->has('name'))
							<span class="invalid-feedback">
								{{$errors->first('name')}}
							</span>
							@endif						</div>			      
						<div class="input-field">
							<i class="mdi mdi-email prefix"></i>
							<label for="email">E-mail</label>
							<input type="email" id="email" name="email" required>
							@if($errors->has('email'))
							<span class="invalid-feedback">
								{{$errors->first('email')}}
							</span>
							@endif						</div>			      
						<div class="input-field">
							<i class="mdi mdi-key prefix"></i>
							<label for="password">Password</label>
							<input type="password" id="password" name="password" required>
							@if($errors->has('confirm_password'))
							<span class="invalid-feedback">
								{{$errors->first('confirm_password')}}
							</span>
							@endif 			      
						</div>
						<div class="input-field">
							<i class="mdi mdi-checkbox-multiple-marked-circle prefix"></i>
							<label for="password_confirmation">Confirm Password</label>
							<input type="password" id="password_confirmation" name="password_confirmation">
						</div>

						<div class="input-field">
							<button class="btn btn-block blue waves-effect waves-light" type="submit">Register</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>