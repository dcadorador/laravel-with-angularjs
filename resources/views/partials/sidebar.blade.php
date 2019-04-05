<div id="sidebar-nav" class="sidebar">
	<div class="sidebar-scroll">
		<nav>
			<ul class="nav">
				<li><a href="{{ url('home') }}" class="@yield('dashboard-active')"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
				<li><a href="{{ url('users') }}" class="@yield('user-active')"><i class="lnr lnr-code"></i> <span>Users</span></a></li>
				<li><a href="{{ url('products') }}" class="@yield('product-active')"><i class="lnr lnr-chart-bars"></i> <span>Products</span></a></li>
				<li><a href="{{ url('system') }}" class="@yield('system-active')"><i class="lnr lnr-cog"></i> <span>System</span></a></li>
				<li><a href="{{ url('domains') }}" class="@yield('domain-active')"><i class="lnr lnr-alarm"></i> <span>Domains</span></a></li>
			</ul>
		</nav>
	</div>
</div>