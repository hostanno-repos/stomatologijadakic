<!-- HEAD -->
<?php 
	include_once('includes/head.php'); 
	$active = "home";
?>

		<body data-plugin-cursor-effect data-plugin-page-transition>

			<!-- SIDEMENU -->
			<?php include_once('includes/sidemenu.php'); ?>

			<div class="body">
				
				<!-- HEADER -->
				<?php include_once('includes/header.php'); ?>
				
				<div role="main" class="main">

					<!-- SLIDER -->
					<?php include_once('includes/slider.php'); ?>

					<!-- REZERVIŠITE TERMIN -->
					<div id="home-intro" class="home-intro bg-primary p-relative z-index-3 m-0">
						<div class="container py-2">
							<div class="row align-items-center text-center text-md-start">
								<div class="col-lg-9 mb-3 mb-lg-0">
									<p class="text-color-light text-4-5 font-weight-medium line-height-4 mb-0">
										<strong><?php echo function_exists('getContent') ? getContent('index', 'cta_text', 'Rezervišite svoj termin online') : 'Rezervišite svoj termin online'; ?></strong> - <?php echo function_exists('getContent') ? getContent('index', 'cta_subtext', 'Trebate hitnu rezervaciju? Pozovite nas na') : 'Trebate hitnu rezervaciju? Pozovite nas na'; ?> <u><?php echo function_exists('getContent') ? getContent('index', 'cta_phone', '+387 66 096 666') : '+387 66 096 666'; ?></u>
									</p>
								</div>
								<div class="col-lg-3 text-center text-md-start text-lg-end">
									<a href="kontakt.php#book" class="btn btn-secondary border-0 text-3-5 font-weight-semi-bold btn-px-5 btn-py-3"><?php echo function_exists('getContent') ? getContent('index', 'cta_button', 'Rezervišite termin') : 'Rezervišite termin'; ?></a>
								</div>
							</div>
						</div>
					</div>

					<!-- THREE BOXES -->
					<div class="container my-5">
						<div class="row">
							<div class="col py-4">
								<div class="featured-boxes featured-boxes-style-9">
									<div class="row">
										<div class="col-lg-4 px-lg-3">
											<div class="featured-box featured-box-primary">
												<div class="box-content">
													<span class="icon-featured icon-featured-lg">
														<img height="100" src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('index_box_icon1') : 'img/demos/dentist/icons/icon-1.svg'); ?>" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-tertiary mt-1'}" />
													</span>
													<h4 class="font-weight-semi-bold mt-3 pt-2 mb-3 text-5-5 text-color-dark"><?php echo function_exists('getContent') ? getContent('index', 'box1_title', 'Super lokacija') : 'Super lokacija'; ?></h4>
													<p class="mb-0 text-3-5 font-weight-medium"><?php echo function_exists('getContent') ? getContent('index', 'box1_text', 'Nalazimo se u samom centru grada, posjedujemo svoj parking i caffe bar.') : 'Nalazimo se u samom centru grada, posjedujemo svoj parking i caffe bar.'; ?></p>
												</div>
											</div>
										</div>
										<div class="col-lg-4 px-lg-3">
											<div class="featured-box featured-box-secondary">
												<div class="box-content">
													<span class="icon-featured icon-featured-lg">
														<img height="100" src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('index_box_icon2') : 'img/demos/dentist/icons/icon-2.svg'); ?>" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-tertiary mt-1'}" />
													</span>
													<h4 class="font-weight-semi-bold mt-3 pt-2 mb-3 text-5-5 text-color-dark"><?php echo function_exists('getContent') ? getContent('index', 'box2_title', 'Odlična usluga') : 'Odlična usluga'; ?></h4>
													<p class="mb-0 text-3-5 font-weight-medium"><?php echo function_exists('getContent') ? getContent('index', 'box2_text', 'Mi brinemo o svakom pacijentu, Vaše zadovoljstvo je naš uspjeh.') : 'Mi brinemo o svakom pacijentu, Vaše zadovoljstvo je naš uspjeh.'; ?></p>
												</div>
											</div>
										</div>
										<div class="col-lg-4 px-lg-3">
											<div class="featured-box featured-box-tertiary">
												<div class="box-content">
													<span class="icon-featured icon-featured-lg">
														<img height="100" src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('index_box_icon3') : 'img/demos/dentist/icons/icon-3.svg'); ?>" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-tertiary mt-1'}" />
													</span>
													<h4 class="font-weight-semi-bold mt-3 pt-2 mb-3 text-5-5 text-color-dark"><?php echo function_exists('getContent') ? getContent('index', 'box3_title', 'Vrhunski stručnjaci') : 'Vrhunski stručnjaci'; ?></h4>
													<p class="mb-0 text-3-5 font-weight-medium"><?php echo function_exists('getContent') ? getContent('index', 'box3_text', 'Zapošljavamo samo vrhunske stručnjake stomatologije.') : 'Zapošljavamo samo vrhunske stručnjake stomatologije.'; ?></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- ABOUT US -->
					<section class="section border-0 bg-color-light m-0 py-5">
						<div class="container py-5 my-2">
							<div class="row align-items-xl-center">
								<div class="col-lg-6 mb-5 mb-lg-0 text-center">

									<svg height="0" width="0">
										<defs>
											<clipPath id="svgPath">
												<path d="M143.3,391.5C64.74,320.29-11.54,212.43,1.46,109.91,6.81,67.72,35,23.31,77.51,11.57c45.8-12.65,81.56,9.87,127.88,10,51,.11,99.23-34,152.49-16.65C458.61,37.71,412.21,170.19,372,228c-10.63,15.3-44.76,63.1-48.29,40.44-9.23-59.24-26.68-67.61-57.52-75.23-32.68-8.07-80.24,8.61-92.4,39.25-26.47,66.76,31,137.89,64.57,191.19.89,1.42,38.8,48.72,31,50.86-21.12,5.77-69.06-37.36-84.67-48.95C171.14,415.52,157.18,404.08,143.3,391.5Z" style="fill:#000"/>
											</clipPath>
										</defs>
									</svg>	

									<img class="img-fluid" style="clip-path: url(#svgPath); min-height: 480px; max-width: 420px;" src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('index_hero') : 'img/demos/dentist/generic/generic-5.jpg'); ?>" alt="">

								</div>
								<div class="col-lg-6 ps-lg-4 ps-xl-5">
									<h2 class="d-inline-block line-height-5 text-4 positive-ls-3 font-weight-semibold text-color-primary mb-2 appear-animation" data-appear-animation="fadeInUpShorter">O NAMA</h2>
									<h3 class="text-color-dark text-9 line-height-3 text-transform-none font-weight-semibold mb-4 mb-lg-3 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250">Dobrodošli u Stomatološku ambulantu "Dakić" u Bijeljini</h3>
									<p class="text-3-5 font-weight-medium pb-1 mb-4 mb-lg-2 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">Nudimo vrhunske uluge iz svih oblasti stomatologije, te u svakom pogledu idemo u korak s vremenom. Uvjerite se i sami.</p>
									<div class="row align-items-center pb-2 mb-4 mb-lg-1 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750">
										<div class="col-5">
											<div class="d-flex">
												<span class="text-4 font-weight-bold text-color-dark pt-2 ms-2">
													<strong class="d-block font-weight-bold text-10 mb-2">4500+</strong>
													Zadovoljnih osmjeha
												</span>
											</div>
										</div>
										<div class="col-7">
											<p class="mb-0">Uvjerite se u kvalitetu naših usluga.</p>
										</div>
									</div>
									<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">
										<a href="#" class="btn btn-secondary border-0 text-3 font-weight-semi-bold btn-px-5 btn-py-3">Pogledajte naše usluge</a>
									</div>
								</div>
							</div>
						</div>
					</section>

					<!-- USLUGE SLIDER -->
					<section class="section border-0 bg-transparent m-0 py-5">
						<div class="container-fluid">
							<div class="row px-4">
								<div class="owl-carousel owl-theme full-width nav-style-1 nav-arrows-thin nav-font-size-lg custom-nav-1 custom-nav-1-pos-2 p-relative mb-0" data-plugin-options="{'responsive': {'0': {'items': 1}, '479': {'items': 1}, '768': {'items': 2}, '979': {'items': 2}, '1199': {'items': 4}}, 'loop': true, 'nav': true, 'dots': false, 'margin': 40}">
									<div>
										<span class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-slow-image-zoom-hover thumb-info-swap-content anim-hover-inner-wrapper">
											<span class="thumb-info-wrapper overlay overlay-op-3 overlay-show overflow-hidden">
												<img src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('usluge_ortodoncija') : 'img/usluge-slider/ortodoncija.jpg'); ?>" class="img-fluid" alt="" style="height:100%;object-fit:cover;">
												<span class="thumb-info-title bg-transparent w-100 mw-100 p-0 top-0 p-5">
													<span class="anim-hover-inner-translate-bottom-20px transition-2ms d-inline-block">
														<span class="thumb-info-inner">
															<h4 class="text-color-light text-5 font-weight-bold">Ortodoncija</h4>
														</span>
													</span>
												</span>
												<span class="thumb-info-title bottom-30 bg-transparent w-100 mw-100 p-0">
													<span class="thumb-info-swap-content-wrapper">
														<span class="thumb-info-inner text-start ps-5">
															<img style="max-width: 60px;" height="60" width="60" class="transform-none mb-3" src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('usluge_icon1') : 'img/usluge-slider/icon1.png'); ?>" />
														</span>
														<span class="thumb-info-inner text-2">
															<p class="px-5 text-4 text-lg-2 opacity-7 font-weight-medium text-light">Ortodoncija se  bavi dijagnostikom, prevencijom i ispravljanjem nepravilnog položaja zuba.</p>
															<a href="usluge-details.html" class="btn btn-primary btn-arrow-effect-1 py-2 px-3 ms-5 mb-3 text-3 text-lg-1 ls-0 border-0">Pročitajte više <i class="fas fa-arrow-right ms-2"></i></a>
														</span>
													</span>
												</span>
											</span>
										</span>
									</div>
									<div>
										<span class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-slow-image-zoom-hover thumb-info-swap-content anim-hover-inner-wrapper">
											<span class="thumb-info-wrapper overlay overlay-op-3 overlay-show overflow-hidden">
												<img src="img/usluge-slider/protetika.jpg" class="img-fluid" alt="">
												<span class="thumb-info-title bg-transparent w-100 mw-100 p-0 top-0 p-5">
													<span class="anim-hover-inner-translate-bottom-20px transition-2ms d-inline-block">
														<span class="thumb-info-inner">
															<h4 class="text-color-light text-5 font-weight-bold">Protetika</h4>
														</span>
													</span>
												</span>
												<span class="thumb-info-title bottom-30 bg-transparent w-100 mw-100 p-0">
													<span class="thumb-info-swap-content-wrapper">
														<span class="thumb-info-inner text-start ps-5">
															<img style="max-width: 60px;" height="60" width="60" class="transform-none mb-3" src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('usluge_icon5') : 'img/usluge-slider/icon5.png'); ?>" />
														</span>
														<span class="thumb-info-inner text-2">
															<p class="px-5 text-4 text-lg-2 opacity-7 font-weight-medium text-light">Potražite najkvalitetnije na tržištu mostove i krunice, ispune te mobilne i fiksne proteze za lijep osmjeh.</p>
															<a href="usluge-details.html" class="btn btn-primary btn-arrow-effect-1 py-2 px-3 ms-5 mb-3 text-3 text-lg-1 ls-0 border-0">Pročitajte više <i class="fas fa-arrow-right ms-2"></i></a>
														</span>
													</span>
												</span>
											</span>
										</span>
									</div>
									<div>
										<span class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-slow-image-zoom-hover thumb-info-swap-content anim-hover-inner-wrapper">
											<span class="thumb-info-wrapper overlay overlay-op-3 overlay-show overflow-hidden">
												<img src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('usluge_estetika') : 'img/usluge-slider/estetika.jpg'); ?>" class="img-fluid" alt="">
												<span class="thumb-info-title bg-transparent w-100 mw-100 p-0 top-0 p-5">
													<span class="anim-hover-inner-translate-bottom-20px transition-2ms d-inline-block">
														<span class="thumb-info-inner">
															<h4 class="text-color-light text-5 font-weight-bold">Estetska medicina</h4>
														</span>
													</span>
												</span>
												<span class="thumb-info-title bottom-30 bg-transparent w-100 mw-100 p-0">
													<span class="thumb-info-swap-content-wrapper">
														<span class="thumb-info-inner text-start ps-5">
															<img style="max-width: 60px;" height="60" width="60" class="transform-none mb-3" src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('usluge_icon3') : 'img/usluge-slider/icon3.png'); ?>" />
														</span>
														<span class="thumb-info-inner text-2">
															<p class="px-5 text-4 text-lg-2 opacity-7 font-weight-medium text-light">Botox, hijaluronski fileri, mezoterapija lica.</p>
															<a href="usluge-details.html" class="btn btn-primary btn-arrow-effect-1 py-2 px-3 ms-5 mb-3 text-3 text-lg-1 ls-0 border-0">Pročitajte više <i class="fas fa-arrow-right ms-2"></i></a>
														</span>
													</span>
												</span>
											</span>
										</span>
									</div>
									<div>
										<span class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-slow-image-zoom-hover thumb-info-swap-content anim-hover-inner-wrapper">
											<span class="thumb-info-wrapper overlay overlay-op-3 overlay-show overflow-hidden">
												<img src="img/usluge-slider/endodoncija.jpg" class="img-fluid" alt="">
												<span class="thumb-info-title bg-transparent w-100 mw-100 p-0 top-0 p-5">
													<span class="anim-hover-inner-translate-bottom-20px transition-2ms d-inline-block">
														<span class="thumb-info-inner">
															<h4 class="text-color-light text-5 font-weight-bold">Endodoncija</h4>
														</span>
													</span>
												</span>
												<span class="thumb-info-title bottom-30 bg-transparent w-100 mw-100 p-0">
													<span class="thumb-info-swap-content-wrapper">
														<span class="thumb-info-inner text-start ps-5">
															<img style="max-width: 60px;" height="60" width="60" class="transform-none mb-3" src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('usluge_icon4') : 'img/usluge-slider/icon4.png'); ?>" />
														</span>
														<span class="thumb-info-inner text-2">
															<p class="px-5 text-4 text-lg-2 opacity-7 font-weight-medium text-light">Endodoncija se bavi liječenjem zuba i korijenskih kanala, tj. Oboljele zubne pulpe.</p>
															<a href="usluge-details.html" class="btn btn-primary btn-arrow-effect-1 py-2 px-3 ms-5 mb-3 text-3 text-lg-1 ls-0 border-0">Pročitajte više <i class="fas fa-arrow-right ms-2"></i></a>
														</span>
													</span>
												</span>
											</span>
										</span>
									</div>
									<div>
										<span class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-slow-image-zoom-hover thumb-info-swap-content anim-hover-inner-wrapper">
											<span class="thumb-info-wrapper overlay overlay-op-3 overlay-show overflow-hidden">
												<img src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('usluge_implantologija') : 'img/usluge-slider/implantologija.jpg'); ?>" class="img-fluid" alt="">
												<span class="thumb-info-title bg-transparent w-100 mw-100 p-0 top-0 p-5">
													<span class="anim-hover-inner-translate-bottom-20px transition-2ms d-inline-block">
														<span class="thumb-info-inner">
															<h4 class="text-color-light text-5 font-weight-bold">Implantologija</h4>
														</span>
													</span>
												</span>
												<span class="thumb-info-title bottom-30 bg-transparent w-100 mw-100 p-0">
													<span class="thumb-info-swap-content-wrapper">
														<span class="thumb-info-inner text-start ps-5">
															<img style="max-width: 60px;" height="60" width="60" class="transform-none mb-3" src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('usluge_icon2') : 'img/usluge-slider/icon2.png'); ?>" />
														</span>
														<span class="thumb-info-inner text-2">
															<p class="px-5 text-4 text-lg-2 opacity-7 font-weight-medium text-light">Trebate zubne implantate nite sigurni da li je all-on-4 ili all-on-6 najbolje riješenje za Vas?Zakažite konsultacije.</p>
															<a href="usluge-details.html" class="btn btn-primary btn-arrow-effect-1 py-2 px-3 ms-5 mb-3 text-3 text-lg-1 ls-0 border-0">Pročitajte više <i class="fas fa-arrow-right ms-2"></i></a>
														</span>
													</span>
												</span>
											</span>
										</span>
									</div>
									<div>
										<span class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-slow-image-zoom-hover thumb-info-swap-content anim-hover-inner-wrapper">
											<span class="thumb-info-wrapper overlay overlay-op-3 overlay-show overflow-hidden">
												<img src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('usluge_radiologija') : 'img/usluge-slider/radiologija.jpg'); ?>" class="img-fluid" alt="">
												<span class="thumb-info-title bg-transparent w-100 mw-100 p-0 top-0 p-5">
													<span class="anim-hover-inner-translate-bottom-20px transition-2ms d-inline-block">
														<span class="thumb-info-inner">
															<h4 class="text-color-light text-5 font-weight-bold">Dentalna radiologija</h4>
														</span>
													</span>
												</span>
												<span class="thumb-info-title bottom-30 bg-transparent w-100 mw-100 p-0">
													<span class="thumb-info-swap-content-wrapper">
														<span class="thumb-info-inner text-start ps-5">
															<img style="max-width: 60px;" height="60" width="60" class="transform-none mb-3" src="img/demos/dentist/icons/icon-5.svg" />
														</span>
														<span class="thumb-info-inner text-2">
															<p class="px-5 text-4 text-lg-2 opacity-7 font-weight-medium text-light">Dentalna radiologija omogućava dijagnostiku i planiranje terapije, te praćenje razvoja bolesti i liječenje.</p>
															<a href="usluge-details.html" class="btn btn-primary btn-arrow-effect-1 py-2 px-3 ms-5 mb-3 text-3 text-lg-1 ls-0 border-0">Pročitajte više <i class="fas fa-arrow-right ms-2"></i></a>
														</span>
													</span>
												</span>
											</span>
										</span>
									</div>
									<div>
										<span class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-slow-image-zoom-hover thumb-info-swap-content anim-hover-inner-wrapper">
											<span class="thumb-info-wrapper overlay overlay-op-3 overlay-show overflow-hidden">
												<img src="img/usluge-slider/hirurgija.jpg" class="img-fluid" alt="">
												<span class="thumb-info-title bg-transparent w-100 mw-100 p-0 top-0 p-5">
													<span class="anim-hover-inner-translate-bottom-20px transition-2ms d-inline-block">
														<span class="thumb-info-inner">
															<h4 class="text-color-light text-5 font-weight-bold">Oralna hirurgija</h4>
														</span>
													</span>
												</span>
												<span class="thumb-info-title bottom-30 bg-transparent w-100 mw-100 p-0">
													<span class="thumb-info-swap-content-wrapper">
														<span class="thumb-info-inner text-start ps-5">
															<img style="max-width: 60px;" height="60" width="60" class="transform-none mb-3" src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('usluge_icon6') : 'img/usluge-slider/icon6.png'); ?>" />
														</span>
														<span class="thumb-info-inner text-2">
															<p class="px-5 text-4 text-lg-2 opacity-7 font-weight-medium text-light">Vađenje zuba, apikotomija, cistektomija, gingivektomija Gummy Smile, cirkumcizija, terapija alveolita.</p>
															<a href="usluge-details.html" class="btn btn-primary btn-arrow-effect-1 py-2 px-3 ms-5 mb-3 text-3 text-lg-1 ls-0 border-0">Pročitajte više <i class="fas fa-arrow-right ms-2"></i></a>
														</span>
													</span>
												</span>
											</span>
										</span>
									</div>
									<div>
										<span class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-slow-image-zoom-hover thumb-info-swap-content anim-hover-inner-wrapper">
											<span class="thumb-info-wrapper overlay overlay-op-3 overlay-show overflow-hidden">
												<img src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('usluge_izbjeljivanje') : 'img/usluge-slider/izbjeljivanje.jpg'); ?>" class="img-fluid" alt="">
												<span class="thumb-info-title bg-transparent w-100 mw-100 p-0 top-0 p-5">
													<span class="anim-hover-inner-translate-bottom-20px transition-2ms d-inline-block">
														<span class="thumb-info-inner">
															<h4 class="text-color-light text-5 font-weight-bold">Izbjeljivanje zuba</h4>
														</span>
													</span>
												</span>
												<span class="thumb-info-title bottom-30 bg-transparent w-100 mw-100 p-0">
													<span class="thumb-info-swap-content-wrapper">
														<span class="thumb-info-inner text-start ps-5">
															<img style="max-width: 60px;" height="60" width="60" class="transform-none mb-3" src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('usluge_icon7') : 'img/usluge-slider/icon7.png'); ?>" />
														</span>
														<span class="thumb-info-inner text-2">
															<p class="px-5 text-4 text-lg-2 opacity-7 font-weight-medium text-light">Ordinacijsko i kućno bijeljenje zuba.</p>
															<a href="usluge-details.html" class="btn btn-primary btn-arrow-effect-1 py-2 px-3 ms-5 mb-3 text-3 text-lg-1 ls-0 border-0">Pročitajte više <i class="fas fa-arrow-right ms-2"></i></a>
														</span>
													</span>
												</span>
											</span>
										</span>
									</div>
								</div>

							</div>
						</div>
					</section>

					<!-- REZERVIŠITE TERMIN 2 -->
					<section class="section border-0 bg-color-light m-0 py-5">
						<div class="container py-5 my-2">
							<div class="row">
								<div class="col-lg-6 mb-5 mb-lg-0">
									<h2 class="d-inline-block line-height-5 text-4 positive-ls-3 font-weight-semibold text-color-primary mb-2 appear-animation" data-appear-animation="fadeInUpShorter"><?php echo function_exists('getContent') ? getContent('index', 'services_section_title', 'NAJBOLJE USLUGE') : 'NAJBOLJE USLUGE'; ?></h2>
									<h3 class="text-color-dark text-9 line-height-3 text-transform-none font-weight-semibold mb-4 mb-lg-3 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250"><?php echo function_exists('getContent') ? getContent('index', 'services_main_title', 'Nudimo najbolje usluge iz svih oblasti stomatologije.') : 'Nudimo najbolje usluge iz svih oblasti stomatologije.'; ?></h3>
									<p class="text-3-5 font-weight-medium pb-1 mb-4 mb-lg-2 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500"><?php echo function_exists('getContent') ? getContent('index', 'services_description', 'Stomatologija "Dakić" nudi široku lepezu usluga iz svih oblasti stomatologije, a pored tog vodimo brigu o svakom našem pacijentu. Uvjerite se u kvalitetu naših usluga!') : 'Stomatologija "Dakić" nudi široku lepezu usluga iz svih oblasti stomatologije, a pored tog vodimo brigu o svakom našem pacijentu. Uvjerite se u kvalitetu naših usluga!'; ?></p>
									
								</div>

								<div class="col-lg-6 mb-5">
									<ul class="list list-icons list-icons-lg ms-lg-3 mt-lg-4 pt-lg-2">
										<li class="text-3-5 font-weight-medium appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200"><i class="fas fa-check text-color-tertiary"></i> <span class="ps-2 d-block"><?php echo function_exists('getContent') ? getContent('index', 'services_list_item', 'Kod nas nikad nećete dva puta rješavati isti problem. Mi radimo detaljno i temeljno.') : 'Kod nas nikad nećete dva puta rješavati isti problem. Mi radimo detaljno i temeljno.'; ?></span></li>
										<!-- <li class="text-3-5 font-weight-medium appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400"><i class="fas fa-check text-color-tertiary"></i> <span class="ps-2 d-block">Kod nas nikad nećete dva puta rješavati isti problem. Mi radimo detaljno i temeljno.</span></li> -->
										<!-- <li class="text-3-5 font-weight-medium appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600"><i class="fas fa-check text-color-tertiary"></i> <span class="ps-2 d-block">Kod nas nikad nećete dva puta rješavati isti problem. Mi radimo detaljno i temeljno.</span></li> -->
									</ul>
								</div>
							</div>

							<div class="row appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
								<div class="col">
									<hr>
								</div>
							</div>

							<div class="row align-items-center text-center text-md-start pt-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
								<div class="col-lg-9 mb-3 mb-lg-0">
									<p class="text-color-primary text-4-5 font-weight-medium line-height-4 mb-0">
										<strong><?php echo function_exists('getContent') ? getContent('index', 'cta_text', 'Rezervišite svoj termin online') : 'Rezervišite svoj termin online'; ?></strong> - <?php echo function_exists('getContent') ? getContent('index', 'cta_subtext', 'Trebate hitnu rezervaciju? Pozovite nas na') : 'Trebate hitnu rezervaciju? Pozovite nas na'; ?> <u><?php echo function_exists('getContent') ? getContent('index', 'cta_phone', '+387 66 096 666') : '+387 66 096 666'; ?></u>
									</p>
								</div>
								<div class="col-lg-3 text-center text-md-start text-lg-end">
									<a href="kontakt.php#book" class="btn btn-secondary border-0 text-3-5 font-weight-semi-bold btn-px-5 btn-py-3"><?php echo function_exists('getContent') ? getContent('index', 'cta_button', 'Rezervišite termin') : 'Rezervišite termin'; ?></a>
								</div>
							</div>
						</div>
					</section>

					<!-- NAŠI STOMATOLOZI -->
					<section class="section border-0 bg-color-transparent m-0 py-5">
						<div class="container py-5 my-2">
							<div class="row">
								<div class="col text-center">
									<h2 class="d-inline-block line-height-5 text-4 positive-ls-3 font-weight-semibold text-color-primary mb-2 appear-animation" data-appear-animation="fadeInUpShorter"><?php echo function_exists('getContent') ? getContent('index', 'team_section_title', 'NAŠI STOMATOLOZI') : 'NAŠI STOMATOLOZI'; ?></h2>
									<h3 class="text-color-dark text-9 line-height-3 text-transform-none font-weight-semibold mb-4 mb-lg-3 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250"><?php echo function_exists('getContent') ? getContent('index', 'team_main_title', 'Upoznajte naše zaposlene') : 'Upoznajte naše zaposlene'; ?></h3>
									<p class="text-3-5 font-weight-medium pb-1 mb-4 mb-lg-2 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500"><?php echo function_exists('getContent') ? getContent('index', 'team_description', 'Stomatologija "Dakić" je tim vrhunskih stručnjaka iz svih oblasti stomatologije. Tu smo da Vaš osmjeh učinimo blistavim.') : 'Stomatologija "Dakić" je tim vrhunskih stručnjaka iz svih oblasti stomatologije. Tu smo da Vaš osmjeh učinimo blistavim.'; ?></p>

									<?php
									$team_employees = function_exists('getEmployees') ? getEmployees() : [];
									$avatar_male   = 'images/milan-dakic.png';
									$avatar_female = 'images/tanja-tesevic.png';
									?>
									<?php if (!empty($team_employees)): ?>
									<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
										<div class="p-relative">
											<div class="owl-carousel owl-theme nav-style-1 nav-arrows-thin nav-font-size-lg custom-nav-1 custom-nav-1-pos-3 p-relative mb-0 mt-2 js-team-carousel" data-plugin-options="{'responsive': {'0': {'items': 1}, '479': {'items': 1}, '768': {'items': 2}, '979': {'items': 2}, '1199': {'items': 3}}, 'loop': true, 'nav': true, 'dots': false, 'margin': 40}">
												<?php foreach ($team_employees as $emp):
												if (!empty($emp['image'])) {
													$emp_img = 'admin/' . ltrim($emp['image'], '/');
												} else {
													$emp_img = (isset($emp['gender']) && $emp['gender'] === 'female') ? $avatar_female : $avatar_male;
												}
											?>
											<div>
												<div class="card border-0">
													<span class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-slow-image-zoom-hover thumb-info-swap-content anim-hover-inner-wrapper">
														<span class="thumb-info-wrapper overlay overflow-hidden">
															<img src="<?php echo htmlspecialchars($emp_img); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($emp['first_name'] . ' ' . $emp['last_name']); ?>">
															<span class="thumb-info-title bottom-30 bg-transparent w-100 mw-100 p-0">
																<span class="thumb-info-swap-content-wrapper">
																	<span class="thumb-info-inner text-start ps-5"></span>
																	<span class="thumb-info-inner text-2">
																		<p class="px-5 text-4 text-lg-2 opacity-7 font-weight-medium text-light"><?php echo htmlspecialchars(!empty($emp['description']) ? $emp['description'] : (function_exists('getContent') ? getContent('index', 'team_member_description', 'Član vrhunskog tima koji će vas svaki put dočekati s osmjehom na licu.') : 'Član vrhunskog tima.')); ?></p>
																	</span>
																</span>
															</span>
														</span>
													</span>
													<h3 class="font-weight-bold text-capitalize line-height-1 text-5-5 mt-4 mb-0"><?php echo htmlspecialchars($emp['first_name'] . ' ' . $emp['last_name']); ?></h3>
													<p class="font-weight-medium text-color-grey text-3 mb-2"><?php echo htmlspecialchars($emp['position']); ?></p>
												</div>
											</div>
												<?php endforeach; ?>
											</div>
											<div class="owl-nav team-carousel-nav">
												<button type="button" role="presentation" class="owl-prev" aria-label="Prethodno"><i class="fas fa-chevron-left"></i></button>
												<button type="button" role="presentation" class="owl-next" aria-label="Sljedeće"><i class="fas fa-chevron-right"></i></button>
											</div>
										</div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</section>

					<!-- REZERVIŠITE TERMIN 3 -->
					<section class="section border-0 bg-color-light m-0 py-5">
						<div class="container py-5 my-2">
							<div class="row">
								<div class="col text-center">
									<h2 class="d-inline-block line-height-5 text-4 positive-ls-3 font-weight-semibold text-color-primary mb-2 appear-animation" data-appear-animation="fadeInUpShorter"><?php echo function_exists('getContent') ? getContent('index', 'booking_section_title', 'Naručite se online') : 'Naručite se online'; ?></h2>
									<h3 class="text-color-dark text-9 line-height-3 text-transform-none font-weight-semibold mb-4 mb-lg-3 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250"><?php echo function_exists('getContent') ? getContent('index', 'booking_main_title', 'Rezervišite svoj termin') : 'Rezervišite svoj termin'; ?></h3>
									<p class="text-3-5 font-weight-medium pb-1 mb-4 mb-lg-2 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500"><?php echo function_exists('getContent') ? getContent('index', 'booking_description', 'Pošaljite nam dan i vrijeme kada želite da budete naručeni, a mi ćemo Vas kontaktirati što prije da Vam potvrdimo Vašp termin.') : 'Pošaljite nam dan i vrijeme kada želite da budete naručeni, a mi ćemo Vas kontaktirati što prije da Vam potvrdimo Vašp termin.'; ?></p>

									<form class="contact-form text-start appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="500" action="https://www.okler.net/previews/porto/9.9.2/php/contact-form.php" method="POST">
										<div class="contact-form-success alert alert-success d-none mt-4">
											<strong>Success!</strong> Your message has been sent to us.
										</div>

										<div class="contact-form-error alert alert-danger d-none mt-4">
											<strong>Error!</strong> There was an error sending your message.
											<span class="mail-error-message text-1 d-block"></span>
										</div>
										
										<div class="row row-gutter-sm">
											<div class="form-group col-lg-6 mb-4">
												<input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control border-0 p-3 box-shadow-none" name="name" id="name" required placeholder="Ime i prezime...">
											</div>
											<div class="form-group col-lg-6 mb-4">
												<input type="text" value="" data-msg-required="Please enter your phone number." maxlength="100" class="form-control border-0 p-3 box-shadow-none" name="phone" id="phone" required placeholder="Broj telefona...">
											</div>
										</div>
										<div class="row row-gutter-sm">
											<div class="form-group col-lg-6 mb-4">
												<input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control border-0 p-3 box-shadow-none" name="email" id="email" required placeholder="E-mail adresa">
											</div>
											<div class="form-group col-lg-6 mb-4">
												<input type="text" value="" data-msg-required="Please enter the service." maxlength="100" class="form-control border-0 p-3 box-shadow-none" name="service" id="service" required placeholder="Željena usluga..">
											</div>
										</div>
										<div class="row">
											<div class="form-group col mb-4">
												<textarea maxlength="5000" data-msg-required="Please enter the details." rows="10" class="form-control border-0 p-3 box-shadow-none" name="message" id="message" required placeholder="Detalji usluge"></textarea>
											</div>
										</div>
										<div class="row">
											<div class="form-group col text-end mb-0">
												<button type="submit" class="btn btn-secondary border-0 text-3-5 font-weight-semi-bold btn-px-5 btn-py-3">Pošalji</button>
											</div>
										</div>
									</form>
									
								</div>
							</div>
						</div>
					</section>
				</div> 

				<!-- FOOTER -->
				<?php include_once('includes/footer.php'); ?>
			</div>

			<!-- FOOTER SKRIPTE -->
			<?php include_once('includes/footer-script.php'); ?>
		</body>
</html>
