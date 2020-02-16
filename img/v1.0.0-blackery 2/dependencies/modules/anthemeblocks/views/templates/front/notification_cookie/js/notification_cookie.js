$(document).ready(function(){

    //$.cookie('an_notification', '', { expires: -1 });
    if ($.cookie('an_notification')!='accepted') {
        $('.notification_cookie').show();
    }
    $('.notification_cookie-accept').on('click', function () {
        $.cookie('an_notification', 'accepted', {
            expires: 1
        });
        $('.notification_cookie').hide();

    });
});