
$(document).ready(function(){
  $('#js-product-block-slider-product-page').add(".featured-products.mt-3 .products").each(function(i, val) {
  	$(this).addClass("owl-carousel");
     var anhproductSlider_id;
    if(!$(this).attr('id')){
      anhproductSlider_id = $(this);
    }
    else{
      anhproductSlider_id = '#' + $(this).attr('id');
    }
    let responsive_items;
    if ($(anhproductSlider_id).data('items') == 1) {
      responsive_items = {
        0: {
          items: 2
        },
        480: {
          items: 2
        },
        600: {
          items: 2
        },
        850: {
          items: 3
        },
        1200: {
          items: 4
        }
      }
    } else {
      responsive_items = {
        0: {
          items: 1
        },
        480: {
          items: 1
        },
        600: {
          items: 2
        },
        850: {
          items: 3
        },
        1200: {
          items: 5
        }
      }
    }
    $(anhproductSlider_id).owlCarouselAnTB({
      loop: false,
      nav: true,
      dots: true,
      margin: 30,
      navText: ['<i class="slider-arrowleft"></i>','<i class="slider-arrowright"></i>'],
      responsive:  responsive_items,
    });
  });
});
