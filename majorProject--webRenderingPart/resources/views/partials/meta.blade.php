<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="noindex">	
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Admin Dashboard </title>
<!-- Compiled and minified CSS -->
<link rel="stylesheet" href="{{asset('css/materialize.min.css')}}">
<!-- Favicon -->
<link rel="icon" type="image/*" href="{{asset('storage/uploads/'.Auth::user()->dp)}}">
<!-- Compiled and minified JavaScript -->
<script src="{{asset('js/materialize.min.js')}}"></script>
<!-- ICONS -->
<link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}">