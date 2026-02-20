<!-- HEAD -->
<?php 
	include_once('includes/head.php'); 
	$active = "usluge";
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
								<h1 class="text-color-dark font-weight-bold text-9">Oralna hirurgija</h1>
							</div>
							<div class="col-md-4 order-1 order-md-2 align-self-center">
								<ul class="breadcrumb d-flex justify-content-md-end text-4 font-weight-medium">
									<li class="text-capitalize"><a href="index.php" class="text-color-default text-color-hover-primary text-decoration-none text-capitalize">Početna</a></li>
									<li class="text-capitalize active">Usluge</li>
								</ul>
							</div>
						</div>
					</div>
				</section>

				<div class="container pt-4 pb-5 mb-4">

					<div class="row pb-5">
						<div class="col-lg-8 pe-lg-5">
							<p class="font-weight-medium text-4-5 line-height-5"> Nudimo Vam usluge:</p>
							<ul>
								<li>Vađenje zuba</li>
								<li>Apikotomija</li>
								<li>Cistektomija</li>
								<li>Gingivektomija Gummy Smile</li>
								<li>Cirkumcizija</li>
								<li>Terapija alveolita</li>
							</ul>
							<!-- <p class="font-weight-medium text-4-5 line-height-5">Prva posjeta stomatologu je veoma značajno iskustvo za dijete i treba da protekne što prijatnije, bez stresa i traume.</p> -->
							<p>Savremena stomatologija odgovarajućim hiruškim postupcima i primjenom lokalne anestezije, omogućava bezbolne oralno-hiruške intervencije sa minimalnom traumom okolnih tkiva i rijetkim postoperativnim komplikacijama.</p>
						</div>
						<div class="col-lg-4 text-center pt-4 pt-lg-0">
							<img src="img/usluge-slider/hirurgija.jpg" class="img-fluid box-shadow-4 appear-animation" alt="" data-appear-animation="expandIn" data-appear-animation-delay="100" data-appear-animation-duration="600ms" />
						</div>
					</div>
				</div>

			</div> 

			<!-- FOOTER SKRIPTE -->
			<?php include_once('includes/footer.php'); ?>

		</div>
		

		<!-- FOOTER SKRIPTE -->
		<?php include_once('includes/footer-script.php'); ?>

	</body>

</html>
