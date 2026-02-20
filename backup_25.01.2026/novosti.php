<!-- HEAD -->
<?php 
	include_once('includes/head.php'); 
	$active = "novosti";
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
								<h1 class="text-color-dark font-weight-bold text-9">Novosti</h1>
							</div>
							<div class="col-md-4 order-1 order-md-2 align-self-center">
								<ul class="breadcrumb d-flex justify-content-md-end text-4 font-weight-medium">
									<li class="text-capitalize"><a href="index.php" class="text-color-default text-color-hover-primary text-decoration-none text-capitalize">Početna</a></li>
									<li class="text-capitalize active">Galerija</li>
								</ul>
							</div>
						</div>
					</div>
				</section>

				<div class="container pt-4 pb-5">
					<div class="row">
						<div class="col">
							<p class="font-weight-medium text-4-5 line-height-5">Naša ordinacija kroz slike</p>
							<p class="text-3-5">Galerija je osmišljena tako da Vam prikaže mali dio prijatne atmosfere koja Vas čeka u našoj ordinaciji. Postanite i vi dio velikog broja pacijenata koji sa osmjehom na licu dolaze u našu ordinaciju.</p>
						</div>
					</div>
				</div>

				<div class="container pt-4 pb-5">
					<div class="row">
						<div class="col">
							<p class="font-weight-medium text-4-5 line-height-5">USKORO...</p>
						</div>
					</div>
				</div>

				<section class="section border-0 bg-color-light m-0 py-5">
					<div class="container py-5 my-2">
						<div class="row">
							<div class="col-lg-6 mb-5 mb-lg-0">
								<h2 class="d-inline-block line-height-5 text-4 positive-ls-3 font-weight-semibold text-color-primary mb-2 appear-animation" data-appear-animation="fadeInUpShorter">SPECIJALNA PONUDA</h2>
								<h3 class="text-color-dark text-9 line-height-3 text-transform-none font-weight-semibold mb-4 mb-lg-3 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250">Izdvojena ponuda dostupna svim našim pacijentima</h3>
								<p class="text-3-5 font-weight-medium pb-1 mb-4 mb-lg-2 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">Svaki novi pacijent u našim prostorijama može obaviti BESPLATAN pregled kao i konsultacije sa našim timom u slučaju da Vam treba bilo kakava intervencija.</p>
								
							</div>

							<div class="col-lg-6 mb-5">
								<ul class="list list-icons list-icons-lg ms-lg-3 mt-lg-4 pt-lg-2">
									<li class="text-3-5 font-weight-medium appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200"><i class="fas fa-check text-color-tertiary"></i> <span class="ps-2 d-block">BESPLATAN detaljni pregled</span></li>
									<li class="text-3-5 font-weight-medium appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400"><i class="fas fa-check text-color-tertiary"></i> <span class="ps-2 d-block">BESPLATNE konsultacije</span></li>
									<li class="text-3-5 font-weight-medium appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600"><i class="fas fa-check text-color-tertiary"></i> <span class="ps-2 d-block">BESPLATNI sajveti</span></li>
									<li class="text-3-5 font-weight-medium appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600"><i class="fas fa-check text-color-tertiary"></i> <span class="ps-2 d-block">ČEKAMO VAS!</span></li>
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
									<strong>Rezervišite svoj termin</strong> - Trebate hitnu intervenciju? Pozovite <u>+387 66 096 666</u>
								</p>
							</div>
							<div class="col-lg-3 text-center text-md-start text-lg-end">
								<a href="demo-dentist-contact.html#book" class="btn btn-secondary border-0 text-3-5 font-weight-semi-bold btn-px-5 btn-py-3">Rezervišite termin</a>
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
