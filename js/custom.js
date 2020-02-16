(function ($) {

    // Init Wow
    wow = new WOW({
        animateClass: 'animated',
        offset: 100
    });
    wow.init();

    // Navigation scrolls
    $('.navbar-nav li a').bind('click', function (event) {
        $('.navbar-nav li').removeClass('active');
        $(this).closest('li').addClass('active');
        var $anchor = $(this);
        var nav = $($anchor.attr('href'));
        if (nav.length) {
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');

            event.preventDefault();
        }
    });

    // About section scroll
    $(".overlay-detail a").on('click', function (event) {
        event.preventDefault();
        var hash = this.hash;
        $('html, body').animate({
            scrollTop: $(hash).offset().top
        }, 900, function () {
            window.location.hash = hash;
        });
    });

    //jQuery to collapse the navbar on scroll
    $(window).scroll(function () {
        if ($(".navbar-default").offset().top > 50) {
            $(".navbar-fixed-top").addClass("top-nav-collapse");
        } else {
            $(".navbar-fixed-top").removeClass("top-nav-collapse");
        }
    });

    // Testimonials Slider
    $('.bxslider').bxSlider({
        adaptiveHeight: true,
        mode: 'fade'
    });

    var $firstButton = $(".first"),
        $secondButton = $(".second"),
        $input = $("input"),
        $name = $(".name"),
        $more = $(".more"),
        $yourname = $(".yourname"),
        $reset = $(".reset"),
        $ctr = $(".sliderForm");

    $firstButton.on("click", function (e) {
        $(this).text("Enregistrement...").delay(900).queue(function () {
            $ctr.addClass("center slider-two-active").removeClass("full slider-one-active");
        });
        e.preventDefault();
    });

    $secondButton.on("click", function (e) {
        $("form.contactFormStepper").validate();
        $("form.contactFormStepper").on('submit', function (e) {
            var isvalid = $("form.contactFormStepper").valid();
            if (isvalid) {
                e.preventDefault();
                var str = $(this).serialize();
                function gtag_report_conversion(url) {
                    var callback = function () {
                        if (typeof (url) != 'undefined') {
                            window.location = url;
                        }
                    };
                    gtag('event', 'conversion', {
                        'send_to': 'AW-974382576/LqWNCLKlh6UBEPDLz9AD',
                        'inscription': 1.0
                    });
                    return false;
                }
                $(this).text("Enregistrement...").delay(900).queue(function () {
                    $ctr.addClass("center slider-three-active").removeClass("center slider-two-active slider-one-active");
                    $("#sendmessage").addClass("show");
                    $("#errormessage").removeClass("show");
                    gtag_report_conversion('https://transition-pacte-energie.fr/')

                    $.ajax({
                        type: "POST",
                        url: "https://transition-pacte-energie.fr/contactform/contactForm.php",
                        data: str,
                        success: function (msg) {
                            gtag_report_conversion('https://transition-pacte-energie.fr/')
                        },
                        error: function (msg, err) {
                            gtag_report_conversion('https://transition-pacte-energie.fr/')
                        }
                    });
                });
            }
        });
    });

})(jQuery);