@extends('admin.dashboard')

@section('additionalCSS')
@endsection

@section('heading', 'Edit Your Profile Details')


@section('main')
<div class="row">
	<div class="col s12 m8 l6 offset-m2 offset-l3">
		<form action="/admin/edit-profile" method="POST" enctype="multipart/form-data">
			{{csrf_field()}}
			{{method_field('PATCH')}}
			<div class="input-field">
				<i class="mdi mdi-account prefix"></i>
				<label for="fullName">Full Name</label>
				<input type="text" name="fullName" id="fullName" value="{{Auth::user()->name}}">
				@if($errors->has('fullName'))
				<span class="invalid-feedback">
					<strong>{{$errors->first('fullName')}}</strong>
				</span>
				@endif
			</div>			
			<div class="input-field">
				<i class="mdi mdi-email prefix"></i>
				<label for="email">Email</label>
				<input type="email" name="email" id="email" value="{{Auth::user()->email}}">
				@if($errors->has('email'))
				<span class="invalid-feedback">
					<strong>{{$errors->first('email')}}</strong>
				</span>
				@endif
			</div>
			<div class="file-field input-field">
				<div class="btn">
					<span>Profile Picture</span>
					<input type="file" name="file">
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate" type="text">
				</div>
				@if($errors->has('file'))
				<span class="invalid-feedback">
					<strong>{{$errors->first('file')}}</strong>
				</span> @endif
			</div>

			<div class="input-field">
				<button type="submit" class="btn btn-block btn-small blue lighten-2">Update</button>
			</div>
		</form>
	</div>
</div>
@endsection

@section('additionalJS')
@endsection
