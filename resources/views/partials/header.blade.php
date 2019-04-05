<header id="m_header" class="m-grid__item m-header "  m-minimize="minimize" m-minimize-mobile="minimize" m-minimize-offset="10" m-minimize-mobile-offset="10" >
	<div class="m-header__top">
		<div class="m-container m-container--fluid m-container--full-height m-page__container">
			<div class="m-stack m-stack--ver m-stack--desktop">
				<!-- begin::Brand -->
				<div class="m-stack__item m-brand m-stack__item--left">
					<div class="m-stack m-stack--ver m-stack--general m-stack--inline">
						<div class="m-stack__item m-stack__item--middle m-brand__logo">
							<a href="{{ route('dashboard.report.index') }}" class="m-brand__logo-wrapper">
								<img alt="" src="/template/app/media/img/icons/DDlogo.png" class="m-brand__logo-desktop" style="width: 40%;" />
								<img alt="" src="/template/app/media/img/icons/DDlogo.png" class="m-brand__logo-mobile" style="width: 40%;" />
							</a>
						</div>
					</div>
				</div>
				<!-- end::Brand -->		
				<!-- begin::Topbar -->
				<div class="m-stack__item m-stack__item--right m-header-head" id="m_header_nav">
					<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
						<div class="m-stack__item m-topbar__nav-wrapper">
							<ul class="m-topbar__nav m-nav m-nav--inline">

								<li class="m-nav__item m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
									<a href="#" class="m-nav__link m-dropdown__toggle">
										<span class="m-topbar__userpic">
											<i class="flaticon-user m--img-rounded m--marginless m--img-centered" style="font-size: 3rem;"></i>
											<!-- <img src="/template/app/media/img/users/user4.jpg" class="m--img-rounded m--marginless m--img-centered" alt=""/> -->
										</span>
										<span class="m-nav__link-icon m-topbar__usericon  m--hide">
											<span class="m-nav__link-icon-wrapper">
												<i class="flaticon-user-ok"></i>
											</span>
										</span>
										<span class="m-topbar__username m--hide">
											
										</span>
									</a>

									<div class="m-dropdown__wrapper" style="z-index: 101;">
										<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 13px;"></span>
										<div class="m-dropdown__inner">
											<div class="m-dropdown__header m--align-center" style="background: url(/template/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
												<div class="m-card-user m-card-user--skin-dark">
													<div class="m-card-user__pic">
														<i class="flaticon-user m--img-rounded m--marginless m--img-centered" style="font-size: 3rem; color: white;"></i>
														<!-- <img src="../../assets/app/media/img/users/user4.jpg" class="m--img-rounded m--marginless" alt=""> -->
													</div>
													<div class="m-card-user__details">
														<span class="m-card-user__name m--font-weight-500">
															{{ Auth::user()->name }}
														</span>
														<a href="" class="m-card-user__email m--font-weight-300 m-link">
															{{ Auth::user()->email }}
														</a>
													</div>
												</div>
											</div>
											<div class="m-dropdown__body">
												<div class="m-dropdown__content">
													<ul class="m-nav m-nav--skin-light">
														<li class="m-nav__section m--hide">
															<span class="m-nav__section-text">
																Section
															</span>
														</li>
														<li class="m-nav__item">
															<a href="{{ route('logout') }}" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder"
								                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								                                <i class="lnr lnr-exit"></i> <span>{{ __('Logout') }}</span>
								                            </a>
								                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								                                @csrf
								                            </form>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end::Topbar -->
			</div>
		</div>
	</div>
	<div class="m-header__bottom">
		<div class="m-container m-container--fluid m-container--full-height m-page__container">
			<div class="m-stack m-stack--ver m-stack--desktop">
				<!-- begin::Horizontal Menu -->
				<div class="m-stack__item m-stack__item--fluid m-header-menu-wrapper">
					<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn">
						<i class="la la-close"></i>
					</button>
					<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light "  >
						<ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
							<li class="m-menu__item @yield('dashboard-active')  m-menu__item--submenu m-menu__item--tabs" aria-haspopup="true">
								<a  href="{{ route('dashboard.report.index') }}" class="m-menu__link">
									<span class="m-menu__link-text">
										Dashboard
									</span>
									<i class="m-menu__hor-arrow la la-angle-down"></i>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs">
									<span class="m-menu__arrow m-menu__arrow--adjust"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item @yield('sub-header-report-active')"  m-menu-link-redirect="1" aria-haspopup="true">
											<a  href="{{ route('dashboard.report.index') }}" class="m-menu__link ">
												<i class="m-menu__link-icon flaticon-file"></i>
												<span class="m-menu__link-text">
													Reports
												</span>
											</a>
										</li>

										<li class="m-menu__item @yield('sub-header-ipn-active')"  m-menu-link-redirect="1" aria-haspopup="true">
											<a  href="{{ route('dashboard.ipn.index') }}" class="m-menu__link ">
												<i class="m-menu__link-icon flaticon-support"></i>
												<span class="m-menu__link-text">
													IPN
												</span>
											</a>
										</li>

										<li class="m-menu__item @yield('sub-header-autologin-active')"  m-menu-link-redirect="1" aria-haspopup="true">
											<a  href="{{ route('dashboard.autologin-logs.index') }}" class="m-menu__link ">
												<i class="m-menu__link-icon flaticon-logout"></i>
												<span class="m-menu__link-text">
													Autologin Logs
												</span>
											</a>
										</li>

										<li class="m-menu__item @yield('sub-header-manual-active')"  m-menu-link-redirect="1" aria-haspopup="true">
											<a  href="{{ route('dashboard.manual-cancellations.index') }}" class="m-menu__link ">
												<i class="m-menu__link-icon flaticon-cancel"></i>
												<span class="m-menu__link-text">
													Manual Cancellations
												</span>
											</a>
										</li>

										<li class="m-menu__item @yield('sub-header-memberium-active')"  m-menu-link-redirect="1" aria-haspopup="true">
											<a  href="{{ route('dashboard.memberium-cancellations.index') }}" class="m-menu__link ">
												<i class="m-menu__link-icon flaticon-reply"></i>
												<span class="m-menu__link-text">
													Memberium Cancellations
												</span>
											</a>
										</li>


										<li class="m-menu__item @yield('sub-header-sync-logs-active')"  m-menu-link-redirect="1" aria-haspopup="true">
											<a  href="{{ route('dashboard.sync-logs.index') }}" class="m-menu__link ">
												<i class="m-menu__link-icon flaticon-refresh"></i>
												<span class="m-menu__link-text">
													Sync Logs
												</span>
											</a>
										</li>

										<li class="m-menu__item @yield('sub-header-upsell-logs-active')"  m-menu-link-redirect="1" aria-haspopup="true">
											<a  href="{{ route('dashboard.upsell-logs.index') }}" class="m-menu__link ">
												<i class="m-menu__link-icon flaticon-graph"></i>
												<span class="m-menu__link-text">
													UpSell Logs
												</span>
											</a>
										</li>

									</ul>
								</div>
							</li>
							<li class="m-menu__item @yield('users-active') m-menu__item--submenu m-menu__item--tabs"  m-menu-submenu-toggle="tab" aria-haspopup="true">
								<a  href="{{ route('users') }}" class="m-menu__link">
									<span class="m-menu__link-text">
										Users
									</span>
									<i class="m-menu__hor-arrow la la-angle-down"></i>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs">
									<span class="m-menu__arrow m-menu__arrow--adjust"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item @yield('sub-header-users-active')"  m-menu-link-redirect="1" aria-haspopup="true">
											<a  href="{{ route('users') }}" class="m-menu__link ">
												<i class="m-menu__link-icon flaticon-graphic-2"></i>
												<span class="m-menu__link-text">
													List
												</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="m-menu__item @yield('products-active') m-menu__item--submenu m-menu__item--tabs"  m-menu-submenu-toggle="tab" aria-haspopup="true">
								<a  href="{{ route('products') }}" class="m-menu__link">
									<span class="m-menu__link-text">
										Products
									</span>
									<i class="m-menu__hor-arrow la la-angle-down"></i>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs">
									<span class="m-menu__arrow m-menu__arrow--adjust"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item @yield('sub-header-products-active')"  m-menu-link-redirect="1" aria-haspopup="true">
											<a  href="{{ route('products') }}" class="m-menu__link ">
												<i class="m-menu__link-icon flaticon-graphic-2"></i>
												<span class="m-menu__link-text">
													List
												</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="m-menu__item @yield('system-settings-active') m-menu__item--submenu m-menu__item--tabs"  m-menu-submenu-toggle="tab" aria-haspopup="true">
								<a  href="{{ route('system') }}" class="m-menu__link">
									<span class="m-menu__link-text">
										System
									</span>
									<i class="m-menu__hor-arrow la la-angle-down"></i>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs">
									<span class="m-menu__arrow m-menu__arrow--adjust"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item @yield('sub-header-system-settings-active')"  m-menu-link-redirect="1" aria-haspopup="true">
											<a  href="{{ route('system') }}" class="m-menu__link ">
												<i class="m-menu__link-icon flaticon-graphic-2"></i>
												<span class="m-menu__link-text">
													List
												</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="m-menu__item @yield('domains-active') m-menu__item--submenu m-menu__item--tabs"  m-menu-submenu-toggle="tab" aria-haspopup="true">
								<a  href="{{ route('domains') }}" class="m-menu__link">
									<span class="m-menu__link-text">
										Domains
									</span>
									<i class="m-menu__hor-arrow la la-angle-down"></i>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs">
									<span class="m-menu__arrow m-menu__arrow--adjust"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item @yield('sub-header-domains-active')"  m-menu-link-redirect="1" aria-haspopup="true">
											<a  href="{{ route('domains') }}" class="m-menu__link ">
												<i class="m-menu__link-icon flaticon-graphic-2"></i>
												<span class="m-menu__link-text">
													List
												</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="m-menu__item @yield('orders-active') m-menu__item--submenu m-menu__item--tabs"  m-menu-submenu-toggle="tab" aria-haspopup="true">
								<a  href="{{ route('orders.index') }}" class="m-menu__link">
									<span class="m-menu__link-text">
										Orders
									</span>
									<i class="m-menu__hor-arrow la la-angle-down"></i>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left m-menu__submenu--tabs">
									<span class="m-menu__arrow m-menu__arrow--adjust"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item @yield('sub-header-orders-active')"  m-menu-link-redirect="1" aria-haspopup="true">
											<a  href="{{ route('orders.index') }}" class="m-menu__link ">
												<i class="m-menu__link-icon flaticon-graphic-2"></i>
												<span class="m-menu__link-text">
													List
												</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<!-- end::Horizontal Menu -->
			</div>
		</div>
	</div>
</header>
<!-- end::Header -->	
