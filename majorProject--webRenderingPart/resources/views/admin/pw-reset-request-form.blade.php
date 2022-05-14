<!DOCTYPE html>
<html>
<head>
	<title>Admin Login</title>
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
					<span class="card-title center"><h5>Password Reset Request Form</h5><br><sub>Please, enter your email to get password reset link</sub></span>
					<br>

					@if(session('status'))
					<div class="center">
						<span class="green-text green-darken-4">
							<strong>We have mailed you the reset link.</strong>
						</span>
					</div>
					@endif
					<form action="/admin/forgot-password" method="POST">
						{{csrf_field()}}
						<div class="input-field">
							<i class="mdi mdi-email prefix"></i>
							<label for="email">E-mail</label>
							<input type="email" id="email" name="email" required autofocus>
							@if($errors->has('email'))
							<span class="invalid-feedback">
								{{$errors->first('email')}}
							</span>
							@endif 			      
						</div>

						<div class="input-field">
							<button class="btn btn-block blue waves-effect waves-light" type="submit">Send Reset Link</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>