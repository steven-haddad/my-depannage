$(document).ready(function(){
	// open modal
    var wrap = $('#wrapper'),
    btn = $('.clientservice_open-modal-btn'),
    modal = $('.clientservice_sg-cover, .clientservice_sg-modal, .an_clientservice');

    btn.on('click', function(event) {
        $('html').addClass('clientservice_sg-open');
        modal.fadeIn();
    });

    // close modal
    $('.clientservice_sg-modal').click(function() {
        var select = $('.an_clientservice');
        if ($(event.target).closest(select).length)
        return;
        modal.fadeOut(function () {
            $('html').removeClass('clientservice_sg-open');
        });
        
    });
    $('.clientservice_sg-btn-close').on('click', function(event) {
        modal.fadeOut(function () {
            $('html').removeClass('clientservice_sg-open');
        });
    });
    
});