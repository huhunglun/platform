<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">

			<!-- Collapsed Hamburger -->
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<!-- Branding Image -->
			<a class="navbar-brand" href="{{ url('/') }}">思購易AR測試後台</a>
		</div>

		<div class="collapse navbar-collapse" id="app-navbar-collapse">
			<!-- Left Side Of Navbar -->
			@if(!(auth()->guest()))
				@include('layouts.menu')
			@endif

			<!-- Right Side Of Navbar -->
			<ul class="nav navbar-nav navbar-right">
				<!-- Authentication Links -->
				@if (Auth::guest())
					{{--<li><a href="{{ url('/login') }}">登入</a></li>--}}
					{{--<li><a href="{{ url('/register') }}">註冊</a></li>--}}
				@else
					@can('hasAdminRight',auth()->user())
					<li><a href="/admin">經銷商/自營商管理</a></li>
					@endcan
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							{{ Auth::user()->name }} <span class="caret"></span>
						</a>

						<ul class="dropdown-menu" role="menu">
							<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>登出</a></li>
						</ul>
					</li>
				@endif
			</ul>
		</div>
	</div>
</nav>