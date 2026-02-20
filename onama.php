<!-- HEAD -->
<?php 
	include_once('includes/head.php'); 
	$active = "onama";
?>

	<body data-plugin-cursor-effect data-plugin-page-transition>
		
		<!-- SIDEMENU -->
		<?php include_once('includes/sidemenu.php'); ?>

		<div class="body">

			<!-- HEADER -->
			<?php include_once('includes/header.php'); ?>
			
			<div role="main" class="main">

				<section class="page-header page-header-modern bg-color-quaternary p-relative">
					<div class="container">
						<div class="row py-5">
							<div class="col-md-8 order-2 order-md-1 align-self-center p-static">
								<h1 class="text-color-dark font-weight-bold text-9"><?php echo function_exists('getContent') ? getContent('onama', 'page_title', 'O nama') : 'O nama'; ?></h1>
							</div>
							<div class="col-md-4 order-1 order-md-2 align-self-center">
								<ul class="breadcrumb d-flex justify-content-md-end text-4 font-weight-medium">
									<li class="text-capitalize"><a href="index.php" class="text-color-default text-color-hover-primary text-decoration-none text-capitalize">Početna</a></li>
									<li class="text-capitalize active">O nama</li>
								</ul>
							</div>
						</div>
					</div>
				</section>

				<div class="container pt-4 pb-5">
					<div class="row align-items-xl-center">
						<div class="col-lg-6 mb-5 mb-lg-0 text-center">

							<svg height="0" width="0">
								<defs>
									<clipPath id="svgPath">
										<path d="M143.3,391.5C64.74,320.29-11.54,212.43,1.46,109.91,6.81,67.72,35,23.31,77.51,11.57c45.8-12.65,81.56,9.87,127.88,10,51,.11,99.23-34,152.49-16.65C458.61,37.71,412.21,170.19,372,228c-10.63,15.3-44.76,63.1-48.29,40.44-9.23-59.24-26.68-67.61-57.52-75.23-32.68-8.07-80.24,8.61-92.4,39.25-26.47,66.76,31,137.89,64.57,191.19.89,1.42,38.8,48.72,31,50.86-21.12,5.77-69.06-37.36-84.67-48.95C171.14,415.52,157.18,404.08,143.3,391.5Z" style="fill:#000"/>
									</clipPath>
								</defs>
							</svg>	

							<img class="img-fluid" style="clip-path: url(#svgPath); min-height: 480px; max-width: 420px;" src="img/demos/dentist/generic/generic-5.jpg" alt="">

						</div>
						<div class="col-lg-6 ps-lg-4 ps-xl-5">
							<h3 class="text-color-dark text-9 line-height-3 text-transform-none font-weight-semibold mb-4 mb-lg-3 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250"><?php echo function_exists('getContent') ? getContent('onama', 'main_title', 'Dobrodošli na službenu stranicu Stomatologije Dakić') : 'Dobrodošli na službenu stranicu Stomatologije Dakić'; ?></h3>
							<p class="text-3-5 font-weight-medium pb-1 mb-4 mb-lg-2 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500"><?php echo function_exists('getContent') ? getContent('onama', 'description', 'Stomatološka ordinacija Dr Dakić osnovana je 2015. godine, a nalazi se u ulici Nikole Tesle 23/4 u Bijeljini.') : 'Stomatološka ordinacija Dr Dakić osnovana je 2015. godine, a nalazi se u ulici Nikole Tesle 23/4 u Bijeljini.'; ?></p>
							<div class="row align-items-center pb-2 mb-4 mb-lg-1 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750">
								<div class="col-5">
									<div class="d-flex">
										<span class="text-4 font-weight-bold text-color-dark pt-2 ms-2">
											<strong class="d-block font-weight-bold text-10 mb-2"><?php echo function_exists('getContent') ? getContent('onama', 'stats_number', '10000+') : '10000+'; ?></strong>
											<?php echo function_exists('getContent') ? getContent('onama', 'stats_text', 'Blistavih osmijeha') : 'Blistavih osmijeha'; ?>
										</span>
									</div>
								</div>
								<!-- <div class="col-7">
									<p class="mb-0">Cras a elit sit amet leo accumsan volutpat. Suspendisse. </p>
								</div> -->
							</div>
						</div>
					</div>
					<div class="row pt-5">
						<div class="col">
							<p class="font-weight-medium text-4-5 line-height-5"><?php echo function_exists('getContent') ? getContent('onama', 'services_intro', 'Uz upotrebu najsavremenijih metoda i materijala u našoj ordinaciji vršimo usluge iz sledećih oblasti stomatologije:') : 'Uz upotrebu najsavremenijih metoda i materijala u našoj ordinaciji vršimo usluge iz sledećih oblasti stomatologije:'; ?></p>
							<p class="text-3-5">
								<ul>
									<li>Implantologija</li>
									<li>Protetika</li>
									<li>Oralna hirurgija</li>
									<li>Endodoncija</li>
									<li>Estetska medicina</li>
									<!-- <li>Parodontologija</li> -->
									<li>Ortodoncija</li>
									<li>Izbjeljivanje zuba</li>
									<li>Rendgen dijagnostika</li>
									<li>Dječija stomatologija</li>
									<li>Konzervativna stomatologija</li>
									<li>Laseroterapija</li>
								</ul>
							</p>
						</div>
					</div>
					<div class="row pt-4">
						<div class="col-md-6 col-lg-3 mb-4 mb-lg-0 text-center">
							<img src="img/demos/dentist/services/service-1.jpg" class="img-fluid appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100" alt="">
						</div>
						<div class="col-md-6 col-lg-3 mb-4 mb-lg-0 text-center">
							<img src="img/demos/dentist/services/service-2.jpg" class="img-fluid appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="300" alt="">
						</div>
						<div class="col-md-6 col-lg-3 mb-4 mb-lg-0 text-center">
							<img src="img/demos/dentist/services/service-3.jpg" class="img-fluid appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500" alt="">
						</div>
						<div class="col-md-6 col-lg-3 mb-4 mb-lg-0 text-center">
							<img src="img/demos/dentist/services/service-4.jpg" class="img-fluid appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="700" alt="">
						</div>
					</div>
					<div class="row pt-5">
						<div class="col">
							<p class="text-3-5"><?php echo function_exists('getContent') ? getContent('onama', 'closing_text', 'Od momenta kada prvi put pređete naš prag budite sigurni da se ste na putu potpunog oporavka i trajnog rešavanja svih zubnih problema.') : 'Od momenta kada prvi put pređete naš prag budite sigurni da se ste na putu potpunog oporavka i trajnog rešavanja svih zubnih problema.'; ?></p>
							<hr class="my-5 p-0">
						</div>
					</div>

					<div class="row py-3">
						<div class="col text-center">
							<h2 class="d-inline-block line-height-5 text-4 positive-ls-3 font-weight-semibold text-color-primary mb-2 appear-animation" data-appear-animation="fadeInUpShorter">NAŠI STOMATOLOZI</h2>
							<h3 class="text-color-dark text-9 line-height-3 text-transform-none font-weight-semibold mb-4 mb-lg-3 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250">Upoznajte naš tim</h3>
							<p class="text-3-5 font-weight-medium pb-1 mb-4 mb-lg-2 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">Stomatologija "Dakić" je tim vrhunskih stručnjaka iz svih oblasti stomatologije. Tu smo da Vaš osmjeh učinimo blistavim.</p>

							<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
								<div class="owl-carousel owl-theme nav-style-1 nav-arrows-thin nav-font-size-lg custom-nav-1 custom-nav-1-pos-3 p-relative mb-0 mt-2" data-plugin-options="{'responsive': {'0': {'items': 1}, '479': {'items': 1}, '768': {'items': 2}, '979': {'items': 2}, '1199': {'items': 3}}, 'loop': true, 'nav': true, 'dots': false, 'margin': 40}">
								<div>
												<div class="card border-0">
													<span class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-slow-image-zoom-hover thumb-info-swap-content anim-hover-inner-wrapper">
														<span class="thumb-info-wrapper overlay overflow-hidden">
															<img src="images/milan-dakic.png" class="img-fluid" alt="">
															<span class="thumb-info-title bottom-30 bg-transparent w-100 mw-100 p-0">
																<span class="thumb-info-swap-content-wrapper">
																	<span class="thumb-info-inner text-start ps-5"></span>
																	<span class="thumb-info-inner text-2">
																		<p class="px-5 text-4 text-lg-2 opacity-7 font-weight-medium text-light"><?php echo function_exists('getContent') ? getContent('onama', 'team_member_description', 'Član vrhunskog tima koji će vas svaki put dočekati s osmjehom na licu.') : 'Član vrhunskog tima koji će vas svaki put dočekati s osmjehom na licu.'; ?></p>


																		<ul class="social-icons social-icons-clean social-icons-icon-light">
																			<li class="social-icons-instagram">
																				<a href="https://www.instagram.com/stomatoloska_ord_dr_dakic/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
																			</li>
																			<!-- <li class="social-icons-twitter">
																				<a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
																			</li> -->
																			<li class="social-icons-facebook">
																				<a href="https://www.facebook.com/stomatoloskaordinacijaextradent" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
																			</li>
																		</ul>

																	</span>
																</span>
															</span>
														</span>
													</span>
													<h3 class="font-weight-bold text-capitalize line-height-1 text-5-5 mt-4 mb-0">Milan Dakić</h3>
													<p class="font-weight-medium text-color-grey text-3 mb-2">spec. ortopedije vilica</p>
												</div>
											</div>
											<div>
												<div class="card border-0">
													<span class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-slow-image-zoom-hover thumb-info-swap-content anim-hover-inner-wrapper">
														<span class="thumb-info-wrapper overlay overflow-hidden">
															<img src="images/tanja-tesevic.png" class="img-fluid" alt="">
															<span class="thumb-info-title bottom-30 bg-transparent w-100 mw-100 p-0">
																<span class="thumb-info-swap-content-wrapper">
																	<span class="thumb-info-inner text-start ps-5"></span>
																	<span class="thumb-info-inner text-2">
																		<p class="px-5 text-4 text-lg-2 opacity-7 font-weight-medium text-light"><?php echo function_exists('getContent') ? getContent('onama', 'team_member_description', 'Član vrhunskog tima koji će vas svaki put dočekati s osmjehom na licu.') : 'Član vrhunskog tima koji će vas svaki put dočekati s osmjehom na licu.'; ?></p>


																		<ul class="social-icons social-icons-clean social-icons-icon-light">
																			<li class="social-icons-instagram">
																				<a href="https://www.instagram.com/stomatoloska_ord_dr_dakic/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
																			</li>
																			<!-- <li class="social-icons-twitter">
																				<a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
																			</li> -->
																			<li class="social-icons-facebook">
																				<a href="https://www.facebook.com/stomatoloskaordinacijaextradent" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
																			</li>
																		</ul>

																	</span>
																</span>
															</span>
														</span>
													</span>
													<h3 class="font-weight-bold text-capitalize line-height-1 text-5-5 mt-4 mb-0">Tanja Tešević</h3>
													<p class="font-weight-medium text-color-grey text-3 mb-2">doktor stomatologije</p>
												</div>
											</div>
											<div>
												<div class="card border-0">
													<span class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-slow-image-zoom-hover thumb-info-swap-content anim-hover-inner-wrapper">
														<span class="thumb-info-wrapper overlay overflow-hidden">
															<img src="images/bilja.png" class="img-fluid" alt="">
															<span class="thumb-info-title bottom-30 bg-transparent w-100 mw-100 p-0">
																<span class="thumb-info-swap-content-wrapper">
																	<span class="thumb-info-inner text-start ps-5"></span>
																	<span class="thumb-info-inner text-2">
																		<p class="px-5 text-4 text-lg-2 opacity-7 font-weight-medium text-light"><?php echo function_exists('getContent') ? getContent('onama', 'team_member_description', 'Član vrhunskog tima koji će vas svaki put dočekati s osmjehom na licu.') : 'Član vrhunskog tima koji će vas svaki put dočekati s osmjehom na licu.'; ?></p>


																		<ul class="social-icons social-icons-clean social-icons-icon-light">
																			<li class="social-icons-instagram">
																				<a href="https://www.instagram.com/stomatoloska_ord_dr_dakic/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
																			</li>
																			<!-- <li class="social-icons-twitter">
																				<a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
																			</li> -->
																			<li class="social-icons-facebook">
																				<a href="https://www.facebook.com/stomatoloskaordinacijaextradent" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
																			</li>
																		</ul>

																	</span>
																</span>
															</span>
														</span>
													</span>
													<h3 class="font-weight-bold text-capitalize line-height-1 text-5-5 mt-4 mb-0">Biljana Ilić</h3>
													<p class="font-weight-medium text-color-grey text-3 mb-2">dentalni asistent</p>
												</div>
											</div>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div> 

			<!-- FOOTER -->
			<?php include_once('includes/footer.php'); ?>

		</div>

		<!-- FOOTER SKRIPTE -->
		<?php include_once('includes/footer-script.php'); ?>

	</body>
	
</html>
