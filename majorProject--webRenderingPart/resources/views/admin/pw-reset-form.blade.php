<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="application-name" content="Reshma Chettri">
	<meta name="robots" content="noindex">	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">	
	<title>Admin Password Reset</title>
	<!-- Compiled CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
	<!-- Material Icons -->
	<link rel="stylesheet" href="//cdn.materialdesignicons.com/3.3.92/css/materialdesignicons.min.css">

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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>
</head>
<body>
	<div class="row">
		<div class="col s12 m6 l3" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%,-50%);">
			<div class="card">
				<div class="card-content">
					<span class="card-title center">
						<h5>Admin Password Reset Form</h5>
						<br>
						<sub>Please, input following details and you'll be good go</sub>
					</span>
					<br>
					<form action="/admin/reset-password" method="POST">
						{{csrf_field()}}
						<input type="hidden" name="token" value="{{ $token }}">
						<div class="input-field">
							<i class="mdi mdi-email prefix"></i>
							<label for="email">Email</label>
							<input type="email" name="email" id="email" value="{{old('email')}}" required autofocus>
							@if($errors->has('email'))
							<span class="invalid-feedback">
								<strong>{{$errors->first('email')}}</strong>
							</span>
							@endif
						</div>				
						<div class="input-field">
							<i class="mdi mdi-new-box prefix"></i>
							<label for="password">New Password</label>
							<input type="password" name="password" id="password" required>
							@if($errors->has('password'))
							<span class="invalid-feedback">
								<strong>{{$errors->first('password')}}</strong>
							</span>
							@endif
						</div>			

						<div class="input-field">
							<i class="mdi mdi-checkbox-multiple-marked-circle-outline prefix"></i>
							<label for="password_confirmation">Confirm Password</label>
							<input type="password" name="password_confirmation" id="password_confirmation" required>
							@if($errors->has('password_confirmation'))
							<span class="red-text">
								<strong>{{$errors->first('password_confirmation')}}</strong>
							</span>
							@endif
						</div>
						<div class="input-field">
							<button type="submit" class="btn btn-block btn-small blue">Reset Password</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>































<div class="row">
	<div class="col s12 m8 l6 offset-m2 offset-l3">

	</div>
</div>
