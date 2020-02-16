$(document).ready(function(){
  
  $('.js-products-column-slider').each(function(i, val) {
    var anpcolSlider_id = '#' + $(this).attr('id');
    let responsive_items;
    if ($(anpcolSlider_id).data('mobile') == 1) {
      if ($(anpcolSlider_id).data('items') == 3) {
        console.log('1-3');
        responsive_items = {
          0: {
            items: 2
          },
          400: {
            items: 2
          },
          600: {
            items: 2
          },
          800: {
            items: 2
          },
          1200: {
            items: $(anpcolSlider_id).data('items')
          }
        }
      }
      if ($(anpcolSlider_id).data('items') == 4) {
        console.log('1-4');
        responsive_items = {
          0: {
            items: 2
          },
          240: {
            items: 2
          },
          380: {
            items: 2
          },
          720: {
            items: 3
          },
          960: {
            items: $(anpcolSlider_id).data('items')
          }
        }
      }
      if ($(anpcolSlider_id).data('items') == 5) {
        console.log('1-5');
        responsive_items = {
          0: {
            items: 2
          },
          240: {
            items: 2
          },
          380: {
            items: 2
          },
          600: {
            items: 2
          },
          720: {
            items: 3
          },
          960: {
            items: 4
          },
          1200: {
            items: $(anpcolSlider_id).data('items')
          }
        }
      }
    } else {
      if ($(anpcolSlider_id).data('items') == 3) {
        console.log('2-3');
        responsive_items = {
          0: {
            items: 1
          },
          400: {
            items: 1
          },
          800: {
            items: 2
          },
          1200: {
            items: $(anpcolSlider_id).data('items')
          }
        }
      }
      if ($(anpcolSlider_id).data('items') == 4) {
        console.log('2-4');
        responsive_items = {
          0: {
            items: 1
          },
          240: {
            items: 1
          },
          380: {
            items: 2
          },
          720: {
            items: 3
          },
          960: {
            items: $(anpcolSlider_id).data('items')
          }
        }
      }
      if ($(anpcolSlider_id).data('items') == 5) {
        console.log('2-5');
        responsive_items = {
          0: {
            items: 1
          },
          240: {
            items: 1
          },
          380: {
            items: 2
          },
          720: {
            items: 3
          },
          960: {
            items: 4
          },
          1200: {
            items: $(anpcolSlider_id).data('items')
          }
        }
      }
    }
    $(anpcolSlider_id).owlCarouselAnTB({
      margin: 30,
      loop: $(anpcolSlider_id).data('loop'),
      nav: $(anpcolSlider_id).data('nav'),
      dots: $(anpcolSlider_id).data('dots'),
      autoplay: $(anpcolSlider_id).data('autoplay'),
      navText: ['<i class="slider-arrowleft"></i>','<i class="slider-arrowright"></i>'],
      autoplayTimeout: $(anpcolSlider_id).data('autoplaytimeout'),
      responsive: responsive_items,
    });
  });
  $('.js-products-column-slider').each(function() {
    $(this).find('.product-miniature').each(function(i) {
      $(this).css('animation-delay','0.' + i + 's');
    });
  });
});