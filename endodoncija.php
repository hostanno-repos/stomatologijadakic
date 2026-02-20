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
								<h1 class="text-color-dark font-weight-bold text-9">Endodoncija</h1>
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
							<p>Liječenje korjenskih kanala ili endodoncija podrazumjeva osnovne postupke koji omogućavaju očuvanje zuba, uprkos uznapredovalom zubnom oboljenju koje je nanijelo nepopravljivu štetu vitalnoj jezgri zuba, pulpi. Uzroci takvih oštećenja su različiti, ali karijes je i dalje na prvom mjestu.</p>
							<p class="font-weight-medium text-4-5 line-height-5">Uzroci liječenja:</p>
							<ul>
								<li>vrlo dubok karijes</li>
								<li>upaljeno pulpno tkivo (pulpitis)</li>
								<li>oštećenje zuba</li>
								<li>planirano (zbog protetske njege)</li>
							</ul>
							<!-- <p class="font-weight-medium text-4-5 line-height-5">Prva posjeta stomatologu je veoma značajno iskustvo za dijete i treba da protekne što prijatnije, bez stresa i traume.</p> -->
							<p>Cilj svakog endodontskog postupka je očuvanje zuba ili barem korijena, ako je krunični dio zuba previše uništen. Proces endodontskog liječenja započinje uklanjanjem zahvaćenog zubnog tkiva, nakon čega slijedi mehaničko i hemijsko uklanjanje upaljenog pulpnog tkiva i širenje korijenskih kanala.</p>
							<p>Korijenski kanali mogu se proširiti ručno ili mašinki, pri čemu je mašinsko širenje brže i kvalitetnije. Kada se kanal pravilno proširi, primjenjuju se lijekovi i zub se privremeno zatvara. U sljedećoj seansi liječenje korijenskog kanala završava se punjenjem kanala i kontrolnim rendgenom. Kod teške upale lijek je potrebno mijenjati nekoliko puta, tako da liječenje može trajati nekoliko mjeseci.</p>
						</div>
						<div class="col-lg-4 text-center pt-4 pt-lg-0">
							<img style="max-height:350px" src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('usluge_endodoncija') : 'img/usluge-slider/endodoncija.jpg'); ?>" class="img-fluid box-shadow-4 appear-animation" alt="" data-appear-animation="expandIn" data-appear-animation-delay="100" data-appear-animation-duration="600ms" />
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
