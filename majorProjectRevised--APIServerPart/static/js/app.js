document.addEventListener('DOMContentLoaded', ()=>{
		var startBtn = document.querySelector('#startBtn');
		var stopBtn = document.querySelector('#stopBtn');
		var video = document.querySelector('#videoElement');
		var canvas = document.querySelector("#canvasElement");
			video.style.display = 'none';
			canvas.style.display = 'none';
		var ctx = canvas.getContext('2d');

		var canvasImage = document.querySelector('#canvasImage');

		M.FormSelect.init(document.querySelectorAll('select'));

		var interval;

		var select = document.querySelector('select');
		var currentStream;
		let shouldStop = false;
		let stopped = false;
		var socket = io.connect(location.protocol + '//' + document.domain + ':' + location.port + '/test');

		socket.on('connect', function(){
			console.log('connected');
		});

		function stopMediaTracks(stream){
			stream.getTracks().forEach((track)=>{
				track.stop();
			});

			shouldStop = true;
		}

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

		// function blobToFile(theBlob, fileName){
		// 	//A Blob() is almost a File() - it's just missing the two properties below which we will add
		// 	theBlob.lastModifiedDate = new Date();
		// 	theBlob.name = fileName;
		// 	return theBlob;
		// }


		function startSending(stream) {
			// const options = {mimeType: 'video/webm'};
			// const recordedChunks = [];
    		const mediaRecorder = new MediaRecorder(stream);


			mediaRecorder.addEventListener('dataavailable', function(e) {
				// if (e.data.size > 0) {
				// 	recordedChunks.push(e.data);
				// }

				if(shouldStop === true && stopped === false) {
					mediaRecorder.stop();
					stopped = true;
				}
			});

			mediaRecorder.start();

			interval = setInterval(()=>{
				// var blob = new Blob(recordedChunks.splice(0,recordedChunks.length));
				// var file = new File([blob], `videoChunk@${new Date()}.mp4`);
				// var data = new FormData();
				// data.append('file', blob);
				  // here we both empty the 'chunks' array, and send its content to the server
				//   console.log(new Blob(recordedChunks.splice(0,recordedChunks.length)));
				// console.log('I am called');
				canvas.width = video.videoWidth;
				canvas.height = video.videoHeight;
				canvas.style.width = `${video.videoWidth}px`;
				canvas.style.height = `${video.videoHeight}px`;

				ctx.drawImage(video, 0, 0, video.videoWidth, video.videoHeight, 0, 0, video.videoWidth, video.videoHeight);
				var dataURL = canvas.toDataURL('image/jpeg');
				socket.emit('input image', dataURL);
				canvasImage.src = location.protocol + '//' + document.domain + ':' + location.port + '/video_feed';
			}, 50);

		}




		navigator.mediaDevices.enumerateDevices()
		.then(gotDevices)
		.catch((err)=> console.log(err));

		// startBtn.addEventListener('click', ()=>{
		// 	navigator.mediaDevices.enumerateDevices()
		// 	.then(gotDevices)
		// 	.catch((err)=> console.log(err));

		// 	if (typeof currentStream !== 'undefined') {
		// 		stopMediaTracks(currentStream);
		// 	}

		// 	const videoConstraints = {};
		// 	if (select.value === '') {
		// 		videoConstraints.facingMode = 'environment';
		// 	} else {
		// 		videoConstraints.deviceId = { exact: select.value };
		// 	}

		// 	const constraints = {
		// 		video: videoConstraints,
		// 		audio: false
		// 	};
			
		// 	navigator.mediaDevices.getUserMedia(constraints).then((stream)=>{
		// 		currentStream = stream;
		// 		video.srcObject = stream;
		// 		video.play();
				
		// 		startSending(stream);

		// 	})
		// 	.catch((err)=>console.log(err));

		// });

		// stopBtn.addEventListener('click', ()=>{
		// 	canvasImage.src = '';
		// 	stopMediaTracks(currentStream);
		// 	clearInterval(interval);
		// 	// canvasImage.style.display = 'none';
		// });

	});