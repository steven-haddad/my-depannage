$(document).ready(function() {
  var elemSideBar = $('<div id="js-cart-sidebar" class="cart-preview"></div>').insertAfter('main').wrapAll('<div class="sb-menu-right"></div>'),
      elemOverlay = $('<div class="sb-overlay"></div>').insertAfter('main'),
      elemCloseBtn = $('<div class="sb-close-btn"><i class="material-icons">&#xE5CD;</i></div>');

  elemCloseBtn.prependTo('.sb-menu-right');

  $('#js-cart-sidebar').html($('.js-cart-source').html());

  $('#_desktop_cart').add('#_mobile_cart').on('click', function(e) {
      $('html').addClass('sb-open');
      $('.sb-overlay ').fadeIn(500);
      $('#scrolltopbtn').hide();
      return false;
  });

  $('.sb-overlay').add('.sb-close-btn').on('click', function() {
    $('.sb-overlay').fadeOut('500');
    $('html').removeClass('sb-open');
    $('#scrolltopbtn').show();
  });

  prestashop.on(
      'updateCart',
      function (event) {
        var refreshURL = $('.blockcart').data('refresh-url');
        var requestData = {};

        if (event && event.reason) {
          requestData = {
            id_product_attribute: event.reason.idProductAttribute,
            id_product: event.reason.idProduct,
            action: event.reason.linkAction
          };
        }

        $.post(refreshURL, requestData).then(function (resp) {
          $('.blockcart .header').replaceWith($(resp.preview).find('.blockcart .header'));
          $('.blockcart .cart-dropdown-wrapper').replaceWith($(resp.preview).find('.blockcart .cart-dropdown-wrapper'));
          $('.blockcart').removeClass('inactive').addClass('active');

          if ($('.sb-menu-right').length) {
            $('#js-cart-sidebar .cart-dropdown-wrapper').replaceWith($(resp.preview).find('.blockcart .cart-dropdown-wrapper'));
            if (prestashop.page.page_name != 'cart' && prestashop.page.page_name != 'checkout') {
              $('html').addClass('sb-open');
              $('.sb-overlay ').fadeIn(500);
              $('#scrolltopbtn').hide();
            }
          } else {
            if (resp.modal) {
              showModal(resp.modal);
            }
          }
        }).fail(function (resp) {
          prestashop.emit('handleError', {eventType: 'updateShoppingCart', resp: resp});
        });
      }
    );
});