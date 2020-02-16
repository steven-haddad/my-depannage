/**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    Anvanto (anvantoco@gmail.com)
 *  @copyright 2007-2018  http://anvanto.com
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

(function ($) {
    $(document).ready(function () {
        if (tab_type) {
            switch (tab_type) {
                case 'tabs':
                    $('.tabs .nav-link').click(function () {
                        $('.tabs .nav-link').css('background-color', CONFIG_BACK_COLOR + '!important');
                        $('.tabs .nav-link').css('color', CONFIG_FONT_COLOR + '!important');
                        $(this).css('background-color', CONFIG_SELECTED_BACK_COLOR + '!important');
                        $(this).css('color', CONFIG_SELECTED_FONT_COLOR + '!important');
                    });
                    $('.nav-link').eq(0).click();
                    break;

                case 'blocks':
                    $('.tabs').hide();
                    var length = $('.tabs .nav-tabs .nav-item').length;
                    for (var i = 0; i < length; i++) {
                        $('.tabs').parent().append(
                            '<div class="card">\n' +
                            '  <div class="card-header">\n' +
                            $('.tabs .nav-tabs .nav-item').eq(i).find('.nav-link').text() + '\n' +
                            '  </div>\n' +
                            '  <div class="card-body">\n' +
                                $('.tabs .tab-pane').eq(i).html() +
                            '  </div>\n' +
                            '</div>'
                        );
                    }
                    $('.card-header').css('background-color', CONFIG_BACK_COLOR + '!important');
                    $('.card-header').css('color', CONFIG_FONT_COLOR + '!important');
                    $('.tabs').remove();
                    break;

                case 'accordion':
                    $('.tabs').hide();
                    var length = $('.tabs .nav-tabs .nav-item').length;
                    var html  = '<div id="accordion">';
                    var collapsed = 'in';
                    var col = 'collapsed';
                    var expanded  = 'true';
                    for (var i = 0; i < length; i++) {
                        if (i != 0 ) {
                            collapsed = '';
                            col = '';
                            expanded = 'false';
                        }
                        html += '<div class="card">\n' +
                          '  <div class="card-header">\n' +
                          '  <button class="btn btn-link accordion-toggle ' + col + '" data-toggle="collapse" data-target="#collapse' + i + '" aria-expanded="' + expanded + '" aria-controls="collapse' + i + '">\n' +
                            '<i class="material-icons expand_more">expand_more</i>' +
                            $('.tabs .nav-tabs .nav-item').eq(i).find('.nav-link').text() + '\n' +
                          '  </button>\n' +
                          '  </div>\n' +
                          '   <div id="collapse' + i + '" class="collapse show ' + collapsed + '" aria-expanded="' + expanded + '" aria-labelledby="heading' + i + '" data-parent="#accordion">\n' +
                            '  <div class="card-body">\n'
                                + $('.tabs .tab-pane').eq(i).html() +
                            '  </div>\n' +
                          '  </div>\n' +
                          '</div>';
                    }
                    html += '</div>';
                    $('.tabs').parent().append(html);
                    $('#accordion').collapse('show');
                    $('.card-header').css('background-color', CONFIG_BACK_COLOR + '!important');
                    $('.card-header button').css('color', CONFIG_FONT_COLOR + '!important');
                    $('#accordion .card-header').eq(0).find('.btn').addClass('active');
                    $('#accordion .card-header').eq(0).find('.expand_more').text('expand_less');
                    $('#accordion .card-header').eq(0).css('background-color', CONFIG_SELECTED_BACK_COLOR + '!important');
                    $('#accordion .card-header button').eq(0).css('color', CONFIG_SELECTED_FONT_COLOR + '!important');
                    $('.tabs').remove();
                    $('#accordion .card-header .btn').click(function(){
                        if($(this).hasClass('active')) {
                            $(this).removeClass('active');
                            $('.expand_more',this).text('expand_more');
                            $('.card-header').css('background-color', CONFIG_BACK_COLOR + '!important');
                            $('.card-header button').css('color', CONFIG_FONT_COLOR + '!important');
                        } else {
                            $('#accordion .card-header .btn').removeClass('active');
                            $('#accordion .card-header .btn .expand_more').text('expand_more');
                            $('.expand_more',this).text('expand_less');
                            $(this).addClass('active');
                            $('.card-header').css('background-color', CONFIG_BACK_COLOR + '!important');
                            $('.card-header button').css('color', CONFIG_FONT_COLOR + '!important');
                            $(this).parent().css('background-color', CONFIG_SELECTED_BACK_COLOR + '!important');
                            $(this).css('color', CONFIG_SELECTED_FONT_COLOR + '!important');
                        }
                    });

                    break;
            }
        }

    });
})(jQuery);
