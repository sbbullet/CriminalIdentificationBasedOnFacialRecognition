@extends('admin.dashboard')

@section('additionalCSS')
<style type="text/css">

</style>
@endsection

@section('heading', 'ADD SUSPECT')

@section('main')
<div class="row">
	<div class="col s12 m8 l6 offset-m2 offset-l3">
		<form id="addSuspect" method="POST" enctype="multipart/form-data">
			{{csrf_field()}}

			<div class="input-field">
				<i class="mdi mdi-account prefix"></i>
				<label for="fullName">Full Name</label>
				<input type="text" name="fullName" id="fullName">
				@if($errors->has('fullName'))
				<span class="invalid-feedback">
					<strong>{{$errors->first('fullName')}}</strong>
				</span>
				@endif
			</div>			
			<div class="input-field">
				<i class="mdi mdi-map-marker prefix"></i>
				<label for="address">Address</label>
				<input type="text" name="address" id="address">
				@if($errors->has('address'))
				<span class="invalid-feedback">
					<strong>{{$errors->first('address')}}</strong>
				</span>
				@endif
			</div>
			<div class="file-field input-field">
				<div class="btn">
					<span>Photo</span>
					<input type="file" name="file" required>
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
				<button type="submit" class="btn btn-block btn-small blue lighten-2">Add</button>
			</div>
		</form>
	</div>
</div>
<div class="row center">
<!-- <img id="imageElement" height="100" width="250"> -->
</div>

<br>
	<h4 class="heading center">Added Suspects</h4>

	<div class="row grid">
	@if($addedSuspects->count() > 0)
		@foreach($addedSuspects as $suspect)
		<div class="col s12 m4 l2 with-card">
			<div class="card">
				<div class="card-image">
					<img src="{{$suspect->photo_path}}">
				</div>
				<div class="card-content">
					<span class="card-title">{{ $suspect->name }}</span>
					<p>{{ $suspect->address }}</p>
				</div>
				<div class="card-action">
					<form action="/admin/suspects/{{$suspect->id}}/delete" method="POST">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-flat red-text">Delete</button>
					</form>
				</div>
			</div>
		</div>
		@endforeach
	@else
	 	<div class="center">No suspects added in the database to this date</div>
	@endif
</div>
@endsection

@section('additionalJS')
<script>
	document.querySelector('#addSuspect').addEventListener('submit', function(e) {
		e.preventDefault();

		var formData = new FormData(document.querySelector('#addSuspect'));

		axios.post('http://127.0.0.1:8000/admin/add-suspect', formData)
		.then(success => {
			socket.emit('add image', success.data);
			console.log(success);
			alert('successfully added');
			document.querySelector('#addSuspect').reset();
		})
		.catch(error => {
			console.log(error);
		});

	});
</script>
@endsection