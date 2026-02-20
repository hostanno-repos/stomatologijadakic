<!-- Vendor -->
<script src="vendor/plugins/js/plugins.min.js"></script>
<script src="vendor/twentytwenty/js/jquery.event.move.js"></script>
<script src="vendor/twentytwenty/js/jquery.twentytwenty.js"></script>
<!-- Theme Base, Components and Settings -->
<script src="js/theme.js"></script>
<!-- Current Page Vendor and Views -->
<script src="js/views/view.contact.js"></script>
<!-- Demo -->
<script src="js/demos/demo-dentist.js"></script>
<!-- Theme Initialization Files -->
<script src="js/theme.init.js"></script>
<!-- Team carousel – strelice za listanje zaposlenih -->
<script>
(function($) {
	$(document).on('click', '.team-carousel-nav .owl-prev', function(e) {
		e.preventDefault();
		var $carousel = $(this).closest('.p-relative').find('.js-team-carousel');
		if ($carousel.length && $carousel.data('owl.carousel')) $carousel.trigger('prev.owl.carousel');
	});
	$(document).on('click', '.team-carousel-nav .owl-next', function(e) {
		e.preventDefault();
		var $carousel = $(this).closest('.p-relative').find('.js-team-carousel');
		if ($carousel.length && $carousel.data('owl.carousel')) $carousel.trigger('next.owl.carousel');
	});
})(jQuery);
</script>