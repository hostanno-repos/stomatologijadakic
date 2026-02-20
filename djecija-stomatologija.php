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
								<h1 class="text-color-dark font-weight-bold text-9">Dječija stomatologija</h1>
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
							<p>Dječija stomatologija je dio stomatologija koja se bavi prevencijom i liječenjem zuba kod djece. Oralno zdravlje djece započinje pravilnim navikama održavanja oralne higijene koja djeca mogu usvojiti u ranoj dobi i tako preventivno uticati na nastanak karijesa na mliječnim, a kasnije i na stalnim zubima.</p>
							<p>Prvi susret djeteta sa stomatološkom ordinacijom treba uključivati upoznavanje sa stomatologom, ordinacijom, instrumentima i uopšteno zubima, bez zahvata koji bi mogao izazvati negativnu reakciju i ''strah od stomatologa''.</p>
						</div>
						<div class="col-lg-4 text-center pt-4 pt-lg-0">
							<img src="<?php echo htmlspecialchars(function_exists('getSiteImage') ? getSiteImage('usluge_djecija') : 'img/djecija-stomatologija.jpg'); ?>" class="img-fluid box-shadow-4 appear-animation" alt="" data-appear-animation="expandIn" data-appear-animation-delay="100" data-appear-animation-duration="600ms" />
						</div>
					</div>

					<p class="font-weight-medium text-4-5 line-height-5">Mliječni zubi</p>
					<p>Mliječni zubi počinju nicati oko šestog mjeseca života, a do treće godine u ustima će biti prisutni svih 20 mliječnih zuba. Vrlo je važno očuvati mliječne zube jer oni čuvaju mjesto trajnim zubima i prilikom izbijanja trajnog zuba usmjeravaju njegov rast, stoga u slučaju preranog gubitka mliječnih zuba dolazi do pogrešnog razmještanja trajnih zuba, odnosno različitih ortodontskih anomalija.</p>
					<p class="font-weight-medium text-4-5 line-height-5">Plombe u boji za mliječne zube</p>
					<p>Plombe u boji su izvrsni motivatori za djecu, prvenstveno zbog neobičnog izgleda, ali i zbog bržeg načina postavljanja i vezanja za zub, što olakšava posao i doktoru i pacijentu. Ovi kompozitni ispuni dolaze u raznim nijansama što privlači dječiju pažnju, te u njima budi želju za suradnjom pri popravci zuba. Birajući boju plombe, dijete postaje aktivni sudionik u poslu zajedno sa doktorom što otklanja stah i uznemirenost. Ovi ispuni odlikuju se biokompatibilnošću, te su odlična prevencija nastanka sekundarnog karijesa zbog ispuštanja flourida.</p>
					<p class="font-weight-medium text-4-5 line-height-5">Zalivanje fiura </p>
					<p>Zalivanje fisura je preventivni postupak kojim nastojimo spriječiti razvoj karijesa na novoizniklim trajnim zubima.</p>
				</div>

			</div> 

			<!-- FOOTER SKRIPTE -->
			<?php include_once('includes/footer.php'); ?>

		</div>
		

		<!-- FOOTER SKRIPTE -->
		<?php include_once('includes/footer-script.php'); ?>

	</body>

</html>
