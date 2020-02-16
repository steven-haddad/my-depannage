import $ from 'jquery';
$(document).ready(function () {

	$('.js-product-images-modal').removeClass("in").removeAttr("aria-hidden");
	$(".modal-backdrop").remove();
	if($(".modal-dialog .js-modal-thumb").width()){
		$(".close-slider").css("max-width",$(".modal-dialog .js-modal-thumb").width());
	}
	
	function productzoomslider () {
		$('#owl-carousel-slider').each(function(i, val) {
			var anhbhl_id = '#'+$(this).attr('id');
			if($(this).find('.thumb-container').length>1){
			$(anhbhl_id).owlCarouselAnTB({
				items: 1,
				loop: true,
				nav: true,
				autoplay: false,
				navText: ['<i class="material-icons">&#xE5C5;</i>','<i class="material-icons">&#xE5C5;</i>'],
			});
			}
		});	
		$('#product .modal-dialog').on("click",function(h){
			var target = $(h.target);
			if(target.closest("img").length != 0 || target.closest(".owl-nav i").length != 0){
					return;
			}
			else{
				$('.js-product-images-modal').add(".modal-backdrop").fadeOut("fast");
				$('.js-product-images-modal').removeClass("in").attr("aria-hidden","true");
				$('body').removeClass("modal-open");
				$('#product').removeAttr("style");
			}
		});
	}

	productzoomslider();

	 $(document).ajaxSuccess(function() {
	    productzoomslider();
	 });
});
