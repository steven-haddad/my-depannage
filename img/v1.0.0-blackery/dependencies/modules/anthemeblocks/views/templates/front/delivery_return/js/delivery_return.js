$(document).ready(function(){

    $('body').on('click', '.delivery_return-open-modal-btn', function(event) {
        $('html').addClass('delivery_return-sg-open');
        $('.delivery_return-sg-cover').fadeIn();
        $('.delivery_return-sg-modal').fadeIn();
        $('.an_delivery_return').fadeIn();
    });

    $('body').on('click', '.delivery_return-sg-modal', function() {
        if ($(event.target).closest($('an_delivery_return')).length)
        return;
        $('.delivery_return-sg-cover').fadeOut(function () {
            $('html').removeClass('delivery_return-sg-open');
        });
        $('.delivery_return-sg-modal').fadeOut(function () {
            $('html').removeClass('delivery_return-sg-open');
        });
        $('.an_delivery_return').fadeOut(function () {
            $('html').removeClass('delivery_return-sg-open');
        });
        
    });
    $('body').on('click', '.delivery_return-sg-btn-close', function(event) {
        $('.delivery_return-sg-cover').fadeOut(function () {
            $('html').removeClass('delivery_return-sg-open');
        });
        $('.delivery_return-sg-modal').fadeOut(function () {
            $('html').removeClass('delivery_return-sg-open');
        });
        $('.delivery_return-an_sizeguide').fadeOut(function () {
            $('html').removeClass('delivery_return-sg-open');
        });
    });
});