$(document).ready(function(){
	$('.anthemeblocks-homeslider').addClass('owl-carousel');
	
	$('.anthemeblocks-homeslider').each(function(i, val) {
		var anhbhl_id = '#'+$(this).attr('id');
		$(anhbhl_id).owlCarouselAnTB({
			items: $(anhbhl_id).data('items'),
			loop: $(anhbhl_id).data('loop'),
			nav: $(anhbhl_id).data('nav'),
			autoplay: $(anhbhl_id).data('autoplay'),
			navText: ['<i class="icon_arrow-left"></i>','<i class="icon_arrow-right"></i>'],
			autoplayTimeout: $(anhbhl_id).data('autoplaytimeout'),
			navContainer: anhbhl_id+' .owl-stage-outer',
			smartSpeed: $(anhbhl_id).data('smartspeed'),
			dotsClass: 'owl-dots container',
		});
		$(this).parent('.anthemeblocks_homeslider-block').addClass('initialized');
	});	
	$('.anthemeblocks-homeslider .owl-next').on('click', function() {
		$(this).parents('.anthemeblocks-homeslider').addClass('slide-next');
		$(this).parents('.anthemeblocks-homeslider').removeClass('slide-prev');
	});
	$('.anthemeblocks-homeslider .owl-prev').on('click', function() {
		$(this).parents('.anthemeblocks-homeslider').addClass('slide-prev');
		$(this).parents('.anthemeblocks-homeslider').removeClass('slide-next');
	});
});