$(document).ready(function(){
    $('body').on('click', '.open-modal-btn', function(event) {
        $('html').addClass('sg-open');
        $('.sg-cover').fadeIn();
        $('.sg-modal').fadeIn();
        $('.an_sizeguide').fadeIn();
    });

    $('body').on('click', '.sg-modal', function() {
        if ($(event.target).closest($('.an_sizeguide')).length)
        return;
        $('.sg-cover').fadeOut(function () {
            $('html').removeClass('sg-open');
        });
        $('.sg-modal').fadeOut(function () {
            $('html').removeClass('sg-open');
        });
        $('.an_sizeguide').fadeOut(function () {
            $('html').removeClass('sg-open');
        });
        
    });
    $('body').on('click', '.sg-btn-close', function(event) {
        $('.sg-cover').fadeOut(function () {
            $('html').removeClass('sg-open');
        });
        $('.sg-modal').fadeOut(function () {
            $('html').removeClass('sg-open');
        });
        $('.an_sizeguide').fadeOut(function () {
            $('html').removeClass('sg-open');
        });
    });

});
