$(document).ready(function(){
  let namespace = "/test";
  let video = document.querySelector("#videoElement");
  let canvas = document.querySelector("#canvasElement");
  let imageElement = document.querySelector('#imageElement');
  let ctx = canvas.getContext('2d');

  var localMediaStream = null;

  var socket = io.connect(location.protocol + '//' + document.domain + ':' + location.port + namespace);

  function sendSnapshot() {
    if (!localMediaStream) {
      return;
    }
    canvas.height = video.videoHeight;
    canvas.width = video.videoWidth;
    canvas.style.height = `${video.videoHeight}px`;
    canvas.style.width = `${video.videoWidth}px`;
    ctx.drawImage(video, 0, 0, video.videoWidth, video.videoHeight, 0, 0, video.videoWidth, video.videoHeight);

    let dataURL = canvas.toDataURL('image/jpeg', 1);
    socket.emit('input image', dataURL);

  }

  socket.on('connect', function() {
    console.log('connected!');
  });

  var constraints = {
    audio: false,
    video: true,
  };

  navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
    video.srcObject = stream;
    localMediaStream = stream;

    setInterval(function () {
      sendSnapshot();
    }, 1000);
  }).catch(function(error) {
    console.log(error);
  });
});

