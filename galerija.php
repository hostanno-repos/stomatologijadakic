<!-- HEAD -->
<?php 
	include_once('includes/head.php'); 
	$active = "galerija";
	
	// Connect to CMS database
	$cms_db_host = "localhost";
	$cms_db_name = "doktordakic_dakic_cms";
	$cms_db_user = "doktordakic_dakic_cms";
	$cms_db_pass = "53rpWmwldqj1n2F4";
	
	try {
		$cms_pdo = new PDO(
			"mysql:host={$cms_db_host};dbname={$cms_db_name};charset=utf8mb4",
			$cms_db_user,
			$cms_db_pass,
			[
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			]
		);
		
		// Get active galleries with image count
		$galleries_query = "
			SELECT g.*, COUNT(i.id) as image_count 
			FROM galleries g 
			LEFT JOIN images i ON g.id = i.gallery_id 
			WHERE g.status = 'active'
			GROUP BY g.id 
			ORDER BY g.sort_order ASC, g.created_at DESC
		";
		$galleries_stmt = $cms_pdo->query($galleries_query);
		$galleries = $galleries_stmt->fetchAll();
		
		// Get selected gallery and its images if gallery ID is provided
		$selected_gallery = null;
		$gallery_images = [];
		$gallery_id = isset($_GET['album']) ? (int)$_GET['album'] : 0;
		
		if ($gallery_id > 0) {
			$gallery_stmt = $cms_pdo->prepare("SELECT * FROM galleries WHERE id = ? AND status = 'active'");
			$gallery_stmt->execute([$gallery_id]);
			$selected_gallery = $gallery_stmt->fetch();
			
			if ($selected_gallery) {
				$images_stmt = $cms_pdo->prepare("
					SELECT * FROM images 
					WHERE gallery_id = ? 
					ORDER BY sort_order ASC, created_at DESC
				");
				$images_stmt->execute([$gallery_id]);
				$gallery_images = $images_stmt->fetchAll();
			}
		}
	} catch (PDOException $e) {
		$galleries = [];
		$selected_gallery = null;
		$gallery_images = [];
		error_log("Gallery DB Error: " . $e->getMessage());
	}
	
	// Base URL for admin assets
	$admin_url = "admin";
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
								<h1 class="text-color-dark font-weight-bold text-9"><?php echo function_exists('getContent') ? getContent('galerija', 'page_title', 'Galerija') : 'Galerija'; ?></h1>
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

				<?php if ($gallery_id > 0 && $selected_gallery): ?>
					<!-- Back to Albums -->
					<div class="container pt-2 pb-3">
						<div class="row">
							<div class="col">
								<a href="galerija.php" class="text-decoration-none text-color-primary">
									<i class="fas fa-arrow-left me-2"></i> <?php echo function_exists('getContent') ? getContent('galerija', 'back_to_albums', 'Nazad na albume') : 'Nazad na albume'; ?>
								</a>
							</div>
						</div>
					</div>
					
					<!-- Gallery Images -->
					<div class="container pt-2 pb-5">
						<div class="row mb-4">
							<div class="col">
								<h2 class="text-color-dark font-weight-bold text-6 mb-2"><?php echo htmlspecialchars($selected_gallery['title']); ?></h2>
								<?php if (!empty($selected_gallery['description'])): ?>
									<p class="text-3-5 text-color-default"><?php echo nl2br(htmlspecialchars($selected_gallery['description'])); ?></p>
								<?php endif; ?>
							</div>
						</div>
						
						<?php if (!empty($gallery_images)): ?>
							<div class="row gallery-images-grid" data-gallery-id="<?php echo $gallery_id; ?>">
								<?php foreach ($gallery_images as $index => $image): ?>
									<?php 
									// Build correct media URL - file_path is stored as /assets/uploads/galleries/X/filename.jpg
									// Media files are physically stored in /admin/assets/uploads/, so we need to prepend /admin
									// Since we're in root, we also need to prepend the project folder name
									$media_url = '/admin/' . ltrim($image['file_path'], '/');
									$isVideo = strpos($image['mime_type'] ?? '', 'video/') === 0;
									// For file path, remove leading slash and use relative path from __DIR__
									$file_path_clean = ltrim($image['file_path'], '/');
									$image_path = __DIR__ . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file_path_clean);
									$image_exists = file_exists($image_path);
									// Show media even if file_exists check fails (might be path issue, but URL could still work)
									?>
									<div class="col-6 col-md-4 col-lg-3 mb-4">
										<a href="<?php echo htmlspecialchars($media_url); ?>" 
										   class="gallery-media-link lightbox d-block position-relative overflow-hidden <?php echo $isVideo ? 'gallery-video-link' : 'gallery-image-link'; ?>" 
										   data-plugin-lightbox="true"
										   data-gallery="gallery-<?php echo $gallery_id; ?>"
										   data-index="<?php echo $index; ?>"
										   data-type="<?php echo $isVideo ? 'video' : 'image'; ?>"
										   data-video-autoplay="true"
										   title="<?php echo htmlspecialchars($image['title'] ?? $image['original_filename'] ?? ''); ?>">
											<?php if ($isVideo): ?>
												<video class="img-fluid w-100" style="height: 250px; object-fit: cover; transition: transform 0.3s ease;" muted>
													<source src="<?php echo htmlspecialchars($media_url); ?>" type="<?php echo htmlspecialchars($image['mime_type']); ?>">
												</video>
												<div class="video-badge position-absolute top-0 end-0 m-2" style="background: rgba(0,0,0,0.7); color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">
													<i class="fas fa-video"></i>
												</div>
											<?php else: ?>
												<img src="<?php echo htmlspecialchars($media_url); ?>" 
												     alt="<?php echo htmlspecialchars($image['alt_text'] ?? $image['title'] ?? $selected_gallery['title']); ?>" 
												     class="img-fluid w-100"
												     style="height: 250px; object-fit: cover; transition: transform 0.3s ease;"
												     onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=\'height:250px; display:flex; align-items:center; justify-content:center; background:#f8f9fa; color:#999;\'>Slika nije pronađena</div>';">
											<?php endif; ?>
											<div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
											     style="background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.3s ease;">
												<i class="fas <?php echo $isVideo ? 'fa-play' : 'fa-search-plus'; ?> text-white" style="font-size: 2rem;"></i>
											</div>
										</a>
									</div>
								<?php endforeach; ?>
							</div>
						<?php else: ?>
							<div class="row">
								<div class="col text-center py-5">
									<p class="text-3-5 text-color-default"><?php echo function_exists('getContent') ? getContent('galerija', 'no_images', 'Nema slika ili video fajlova u ovoj galeriji.') : 'Nema slika ili video fajlova u ovoj galeriji.'; ?></p>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php else: ?>
					<!-- Albums Grid -->
					<div class="container pt-4 pb-5">
						<?php if (!empty($galleries)): ?>
							<div class="row gallery-albums-grid">
								<?php foreach ($galleries as $gallery): ?>
									<?php 
									// Get first image (not video) as cover
									$cover_image = null;
									if ($gallery['image_count'] > 0) {
										$cover_stmt = $cms_pdo->prepare("SELECT file_path, mime_type FROM images WHERE gallery_id = ? AND mime_type NOT LIKE 'video/%' ORDER BY sort_order ASC, created_at ASC LIMIT 1");
										$cover_stmt->execute([$gallery['id']]);
										$cover_result = $cover_stmt->fetch();
										if ($cover_result) {
											// Images are physically stored in /admin/assets/uploads/, so we need to prepend /admin
											$cover_image = '/admin/' . ltrim($cover_result['file_path'], '/');
										}
									}
									?>
									<div class="col-6 col-md-4 col-lg-3 mb-4">
										<a href="galerija.php?album=<?php echo $gallery['id']; ?>" 
										   class="gallery-album-card d-block text-decoration-none position-relative overflow-hidden"
										   style="background: #f8f9fa; border-radius: 0.5rem; transition: transform 0.3s ease, box-shadow 0.3s ease;">
											<div class="album-cover position-relative" style="height: 250px; overflow: hidden;">
												<?php if ($cover_image): ?>
													<img src="<?php echo htmlspecialchars($cover_image); ?>" 
													     alt="<?php echo htmlspecialchars($gallery['title']); ?>" 
													     class="w-100 h-100"
													     style="object-fit: cover; transition: transform 0.3s ease;"
													     onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=\'height:100%; display:flex; align-items:center; justify-content:center; background:#f8f9fa;\'><i class=\'fas fa-images text-color-default\' style=\'font-size: 4rem; opacity: 0.3;\'></i></div>';">
												<?php else: ?>
													<div class="d-flex align-items-center justify-content-center h-100">
														<i class="fas fa-images text-color-default" style="font-size: 4rem; opacity: 0.3;"></i>
													</div>
												<?php endif; ?>
												<div class="album-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
												     style="background: rgba(0,0,0,0.6); opacity: 0; transition: opacity 0.3s ease;">
													<div class="text-center text-white">
														<i class="fas fa-eye mb-2" style="font-size: 2rem;"></i>
														<p class="mb-0 font-weight-semibold"><?php echo function_exists('getContent') ? getContent('galerija', 'view_album', 'Pogledaj album') : 'Pogledaj album'; ?></p>
													</div>
												</div>
												<div class="album-count position-absolute top-0 end-0 m-3">
													<span class="badge bg-primary text-white" style="font-size: 0.875rem; padding: 0.5rem 0.75rem;">
														<?php echo (int)$gallery['image_count']; ?> slika
													</span>
												</div>
											</div>
											<div class="album-info p-3">
												<h3 class="text-color-dark font-weight-semibold text-4 mb-2" style="line-height: 1.3;">
													<?php echo htmlspecialchars($gallery['title']); ?>
												</h3>
												<?php if (!empty($gallery['description'])): ?>
													<p class="text-2-5 text-color-default mb-0" style="line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
														<?php echo htmlspecialchars($gallery['description']); ?>
													</p>
												<?php endif; ?>
											</div>
										</a>
									</div>
								<?php endforeach; ?>
							</div>
						<?php else: ?>
							<div class="row">
								<div class="col text-center py-5">
									<p class="text-3-5 text-color-default">Trenutno nema dostupnih galerija.</p>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<section class="section border-0 bg-color-light m-0 py-5">
					<div class="container py-5 my-2">
						<div class="row">
							<div class="col-lg-6 mb-5 mb-lg-0">
								<h2 class="d-inline-block line-height-5 text-4 positive-ls-3 font-weight-semibold text-color-primary mb-2 appear-animation" data-appear-animation="fadeInUpShorter"><?php echo function_exists('getContent') ? getContent('galerija', 'offer_section_title', 'SPECIJALNA PONUDA') : 'SPECIJALNA PONUDA'; ?></h2>
								<h3 class="text-color-dark text-9 line-height-3 text-transform-none font-weight-semibold mb-4 mb-lg-3 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250"><?php echo function_exists('getContent') ? getContent('galerija', 'offer_main_title', 'Izdvojena ponuda dostupna svim našim pacijentima') : 'Izdvojena ponuda dostupna svim našim pacijentima'; ?></h3>
								<p class="text-3-5 font-weight-medium pb-1 mb-4 mb-lg-2 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500"><?php echo function_exists('getContent') ? getContent('galerija', 'offer_description', 'Svaki novi pacijent u našim prostorijama može obaviti BESPLATAN pregled kao i konsultacije sa našim timom u slučaju da Vam treba bilo kakava intervencija.') : 'Svaki novi pacijent u našim prostorijama može obaviti BESPLATAN pregled kao i konsultacije sa našim timom u slučaju da Vam treba bilo kakava intervencija.'; ?></p>
								
							</div>

							<div class="col-lg-6 mb-5">
								<ul class="list list-icons list-icons-lg ms-lg-3 mt-lg-4 pt-lg-2">
									<li class="text-3-5 font-weight-medium appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200"><i class="fas fa-check text-color-tertiary"></i> <span class="ps-2 d-block"><?php echo function_exists('getContent') ? getContent('galerija', 'offer_item1', 'BESPLATAN detaljni pregled') : 'BESPLATAN detaljni pregled'; ?></span></li>
									<li class="text-3-5 font-weight-medium appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400"><i class="fas fa-check text-color-tertiary"></i> <span class="ps-2 d-block"><?php echo function_exists('getContent') ? getContent('galerija', 'offer_item2', 'BESPLATNE konsultacije') : 'BESPLATNE konsultacije'; ?></span></li>
									<li class="text-3-5 font-weight-medium appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600"><i class="fas fa-check text-color-tertiary"></i> <span class="ps-2 d-block"><?php echo function_exists('getContent') ? getContent('galerija', 'offer_item3', 'BESPLATNI sajveti') : 'BESPLATNI sajveti'; ?></span></li>
									<li class="text-3-5 font-weight-medium appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600"><i class="fas fa-check text-color-tertiary"></i> <span class="ps-2 d-block"><?php echo function_exists('getContent') ? getContent('galerija', 'offer_item4', 'ČEKAMO VAS!') : 'ČEKAMO VAS!'; ?></span></li>
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
									<strong><?php echo function_exists('getContent') ? getContent('galerija', 'cta_text', 'Rezervišite svoj termin') : 'Rezervišite svoj termin'; ?></strong> - <?php echo function_exists('getContent') ? getContent('galerija', 'cta_subtext', 'Trebate hitnu intervenciju? Pozovite') : 'Trebate hitnu intervenciju? Pozovite'; ?> <u><?php echo function_exists('getContent') ? getContent('galerija', 'cta_phone', '+387 66 096 666') : '+387 66 096 666'; ?></u>
								</p>
							</div>
							<div class="col-lg-3 text-center text-md-start text-lg-end">
								<a href="kontakt.php#book" class="btn btn-secondary border-0 text-3-5 font-weight-semi-bold btn-px-5 btn-py-3"><?php echo function_exists('getContent') ? getContent('galerija', 'cta_button', 'Rezervišite termin') : 'Rezervišite termin'; ?></a>
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
		
		<?php if ($gallery_id > 0 && !empty($gallery_images)): ?>
		<!-- Gallery Lightbox Script -->
		<script>
		(function($) {
			'use strict';
			
			// Initialize lightbox manually
			function initGalleryLightbox() {
				if (typeof $ === 'undefined' || typeof $.fn === 'undefined') {
					setTimeout(initGalleryLightbox, 100);
					return;
				}
				
				if (typeof $.fn.magnificPopup !== 'undefined') {
					var $imageLinks = $('.gallery-images-grid .gallery-image-link.lightbox');
					var $videoLinks = $('.gallery-images-grid .gallery-video-link.lightbox');
					
					// Initialize images
					if ($imageLinks.length > 0) {
						$imageLinks.off('click.magnificPopup');
						$imageLinks.magnificPopup({
							type: 'image',
							gallery: {
								enabled: true,
								navigateByImgClick: true,
								preload: [0, 1],
								tPrev: 'Prethodna slika',
								tNext: 'Sledeća slika',
								tCounter: '<span class="mfp-counter">%curr% od %total%</span>'
							},
							image: {
								tError: '<a href="%url%">Slika #%curr%</a> se ne može učitati.',
								titleSrc: function(item) {
									return item.el.attr('title') || '';
								}
							},
							mainClass: 'mfp-with-zoom',
							zoom: {
								enabled: true,
								duration: 300
							},
							callbacks: {
								open: function() {
									$('body').addClass('lightbox-opened');
								},
								close: function() {
									$('body').removeClass('lightbox-opened');
								}
							}
						});
					}
					
					// Initialize videos with autoplay
					if ($videoLinks.length > 0) {
						$videoLinks.off('click.magnificPopup');
						$videoLinks.on('click', function(e) {
							e.preventDefault();
							var $link = $(this);
							var videoUrl = $link.attr('href');
							var mimeType = $link.data('mime-type') || 'video/mp4';
							
							// Create custom popup for video
							$.magnificPopup.open({
								items: {
									src: '<div class="mfp-video-container" style="text-align: center; padding: 20px;"><video controls autoplay muted loop style="width: 100%; max-width: 90vw; max-height: 90vh; outline: none;" class="mfp-video"><source src="' + videoUrl + '" type="' + mimeType + '">Vaš browser ne podržava video tag.</video></div>',
									type: 'inline'
								},
								mainClass: 'mfp-fade',
								removalDelay: 300,
								callbacks: {
									open: function() {
										$('body').addClass('lightbox-opened');
									},
									close: function() {
										$('body').removeClass('lightbox-opened');
										// Stop video playback
										$('.mfp-video').each(function() {
											this.pause();
											this.currentTime = 0;
										});
									}
								}
							});
						});
					}
					
					console.log('Gallery lightbox initialized for ' + ($imageLinks.length + $videoLinks.length) + ' media files');
				} else {
					setTimeout(initGalleryLightbox, 200);
				}
			}
			
			// Try multiple times to ensure scripts are loaded
			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', function() {
					setTimeout(initGalleryLightbox, 1000);
				});
			} else {
				setTimeout(initGalleryLightbox, 1000);
			}
			
			// Also try on window load
			window.addEventListener('load', function() {
				setTimeout(initGalleryLightbox, 500);
			});
			
			// Fallback - try after longer delay
			setTimeout(initGalleryLightbox, 2000);
		})(typeof jQuery !== 'undefined' ? jQuery : typeof $ !== 'undefined' ? $ : null);
		</script>
		
		<style>
		/* Gallery Album Hover Effects */
		.gallery-album-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 10px 30px rgba(0,0,0,0.15);
		}
		
		.gallery-album-card:hover .album-cover img {
			transform: scale(1.1);
		}
		
		.gallery-album-card:hover .album-overlay {
			opacity: 1 !important;
		}
		
		/* Gallery Image Hover Effects */
		.gallery-image-link:hover .gallery-overlay {
			opacity: 1 !important;
		}
		
		.gallery-image-link:hover img {
			transform: scale(1.05);
		}
		
		/* Magnific Popup Customization */
		.mfp-with-zoom .mfp-container,
		.mfp-with-zoom.mfp-bg {
			opacity: 0;
			-webkit-backface-visibility: hidden;
			backface-visibility: hidden;
			-webkit-transition: all 0.3s ease-out;
			-moz-transition: all 0.3s ease-out;
			-o-transition: all 0.3s ease-out;
			transition: all 0.3s ease-out;
		}
		
		.mfp-with-zoom.mfp-ready .mfp-container {
			opacity: 1;
		}
		
		.mfp-with-zoom.mfp-ready.mfp-bg {
			opacity: 0.8;
		}
		
		.mfp-with-zoom.mfp-removing .mfp-container,
		.mfp-with-zoom.mfp-removing.mfp-bg {
			opacity: 0;
		}
		
		.mfp-counter {
			color: #fff;
			font-size: 1rem;
		}
		
		.mfp-arrow-left:before,
		.mfp-arrow-right:before {
			border: none;
		}
		
		.mfp-arrow-left:after,
		.mfp-arrow-right:after {
			border-top-width: 17px;
			border-bottom-width: 17px;
		}
		
		/* Responsive adjustments */
		@media (max-width: 991px) {
			.gallery-albums-grid .col-lg-3 {
				flex: 0 0 50%;
				max-width: 50%;
			}
		}
		
		@media (max-width: 768px) {
			.gallery-albums-grid .col-md-4,
			.gallery-images-grid .col-md-4 {
				flex: 0 0 50%;
				max-width: 50%;
			}
			
			.album-cover,
			.gallery-image-link img {
				height: 200px !important;
			}
		}
		
		@media (max-width: 576px) {
			.gallery-albums-grid .col-6,
			.gallery-images-grid .col-6 {
				flex: 0 0 100%;
				max-width: 100%;
			}
			
			.album-cover,
			.gallery-image-link img {
				height: 250px !important;
			}
			
			.album-info h3 {
				font-size: 1rem !important;
			}
		}
		</style>
		<?php endif; ?>

	</body>

</html>
