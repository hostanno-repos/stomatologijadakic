<!-- HEAD -->
<?php 
	include_once('includes/head.php'); 
	include_once('includes/cms_db_config.php');
	$active = "novosti";
	
	// Helper function for sanitization
	if (!function_exists('sanitize')) {
		function sanitize($input) {
			return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
		}
	}
	
	try {
		$cms_pdo = new PDO(
			"mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . (defined('DB_CHARSET') ? DB_CHARSET : 'utf8mb4'),
			DB_USER,
			DB_PASS,
			[
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			]
		);
		
		// Get single news item if slug is provided
		$news_slug = isset($_GET['slug']) ? sanitize($_GET['slug']) : null;
		$single_news = null;
		$all_news = [];
		
		if ($news_slug) {
			// Get single news item
			$stmt = $cms_pdo->prepare("SELECT * FROM news WHERE slug = ? AND status = 'published' LIMIT 1");
			$stmt->execute([$news_slug]);
			$single_news = $stmt->fetch();
		} else {
			// Get all published news ordered by published_date
			$stmt = $cms_pdo->query("
				SELECT * FROM news 
				WHERE status = 'published' 
				ORDER BY published_date DESC, created_at DESC
			");
			$all_news = $stmt->fetchAll();
		}
	} catch (PDOException $e) {
		$all_news = [];
		$single_news = null;
		error_log("News DB Error: " . $e->getMessage());
	}
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
									<li class="text-capitalize active">Novosti</li>
								</ul>
							</div>
						</div>
					</div>
				</section>

				<?php if ($single_news): ?>
					<!-- Single News View -->
					<div class="container pt-4 pb-5">
						<div class="row">
							<div class="col-lg-8 offset-lg-2">
								<a href="novosti.php" class="text-decoration-none text-color-primary mb-4 d-inline-block">
									<i class="fas fa-arrow-left me-2"></i> Nazad na novosti
								</a>
								
								<article class="news-single">
									<?php if (!empty($single_news['featured_image'])): ?>
										<div class="news-featured-image mb-4">
											<img src="/admin/<?php echo ltrim($single_news['featured_image'], '/'); ?>" 
											     alt="<?php echo htmlspecialchars($single_news['title']); ?>" 
											     class="img-fluid w-100"
											     style="border-radius: 0.5rem;">
										</div>
									<?php endif; ?>
									
									<header class="news-header mb-4">
										<h1 class="text-color-dark font-weight-bold text-7 mb-3">
											<?php echo htmlspecialchars($single_news['title']); ?>
										</h1>
										<div class="news-meta text-color-default text-3 mb-3">
											<i class="far fa-calendar me-2"></i>
											<?php 
											if ($single_news['published_date']) {
												echo date('d.m.Y', strtotime($single_news['published_date']));
											} else {
												echo date('d.m.Y', strtotime($single_news['created_at']));
											}
											?>
										</div>
										<?php if (!empty($single_news['excerpt'])): ?>
											<p class="text-4 text-color-default font-weight-medium">
												<?php echo nl2br(htmlspecialchars($single_news['excerpt'])); ?>
											</p>
										<?php endif; ?>
									</header>
									
									<div class="news-content text-3-5 line-height-5">
										<?php echo $single_news['content']; ?>
									</div>
								</article>
							</div>
						</div>
					</div>
				<?php else: ?>
					<!-- News List View -->
					<div class="container pt-4 pb-5">
						<?php if (!empty($all_news)): ?>
							<div class="row">
								<?php foreach ($all_news as $item): ?>
									<div class="col-lg-4 col-md-6 mb-4">
										<article class="news-card h-100" style="background: white; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; overflow: hidden; transition: all 0.3s ease; display: flex; flex-direction: column;">
											<?php if (!empty($item['featured_image'])): ?>
												<a href="novosti.php?slug=<?php echo htmlspecialchars($item['slug']); ?>" class="news-card-image d-block" style="position: relative; overflow: hidden;">
													<img src="/admin/<?php echo ltrim($item['featured_image'], '/'); ?>" 
													     alt="<?php echo htmlspecialchars($item['title']); ?>" 
													     class="img-fluid w-100"
													     style="height: 200px; object-fit: cover; transition: transform 0.3s ease;">
												</a>
											<?php endif; ?>
											
											<div class="news-card-content p-4" style="flex: 1; display: flex; flex-direction: column;">
												<div class="news-card-meta text-2 mb-2" style="color: #74788d;">
													<i class="far fa-calendar me-1"></i>
													<?php 
													if ($item['published_date']) {
														echo date('d.m.Y', strtotime($item['published_date']));
													} else {
														echo date('d.m.Y', strtotime($item['created_at']));
													}
													?>
												</div>
												
												<h3 class="news-card-title mb-3" style="font-size: 1.25rem; font-weight: 600; line-height: 1.4;">
													<a href="novosti.php?slug=<?php echo htmlspecialchars($item['slug']); ?>" 
													   class="text-color-dark text-decoration-none">
														<?php echo htmlspecialchars($item['title']); ?>
													</a>
												</h3>
												
												<?php if (!empty($item['excerpt'])): ?>
													<p class="news-card-excerpt text-3 mb-3" style="color: #495057; line-height: 1.6; flex: 1;">
														<?php echo nl2br(htmlspecialchars($item['excerpt'])); ?>
													</p>
												<?php else: ?>
													<p class="news-card-excerpt text-3 mb-3" style="color: #495057; line-height: 1.6; flex: 1;">
														<?php echo strip_tags(substr($item['content'], 0, 150)) . '...'; ?>
													</p>
												<?php endif; ?>
												
												<a href="novosti.php?slug=<?php echo htmlspecialchars($item['slug']); ?>" 
												   class="btn btn-primary align-self-start"
												   style="padding: 0.5rem 1.25rem; background: #556ee6; color: white; text-decoration: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500;">
													Pročitaj više
												</a>
											</div>
										</article>
									</div>
								<?php endforeach; ?>
							</div>
						<?php else: ?>
							<div class="row">
								<div class="col text-center py-5">
									<p class="text-3-5 text-color-default">Trenutno nema objavljenih novosti.</p>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<style>
				/* News Card Hover Effects */
				.news-card:hover {
					transform: translateY(-5px);
					box-shadow: 0 10px 30px rgba(0,0,0,0.15);
				}
				
				.news-card:hover .news-card-image img {
					transform: scale(1.05);
				}
				
				/* News Content Styling */
				.news-content {
					color: #495057;
				}
				
				.news-content h1,
				.news-content h2,
				.news-content h3,
				.news-content h4 {
					color: #343a40;
					margin-top: 1.5rem;
					margin-bottom: 1rem;
				}
				
				.news-content p {
					margin-bottom: 1rem;
				}
				
				.news-content img {
					max-width: 100%;
					height: auto;
					border-radius: 0.375rem;
					margin: 1rem 0;
				}
				
				.news-content ul,
				.news-content ol {
					margin-bottom: 1rem;
					padding-left: 2rem;
				}
				
				.news-content a {
					color: #556ee6;
					text-decoration: none;
				}
				
				.news-content a:hover {
					text-decoration: underline;
				}
				
				/* Responsive adjustments */
				@media (max-width: 991px) {
					.news-card {
						margin-bottom: 1.5rem;
					}
				}
				</style>

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
								<a href="kontakt.php#book" class="btn btn-secondary border-0 text-3-5 font-weight-semi-bold btn-px-5 btn-py-3">Rezervišite termin</a>
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
