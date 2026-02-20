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
								<h1 class="text-color-dark font-weight-bold text-9">Protetika</h1>
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
							<p class="font-weight-medium text-4-5 line-height-5">Nudimo Vam usluge izrade:</p>
							<ul>
								<li>Fiksna protetika</li>
								<li>Mobilna protetika</li>
								<li>Bezmetalne krunice i mostovi</li>
								<li>Metalokeramičke krunice i mostovi</li>
								<li>Cirkonske krunice i mostovi</li>
							</ul>
							<p>Ova grana stomatologije omogućava da se izgubljeni zubi nadoknade a postojeći koriguju, čime se pacijentu omogućava restauracija u estetskom i funkcionalnom smislu.</p>
							<p>Fiksna protetika se odnosi na zubne krunice i mostovi te zubne implantate, dok se mobilne proteze dijele na totalne i parcijalne. Kada je riječ o fiksnoj protetici, preporučujemo korištenje bezmetalnih keramičkih materijala, prvenstveno staklokeramike koja u potpunosti imitira prirodni zub koji nedostaje.</p>
						</div>
						<div class="col-lg-4 text-center pt-4 pt-lg-0">
							<img src="img/usluge-slider/protetika.jpg" class="img-fluid box-shadow-4 appear-animation" alt="" data-appear-animation="expandIn" data-appear-animation-delay="100" data-appear-animation-duration="600ms" />
						</div>
					</div>

					<p class="font-weight-medium text-4-5 line-height-5">Mobilne proteze</p>
					<p>Pod izrazom “proteza” podrazumjevamo sve proteze čija je svrha zamjena svih zuba vilice ili samo nekih zuba, a koje pacijent može sam izvaditi iz usta. </p>
					<p>Totalna proteza nadoknađuje nedostatak zuba kod potpune bezubosti. Ona, ne samo da nadoknađuje izgubljene zube, već i resorbovani koštani greben gornje i donje vilice.</p>
					<p>Parcijalna mobilna proteza je djelimična proteza koju pacijent može sam izvaditi, a sastoji se od metalne strukture na koju su pričvršćeni zubi koji nedostaju. Proteza se pridržava za preostale zube kvačicama ili etečmenima (drikerima), koji osiguravaju nepomičnost proteze prilikom žvakanja.</p>

					<p class="font-weight-medium text-4-5 line-height-5">Krunice i mostovi</p>
					<p>Metal-keramičke krunice (metalna osnova presvučena keramikom) imaju zadovoljavajuću estetiku i još uvijek u određenim slučajevima predstavljaju jedino moguće rješenje (npr. u mostovima koji imaju velike raspone zbog gubitka velikog broja zuba).</p>
					<p>Cirkon-keramičke krunice (cirkonska baza presvučena finom keramikom) su estetski savršene krunice. Namijenjene su onima koji teže što prirodnijem savršenom osmijehu.</p>
				</div>

			</div> 

			<!-- FOOTER SKRIPTE -->
			<?php include_once('includes/footer.php'); ?>

		</div>
		

		<!-- FOOTER SKRIPTE -->
		<?php include_once('includes/footer-script.php'); ?>

	</body>

</html>
