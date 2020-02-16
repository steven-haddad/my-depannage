/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // CommonJS
        factory(require('jquery'));
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {

    var pluses = /\+/g;

    function encode(s) {
        return config.raw ? s : encodeURIComponent(s);
    }

    function decode(s) {
        return config.raw ? s : decodeURIComponent(s);
    }

    function stringifyCookieValue(value) {
        return encode(config.json ? JSON.stringify(value) : String(value));
    }

    function parseCookieValue(s) {
        if (s.indexOf('"') === 0) {
            // This is a quoted cookie as according to RFC2068, unescape...
            s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
        }

        try {
            // Replace server-side written pluses with spaces.
            // If we can't decode the cookie, ignore it, it's unusable.
            // If we can't parse the cookie, ignore it, it's unusable.
            s = decodeURIComponent(s.replace(pluses, ' '));
            return config.json ? JSON.parse(s) : s;
        } catch(e) {}
    }

    function read(s, converter) {
        var value = config.raw ? s : parseCookieValue(s);
        return $.isFunction(converter) ? converter(value) : value;
    }

    var config = $.cookie = function (key, value, options) {

        // Write

        if (value !== undefined && !$.isFunction(value)) {
            options = $.extend({}, config.defaults, options);

            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setTime(+t + days * 864e+5);
            }

            return (document.cookie = [
                encode(key), '=', stringifyCookieValue(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path    ? '; path=' + options.path : '',
                options.domain  ? '; domain=' + options.domain : '',
                options.secure  ? '; secure' : ''
            ].join(''));
        }

        // Read

        var result = key ? undefined : {};

        // To prevent the for loop in the first place assign an empty array
        // in case there are no cookies at all. Also prevents odd result when
        // calling $.cookie().
        var cookies = document.cookie ? document.cookie.split('; ') : [];

        for (var i = 0, l = cookies.length; i < l; i++) {
            var parts = cookies[i].split('=');
            var name = decode(parts.shift());
            var cookie = parts.join('=');

            if (key && key === name) {
                // If second argument (value) is a function it's a converter...
                result = read(cookie, value);
                break;
            }

            // Prevent storing a cookie that we couldn't decode.
            if (!key && (cookie = read(cookie)) !== undefined) {
                result[name] = cookie;
            }
        }

        return result;
    };

    config.defaults = {};

    $.removeCookie = function (key, options) {
        if ($.cookie(key) === undefined) {
            return false;
        }

        // Must not alter options, thus extending a fresh object...
        $.cookie(key, '', $.extend({}, options, { expires: -1 }));
        return !$.cookie(key);
    };

}));

$(document).ready(function () {
	if($('#product-details .product-out-of-stock').siblings().length == 0){
		$('.tabs li a[aria-controls="product-details"]').css('display','none');
		$('.tabs li a[aria-controls="product-details"]').parent().siblings().first().children("a").addClass("active");
	}
    $('.search-button, .search-btn-close').on('click', function () {
		let el = $(this);
		let search = el.next('.search-widget') || el.closest('.search-widget');
		
		$('body').toggleClass('scroll-lock');
		if( search ) {
			el.closest('#header').find('.search-widget').toggleClass('open');
		}
		$('.sb-overlay').fadeToggle();
	});

	$('.sb-overlay').on('click', function () {
		$('.search-widget').removeClass('open');
		$('body').removeClass('scroll-lock');
    });
    $('.facet:last').css('border-bottom','0');
    $('.facet:last').css('margin-bottom','0');

    $('.mobile #menu-icon').on('click', function() {
        $('#menu-icon i').toggleClass('hidden-menu');
    });
    $('.stuff-slider').each(function(i, val) {
		var anhbhl_id = '#'+$(this).attr('id');
		$(anhbhl_id).owlCarouselAnTB({
			items: 4,
			margin: 30,
			loop: false,
			nav: true,
			autoplay: false,
			navText: ['<i class="slider-arrowleft"></i>','<i class="slider-arrowright"></i>'],
			responsive: {
				0: {
					items: 1
                },
                240: {
                    items: 1
                },
                480: {
                    items: 2
                },
                720: {
                    items: 3
                },
				960: {
					items: 4
				},
			}
		});
    });	
    $('.owl-carousel .attrributes-type-column').hover(
        function () {
            $(this).parents('.owl-carousel').css('z-index','1');
        },
        function () {
            $(this).parents('.owl-carousel').delay(500).css('z-index','0');
        }
    );
});


function lazySizes () {
    let $catimg_height;
    let imgScaling = $('.thumbnail-container-image:first img').attr('data-height') / $('.thumbnail-container-image:first img').attr('data-width');
    $('.product-thumbnail').each(function() {
        $(this).css('height',$(this).parents('.thumbnail-container-image').width()*imgScaling);
    });
    $('.product-thumbnail img').each(function() {
        $catimg_height = $(this).parents('.thumbnail-container-image').width()*imgScaling;
        $(this).parents('.thumbnail-container-image').css('min-height',$catimg_height);
    });
}
function lazyTabsSizes () {
    let imgScaling = $('.thumbnail-container-image:first img').attr('data-height') / $('.thumbnail-container-image:first img').attr('data-width');
    let $tabimg_height = $('.tab-pane.active').find('.thumbnail-container-image').width()*imgScaling;
    $('.tab-content .thumbnail-container-image').each(function() {
        $(this).css('min-height',$tabimg_height);
    });
    $('.tab-content .product-thumbnail').each(function() {
        $(this).css('height',$tabimg_height);
    });

}
$(document).ready(function () {

    if ($.cookie('an_collection_view')) {
        $('.collection-view-btn').removeClass('active');
        $('.collection-view-btn[data-xl = '+$.cookie('an_collection_view')+']').addClass('active');
    }

    $('.product-miniature').addClass('col-lg-'+$('.collection-view-btn.active').attr('data-xl'));

    $('.collection-view-btn').on('click', function() {
        $.cookie('an_collection_view', $(this).attr('data-xl'));
        $('.collection-view-btn').removeClass('active');
        $(this).addClass('active');
        $('.product-miniature').removeClass('col-lg-12 col-lg-6 col-lg-4 col-lg-3');
        $('.product-miniature').addClass('col-lg-'+$('.collection-view-btn.active').attr('data-xl'));
        lazySizes();
        lazyTabsSizes();
        if ($('.slider_product-wrapper').length) {
            slider_reload($('.an_slick-slider'));
        }

    });
    lazySizes();
    lazyTabsSizes();

    $(document).ajaxSuccess(function() {
        $('.facet:last').css('border-bottom','0');
        $('.facet:last').css('margin-bottom','0');
        
        if ($.cookie('an_collection_view')) {
            $('.collection-view-btn').removeClass('active');
            $('.collection-view-btn[data-xl = '+$.cookie('an_collection_view')+']').addClass('active');
        }
        $('.product-miniature').addClass('col-lg-'+$('.collection-view-btn.active').attr('data-xl'));

        $('.collection-view-btn').on('click', function() {
            $.cookie('an_collection_view', $(this).attr('data-xl'));
            $('.collection-view-btn').removeClass('active');
            $(this).addClass('active');
            $('.product-miniature').removeClass('col-lg-12 col-lg-6 col-lg-4 col-lg-3');
            $('.product-miniature').addClass('col-lg-'+$('.collection-view-btn.active').attr('data-xl'));
            lazySizes();
            lazyTabsSizes();
            if ($('.slider_product-wrapper').length) {
                slider_reload($('.an_slick-slider'));
            }
        });
        lazySizes();
        lazyTabsSizes();
      
    });
});
$( document ).ajaxStop(function() {
    $('.facet:last').css('border-bottom','0');
    $('.facet:last').css('margin-bottom','0');
    if ($.cookie('an_collection_view')) {
        $('.collection-view-btn').removeClass('active');
        $('.collection-view-btn[data-xl = '+$.cookie('an_collection_view')+']').addClass('active');
    }
    $('.product-miniature').addClass('col-lg-'+$('.collection-view-btn.active').attr('data-xl'));

    $('.collection-view-btn').on('click', function() {
        $.cookie('an_collection_view', $(this).attr('data-xl'));
        $('.collection-view-btn').removeClass('active');
        $(this).addClass('active');
        $('.product-miniature').removeClass('col-lg-12 col-lg-6 col-lg-4 col-lg-3');
        $('.product-miniature').addClass('col-lg-'+$('.collection-view-btn.active').attr('data-xl'));
        lazySizes();
        lazyTabsSizes();
        if ($('.slider_product-wrapper').length) {
            slider_reload($('.an_slick-slider'));
        }
    });
    lazySizes();
    lazyTabsSizes();
    
});

$(window).on('resize', function(){
    $('.collection-view-btn').on('click', function() {
        $.cookie('an_collection_view', $(this).attr('data-xl'));
        $('.collection-view-btn').removeClass('active');
        $(this).addClass('active');
        $('.product-miniature').removeClass('col-lg-12 col-lg-6 col-lg-4 col-lg-3');
        $('.product-miniature').addClass('col-lg-'+$('.collection-view-btn.active').attr('data-xl'));
        lazySizes();
        lazyTabsSizes();

    });
    lazySizes();
    lazyTabsSizes();
});