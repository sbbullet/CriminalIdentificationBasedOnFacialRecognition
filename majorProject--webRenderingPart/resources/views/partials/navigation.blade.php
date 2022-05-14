<nav class="teal">
	<a href="/" class="brand-logo">&nbsp;&nbsp;&nbsp;CD</a>
	<a data-target="slide-out" class="sidenav-trigger hide-on-large-only">
		<i class="mdi mdi-menu" style="font-size: 24px;"></i>
	</a>		
</nav>

<ul id="slide-out" class="sidenav sidenav-fixed grey lighten-4">
	<li>
		<div class="user-view">
			<div class="background">
				<img src="{{asset('images/sidebar.jpg')}}" style="filter: brightness(0.8)" alt="Side navigation background image." title="Side navigation background image.">
			</div>
			<a><img class="circle" src="{{ asset('storage/uploads/'.Auth::user()->dp) }}"></a>
			<a><span class="white-text name">{{Auth::user()->name}}</span></a>
			<a><span class="white-text email">{{Auth::user()->email}}</span></a>
		</div>
	</li>

	<li class="{{ Request::is('admin') ? 'active' : ''}}">
		<a href="/admin"><i class="mdi mdi-home"></i>HOME</a>
	</li>

	<li class="{{ Request::is('admin/detected-suspects') ? 'active' : ''}}">
		<a href="/admin/detected-suspects"><i class="mdi mdi-account-group"></i>DETECTED SUSPECTS</a>
	</li>

	<li class="{{ Request::is('admin/add-suspect') ? 'active' : ''}}">
		<a href="/admin/add-suspect"><i class="mdi mdi-account-plus"></i>ADD SUSPECTS</a>
	</li>
	
	<li>
		<div class="divider"></div>
	</li>

	<li>
		<a href="/admin/edit-profile" class="btn blue waves-effect waves-light">EDIT PROFILE</a>
	</li>

	<li>
		<a href="/admin/change-pw" class="btn blue waves-effect waves-light">CHANGE PASSWORD</a>
	</li>

	<li>
		<a href="/admin/logout" class="btn blue waves-effect waves-light">LOGOUT</a>
	</li>
</ul>