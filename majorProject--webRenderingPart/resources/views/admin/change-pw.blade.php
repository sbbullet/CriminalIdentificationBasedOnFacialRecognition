@extends('admin.dashboard')

@section('additionalCSS')
@endsection

@section('heading', 'Change Your Admin Password')

@section('main')
<div class="row">
	<div class="col s12 m8 l6 offset-m2 offset-l3">
		<form action="/admin/change-pw" method="POST">
			{{csrf_field()}}
			<div class="input-field">
				<i class="mdi mdi-textbox-password prefix"></i>
				<label for="oldPw">Old Password</label>
				<input type="password" name="oldPw" id="oldPw" required>
				@if($errors->has('oldPw'))
				<span class="red-text">
					<strong>{{$errors->first('oldPw')}}</strong>
				</span>
				@endif
			</div>			
			<div class="input-field">
				<i class="mdi mdi-new-box prefix"></i>
				<label for="newPw">New Password</label>
				<input type="password" name="newPw" id="newPw" required>
				@if($errors->has('newPw'))
				<span class="invalid-feedback">
					<strong>{{$errors->first('newPw')}}</strong>
				</span>
				@endif
			</div>			

			<div class="input-field">
				<i class="mdi mdi-checkbox-multiple-marked-circle-outline prefix"></i>
				<label for="newPw_confirmation">Confirm Password</label>
				<input type="password" name="newPw_confirmation" id="newPw_confirmation" required>
				@if($errors->has('newPw_confirmation'))
				<span class="red-text">
					<strong>{{$errors->first('newPw_confirmation')}}</strong>
				</span>
				@endif
			</div>
			<div class="input-field">
				<button type="submit" class="btn btn-block btn-small blue lighten-2">Change Password</button>
			</div>
		</form>
	</div>
</div>
@endsection

@section('additionalJS')
@endsection
