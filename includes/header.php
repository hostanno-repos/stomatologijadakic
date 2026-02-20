<header id="header" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': false, 'stickyStartAt': 53, 'stickySetTop': '-53px'}">
	<div class="header-body border-top-0 h-auto box-shadow-none">
		<div class="header-top border-width-1">
			<div class="container-fluid px-lg-5 h-100">
				<div class="header-row h-100">
					<div class="header-column justify-content-start">
						<div class="header-row">
							<nav class="header-nav-top">
								<ul class="nav nav-pills">
									<li class="nav-item py-2 d-none d-sm-inline-flex pe-2">
										<span class="ps-0 font-weight-semibold text-color-default text-2"><i class="icon-location-pin icons text-color-tertiary p-relative top-3 text-4-5"></i> <?php echo function_exists('getContent') ? getContent('header', 'address', 'Nikole Tesle 23/4, 76300 Bijeljina') : 'Nikole Tesle 23/4, 76300 Bijeljina'; ?></span>
									</li>
								</ul>
							</nav>
						</div>
					</div>
					<div class="header-column justify-content-end">
						<div class="header-row">
							<nav class="header-nav-top">
								<ul class="nav nav-pills p-relative bottom-2">
									<li class="nav-item py-2 d-none d-md-inline-flex">
										<a href="mailto:<?php echo function_exists('getContent') ? getContent('header', 'email', 'info@stomatologijadakic.com') : 'info@stomatologijadakic.com'; ?>" class="text-2 font-weight-semibold text-color-default text-color-hover-tertiary"><i class="icon-envelope icons text-color-tertiary p-relative top-3 text-4-5"></i> <?php echo function_exists('getContent') ? getContent('header', 'email', 'info@stomatologijadakic.com') : 'info@stomatologijadakic.com'; ?></a>
									</li>
									<li class="nav-item py-2 pe-2">
										<span class="text-2 font-weight-semibold text-color-default d-none d-lg-block"><i class="icon-clock icons text-color-tertiary p-relative top-3 text-4-5"></i> <?php echo function_exists('getContent') ? getContent('header', 'working_hours', 'Pon-Pet 9:00-18:00 / Sub-Ned - ZATVORENO') : 'Pon-Pet 9:00-18:00 / Sub-Ned - ZATVORENO'; ?></span>
									</li>
									<li class="nav-item py-2 pe-2">
										<a href="tel:<?php echo function_exists('getContent') ? str_replace(' ', '', getContent('header', 'phone', '+387 66 096 666')) : '+38766096666'; ?>" class="text-2 font-weight-semibold text-color-default text-color-hover-tertiary"><i class="icon-phone icons text-color-tertiary p-relative top-2 text-4-5"></i> <?php echo function_exists('getContent') ? getContent('header', 'phone', '+387 66 096 666') : '+387 66 096 666'; ?></a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="header-container header-container-height-sm container-fluid px-lg-5 p-static">
			<div class="header-row">
				<div class="header-column">
					<div class="header-row">
						<div class="header-logo">
							<a href="index.php">
								<img style="width:100%;max-width:270px;" src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('logo_header') : 'images/logo-horizontal.svg'); ?>">
							</a>
						</div>
					</div>
				</div>
				<div class="header-column justify-content-end justify-content-lg-center w-100">
					<div class="header-row">
						<div class="header-nav header-nav-line header-nav-bottom-line header-nav-bottom-line-effect-1 justify-content-lg-center ps-lg-5">
							<div class="header-nav-main header-nav-main-square header-nav-main-text-capitalize header-nav-main-text-size-4 header-nav-main-dropdown-no-borders header-nav-main-arrows header-nav-main-full-width-mega-menu header-nav-main-mega-menu-bg-hover header-nav-main-effect-2">
								<nav class="collapse">
									<ul class="nav nav-pills" id="mainNav">
										<li>
											<a href="index.php" class="nav-link <?php if($active == "home"){echo('active'); } ?>">
												<?php echo function_exists('getContent') ? getContent('header', 'menu_home', 'Početna') : 'Početna'; ?>
											</a>
										</li>
										<li>
											<a href="onama.php" class="nav-link <?php if($active == "onama"){echo('active'); } ?>">
												<?php echo function_exists('getContent') ? getContent('header', 'menu_about', 'O nama') : 'O nama'; ?>
											</a>
										</li>
										<li class="dropdown">
											<a class="nav-link dropdown-toggle <?php if($active == "usluge"){echo('active'); } ?>"><?php echo function_exists('getContent') ? getContent('header', 'menu_services', 'Usluge') : 'Usluge'; ?></a>
											<ul class="dropdown-menu">
												<li><a href="implantologija.php" class="dropdown-item">Implantologija</a></li>
												<li><a href="protetika.php" class="dropdown-item">Protetika</a></li>
												<li><a href="oralna-hirurgija.php" class="dropdown-item">Oralna hirurgija</a></li>
												<li><a href="endodoncija.php" class="dropdown-item">Endodoncija</a></li>
												<li><a href="estetska-medicina.php" class="dropdown-item">Estetska medicina</a></li>
												<!-- <li><a href="parodontologija.php" class="dropdown-item">Parodontologija</a></li> -->
												<li><a href="ortodoncija.php" class="dropdown-item">Ortodoncija</a></li>
												<li><a href="izbjeljivanje-zuba.php" class="dropdown-item">Izbjeljivanje zuba</a></li>
												<li><a href="rendgen-dijagnostika.php" class="dropdown-item">Rendgen dijagnostika</a></li>
												<li><a href="djecija-stomatologija.php" class="dropdown-item">Dječija stomatologija</a></li>
												<li><a href="konzervativna-stomatologija.php" class="dropdown-item">Konzervativna stomatologija</a></li>
												<li><a href="laseroterapija.php" class="dropdown-item">Laseroterapija</a></li>
											</ul>
										</li>
										<li>
											<a class="nav-link <?php if($active == "galerija"){echo('active'); } ?>" href="galerija.php">
												<?php echo function_exists('getContent') ? getContent('header', 'menu_gallery', 'Galerija') : 'Galerija'; ?>
											</a>
										</li>
										<li>
											<a class="nav-link <?php if($active == "novosti"){echo('active'); } ?>" target="_blank" href="novosti.php">
												<?php echo function_exists('getContent') ? getContent('header', 'menu_news', 'Novosti') : 'Novosti'; ?>
											</a>
										</li>
										<li>
											<a class="nav-link <?php if($active == "kontakt"){echo('active'); } ?>" href="kontakt.php">
												<?php echo function_exists('getContent') ? getContent('header', 'menu_contact', 'Kontakt') : 'Kontakt'; ?>
											</a>
										</li>
									</ul>
								</nav>
							</div>
							<button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
								<i class="fas fa-bars"></i>
							</button>
						</div>
						<div class="header-nav-features header-nav-features-no-border pe-3 order-1 order-lg-2">
							<div class="header-nav-feature header-nav-features-search d-inline-flex">
								<a href="#" class="header-nav-features-toggle text-decoration-none" data-focus="headerSearch" aria-label="Search"><i class="fas fa-search header-nav-top-icon text-4 p-relative top-3"></i></a>
								<div class="header-nav-features-dropdown" id="headerTopSearchDropdown">
									<form role="search" action="https://www.okler.net/previews/porto/9.9.2/page-search-results.html" method="get">
										<div class="simple-search input-group">
											<input class="form-control text-1" id="headerSearch" name="q" type="search" value="" placeholder="Search...">
											<button class="btn" type="submit" aria-label="Search">
												<i class="fas fa-search header-nav-top-icon"></i>
											</button>
										</div>
									</form>
								</div>
							</div>
							<div class="header-nav-feature header-nav-features-side-panel d-inline-flex ms-2">
								<a href="#" class="side-panel-toggle btn btn-quaternary custom-text-color-1 border-0 d-none d-lg-inline-block ms-2" data-extra-class="side-panel-right"><i class="fas fa-bars"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>