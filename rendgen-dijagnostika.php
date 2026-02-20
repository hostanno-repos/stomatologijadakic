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
								<h1 class="text-color-dark font-weight-bold text-9">RTG dijagnostika</h1>
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
							<p class="font-weight-medium text-4-5 line-height-5">Nudimo Vam usluge:</p>
							<ul>
								<li>RTG snimanje zuba</li>
								<li>OPG snimanje zuba – Ortopan</li>
							</ul>
							<p>Dentalna radiologija je neodvojiv dio moderne stomatološke dijagnostike. Ova grana dentalne medicine bavi se snimanjem zuba i vilica uz veoma nisku dozu zračenja, što je važno i za pacijente i za osoblje. Procedure snimanja traju vrlo kratko – od nekoliko sekundi do nekoliko minuta, čime se brzo postavlja temelj za dalji rad, uspostavljanje dijagnoze i određivanje terapije.</p>
						</div>
						<div class="col-lg-4 text-center pt-4 pt-lg-0">
							<img src="img/usluge-slider/radiologija.jpg" class="img-fluid box-shadow-4 appear-animation" alt="" data-appear-animation="expandIn" data-appear-animation-delay="100" data-appear-animation-duration="600ms" />
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
