<!DOCTYPE html>
<html lang="en">
<head>
	@include('partials.meta')
	@include('partials.styles')
	@yield('additionalCSS')  
</head>
<body>
	<header>
		@include('partials.navigation')
	</header>

	<main>
		<h4 class="heading center" style="margin-bottom: 100px;">@yield('heading', 'DETECTION ZONE')</h4>

		@if(Request::is('admin'))
		 <div class="row center">
		 	<div class="col s12 m6 offset-m3">
		 		<select name="cameraId" id="cameraId">
		 			<option value="" disabled selected>Choose Camera</option>
		 		</select>
		 	</div>
		 	<div class="col s12 m6 offset-m3">		
		 		<a id="startBtn" class="btn waves-light waves-effect">Start Detection</a>
		 	</div>
		 </div>
		@endif

		@yield('main')
	</main>

	@if(session('flashMessage'))
	<div class="flash-message">
		{{ session('flashMessage') }}
	</div>
	@endif
	<script type="text/javascript" src="{{asset('js/socket.io.js')}}"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	
	<script type="text/javascript">
		window.axios = axios;
		let token = document.head.querySelector('meta[name="csrf-token"]');

		if (token) {
			window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
		} else {
			console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
		}

		document.addEventListener('DOMContentLoaded', function() {
			var elems = document.querySelectorAll('.sidenav');
			var instances = M.Sidenav.init(elems, { edge: 'left', draggable:true });
			var audio = new Audio("{{asset('storage/alert.mp3')}}");

			var socket = io.connect('http://127.0.0.1:5150/test');

			window.socket = socket;

			socket.on('connect', function(){
				console.log('connected');
				socket.emit('my event', {data: 'I\'m connected!'});
				axios.get('http://127.0.0.1:8000/admin/added-suspects')
					 .then( success => {
						console.log('All Suspects: ', success.data.suspects);
						socket.emit('all suspects', success.data.suspects);
					 })
					 .catch( error => {
						console.log(error);
					 });
					 
				console.log('emitted')
			});

			socket.on('hello', function(e) {
				console.log('it was emitted from flask side');
				console.log(e.data);
			});

			socket.on('generated embedding', function(event){
				console.log(event.embedding);

				axios.post('http://127.0.0.1:8000/admin/add-embedding', {
					id: event.id,
					embedding: event.embedding,
				}).then( success => {
					console.log('embedding saved');
				}).catch( error => {
					console.log('error while saving embedding');
				});
			});

			socket.on('embedding generation failed', function(e){
				axios.post(`http://127.0.0.1:8000/admin/suspects/${e.id}/delete`, { _method: 'DELETE'})
					 .then( success => {
						M.toast({
							html: 'Embedding generation failed so the record has been deleted',
							classes: 'rounded'
						});
					 })
					 .catch(error =>{
						 console.log(error);
						M.toast({
							html: 'Suspect record deletion failed',
							classes: 'rounded'
						});
					 });
			});

			// var previousSuspectId = null;
			socket.on('suspect detected', function(e){
				// console.log(previousSuspectId!=e.id);
				axios.post('http://127.0.0.1:8000/admin/detected-suspects/'+e.id)
					.then( success => {
						if(success.data.message=='attached'){
							// console.log(previousSuspectId!=e.id);

							// if(previousSuspectId!=e.id){
								M.toast({
									html: 'New suspect detected, please see the detected suspect in your detection zone',
									classes: 'rounded'
								});
								console.log('suspect detected: ', e.id);
								// audio.play();
							// }
						}else if(success.data.message=='exists'){
							// console.log(previousSuspectId!=e.id);
							// if(previousSuspectId!=e.id){
								M.toast({
									html: 'Previously detected suspect has again been detected',
									classes: 'rounded'
								});
								console.log('suspect already detected: ', e.id);
								// audio.play();						
							// }
						}
					})
					.catch( error => {
						console.log('suspect attaching failed');
					});
				previousSuspectId = e.id;
			});


			@if(Request::is('admin'))
				var select = document.querySelector('select');

				navigator.mediaDevices.enumerateDevices()
				.then(gotDevices)
				.catch((err)=> console.log(err));

				document.querySelector('#startBtn').addEventListener('click', function(){
					window.open(`http://127.0.0.1:5150/detection-zone`, '_blank');
					// audio.play();
				});


				function gotDevices(devices){
					select.innerHTML = '';
					select.innerHTML = '<option value="" disabled selected>Choose Camera</option>';

					devices = devices.filter((d)=> d.kind==='videoinput');
					devices.forEach((d,index)=>{
						const option = document.createElement('option');
						option.value = d.deviceId;
						const label = d.label || `Camera ${index+1}`;
						const textNode = document.createTextNode(label);
						option.appendChild(textNode);
						select.appendChild(option);
					});

					var elems = document.querySelectorAll('select');
					var instances = M.FormSelect.init(elems);
				}
			@endif

		@if(session('flashMessage'))	
		    // Flash Message Disappearing animation
		    var flashElem = document.querySelector('.flash-message');
		    setTimeout(function(){flashElem.style.animation = 'fadeOut 5s'},2000);
		    setTimeout(function(){
		    	flashElem.style.display = 'none';
		    },7000);
		 @endif
		});
	</script>

	@yield('additionalJS')
</body>
</html>
