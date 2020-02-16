$(document).ready(function(){
	$('.anthemeblocks-newsslider').each(function(i, val) {
		var anhbhl_id = '#'+$(this).attr('id');
		$(anhbhl_id).owlCarouselAnTB({
			items: 2,
			margin: 30,
			loop: $(anhbhl_id).data('loop'),
			nav: $(anhbhl_id).data('nav'),
			autoplay: $(anhbhl_id).data('autoplay'),
			navText: ['<i class="slider-arrowleft"></i>','<i class="slider-arrowright"></i>'],
			autoplayTimeout: $(anhbhl_id).data('autoplaytimeout'),
			smartSpeed: $(anhbhl_id).data('smartspeed'),
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 2
				},
			}
		});
	});	
	$('.anthemeblocks-newsslider .owl-next').on('click', function() {
		$(this).parents('.anthemeblocks-newsslider').addClass('slide-next');
		$(this).parents('.anthemeblocks-newsslider').removeClass('slide-prev');
	});
	$('.anthemeblocks-newsslider .owl-prev').on('click', function() {
		$(this).parents('.anthemeblocks-newsslider').addClass('slide-prev');
		$(this).parents('.anthemeblocks-newsslider').removeClass('slide-next');
	});
});