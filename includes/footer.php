<footer id="footer" class="border-0 mt-0">
	<div class="container pt-5">
		<div class="row text-center text-lg-start font-weight-semi-bold text-color-light text-4 py-3">
			<div class="col-lg-6 mb-5 mb-lg-0">
				<i class="icon-location-pin icons text-color-tertiary text-6 p-relative top-6 me-1"></i> <?php echo function_exists('getContent') ? getContent('footer', 'address', 'Nikole Tesle 23/4, 76300 Bijeljina') : 'Nikole Tesle 23/4, 76300 Bijeljina'; ?>
			</div>
			<div class="col-lg-6 text-lg-end">
				<span class="d-block d-lg-inline-block mb-3 mb-lg-0 me-lg-4">
					<i class="icon-envelope icons text-color-tertiary text-6 p-relative top-7 me-1"></i><span class="__cf_email__"><?php echo function_exists('getContent') ? getContent('footer', 'email', 'info@stomatologijadakic.com') : 'info@stomatologijadakic.com'; ?></span></a>
				</span>
				<span class="d-block d-lg-inline-block">
					<i class="icon-phone icons text-color-tertiary text-6 p-relative top-7 me-1"></i> <a href="tel:<?php echo function_exists('getContent') ? str_replace(' ', '', getContent('footer', 'phone', '+387 66 096 666')) : '+38766096666'; ?>" class="text-color-light text-color-hover-tertiary text-decoration-none"><?php echo function_exists('getContent') ? getContent('footer', 'phone', '+387 66 096 666') : '+387 66 096 666'; ?></a>
				</span>
			</div>
		</div>
	</div>
	<div class="container pb-5">
		<div class="row text-center text-md-start py-4 my-5">
			<div class="col-md-6 col-lg-3 align-self-center text-center text-md-start text-lg-center mb-5 mb-lg-0 d-flex justify-content-center" style="align-self:initial!important;">
				<a href="index.php" class="text-decoration-none">
					<img style="height: 200px;" src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('logo_footer') : 'images/logo-vertical.svg'); ?>" class="img-fluid" alt="" />
				</a>
			</div>
			<div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
				<h5 class="text-transform-none font-weight-bold text-color-light text-4-5 mb-4"><?php echo function_exists('getContent') ? getContent('footer', 'about_title', 'O nama') : 'O nama'; ?></h5>
				<ul class="list list-unstyled">
					<li class="pb-1 mb-2">
						<span class="d-block font-weight-semibold line-height-1 text-color-grey text-3-5">Adresa</span> 
						<a href="https://www.google.com/maps/place/44%C2%B045'20.2%22N+19%C2%B012'59.3%22E/@44.755616,19.21583,198m/data=!3m2!1e3!4b1!4m4!3m3!8m2!3d44.755615!4d19.2164737?entry=ttu" class="text-color-light font-weight-medium text-3-5" target="_blank"><?php echo function_exists('getContent') ? getContent('footer', 'address', 'Nikole Tesle 23/4') : 'Nikole Tesle 23/4'; ?></a>
					</li>
					<li class="pb-1 mb-2">
						<span class="d-block font-weight-semibold line-height-1 text-color-grey text-3-5 mb-1">PHONE</span>
						<ul class="list list-unstyled font-weight-light text-3-5 mb-0">
							<li class="text-color-light line-height-3 mb-0">
								Hitni slučajevi: <a href="tel:<?php echo function_exists('getContent') ? str_replace(' ', '', getContent('footer', 'phone_emergency', '+387 66 096 666')) : '+38766096666'; ?>" class="text-decoration-none text-color-light text-color-hover-default"><?php echo function_exists('getContent') ? getContent('footer', 'phone_emergency', '+387 66 096 666') : '+387 66 096 666'; ?></a>
							</li>
							<li class="text-color-light line-height-3 mb-0">
								Narudžbe: <a href="tel:<?php echo function_exists('getContent') ? str_replace(' ', '', getContent('footer', 'phone_orders', '+387 66 096 666')) : '+38766096666'; ?>" class="text-decoration-none text-color-light text-color-hover-default"><?php echo function_exists('getContent') ? getContent('footer', 'phone_orders', '+387 66 096 666') : '+387 66 096 666'; ?></a>
							</li>
						</ul>
					</li>
					<li class="pb-1 mb-2">
						<span class="d-block font-weight-semibold line-height-1 text-color-grey text-3-5">EMAIL</span>
						<a href="mailto:<?php echo function_exists('getContent') ? getContent('footer', 'email', 'info@stomatologijadakic.com') : 'info@stomatologijadakic.com'; ?>" class="text-decoration-none font-weight-light text-3-5 text-color-light text-color-hover-default"><span class="__cf_email__"><?php echo function_exists('getContent') ? getContent('footer', 'email', 'info@stomatologijadakic.com') : 'info@stomatologijadakic.com'; ?></span></a>
					</li>
				</ul>
				<ul class="social-icons social-icons-medium">
					<li class="social-icons-instagram">
						<a href="https://www.instagram.com/stomatoloska_ord_dr_dakic/" class="no-footer-css" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
					</li>
					<li class="social-icons-facebook">
						<a href="https://www.facebook.com/stomatoloskaordinacijaextradent" class="no-footer-css" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
					</li>
				</ul>
			</div>
			<div class="col-md-6 col-lg-2 mb-5 mb-md-0">
				<h5 class="text-transform-none font-weight-bold text-color-light text-4-5 mb-4">Naše usluge</h5>
				<ul class="list list-unstyled mb-0">
					<li class="mb-0"><a href="implantologija.php">Implantologija</a></li>
					<li class="mb-0"><a href="protetika.php">Protetika</a></li>
					<li class="mb-0"><a href="oralna-hirurgija.php">Oralna hirurgija</a></li>
					<li class="mb-0"><a href="oralna-hirurgija.php">Endodoncija</a></li>
					<li class="mb-0"><a href="estetska-medicina.php">Estetska medicina</a></li>
					<!-- <li class="mb-0"><a href="paradontologija.php">Parodontologija</a></li> -->
					<li class="mb-0"><a href="ortodoncija.php">Ortodoncija</a></li>
					<li class="mb-0"><a href="izbjeljivanje-zuba.php">Izbjeljivanje zuba</a></li>
					<li class="mb-0"><a href="rendgen-dijagnostika.php">Rendgen dijagnostika</a></li>
					<li class="mb-0"><a href="djecija-stomatologija.php">Dječija stomatologija</a></li>
					<li class="mb-0"><a href="konzervativna-stomatologija.php">Konzervativna stomatologija</a></li>
					<li class="mb-0"><a href="laseroterapija.php">Laseroterapija</a></li>
				</ul>
			</div>
			<div class="col-md-6 col-lg-3 offset-lg-1">
				<h5 class="text-transform-none font-weight-bold text-color-light text-4-5 mb-4"><?php echo function_exists('getContent') ? getContent('footer', 'hours_title', 'Radno vrijeme') : 'Radno vrijeme'; ?></h5>
				<ul class="list list-unstyled list-inline mb-0">
					<li><?php echo function_exists('getContent') ? getContent('footer', 'working_hours_weekdays', 'Pon-Pet: 8:00-19:00') : 'Pon-Pet: 8:00-19:00'; ?></li>
					<li><?php echo function_exists('getContent') ? getContent('footer', 'working_hours_saturday', 'Subotom: 8:00-13:00') : 'Subotom: 8:00-13:00'; ?></li>
					<li><?php echo function_exists('getContent') ? getContent('footer', 'working_hours_sunday', 'Nedjeljom: Samo hitni slučajevi.') : 'Nedjeljom: Samo hitni slučajevi.'; ?></li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<p class="text-center text-color-light opacity-5 text-3 mb-0"><?php echo function_exists('getContent') ? str_replace('{{year}}', date('Y'), getContent('footer', 'copyright', 'Stomatologija Dakić © ' . date('Y') . '. All Rights Reserved.')) : 'Stomatologija Dakić © ' . date('Y') . '. All Rights Reserved.'; ?></p>
			</div>
		</div>
	</div>
</footer>