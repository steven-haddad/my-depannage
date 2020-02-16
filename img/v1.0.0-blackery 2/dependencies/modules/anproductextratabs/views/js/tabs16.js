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
                    $('.page-product-box').hide();
                    var length = $('.page-product-box').length;
                    var html = '<ul class="nav nav-tabs" id="tabs" role="tablist">';
                    for (var i = 0; i < length; i++) {
                        html += '<li class="nav-item">';
                        html += '<a class="nav-link"';
                        html += ' id="nav' + i + '" data-toggle="tab" href="#tab' + i + '" role="tab" aria-controls="tab' + i + '" aria-selected="true">' +
                            $('.page-product-box').eq(i).find('.page-product-heading').text() + '</a></li>'
                        $('.page-product-box').eq(i).find('.page-product-heading').remove();
                    }
                    html += '</ul>';

                    html += '<div class="tab-content" id="tabsContent">';
                    for (var i = 0; i < length; i++) {
                        html += '<div class="tab-pane fade" id="tab' +i + '" role="tabpanel" aria-labelledby="nav' + i + '">' +
                             $('.page-product-box').eq(i).html() +
                            '</div>'
                    }
                    html += '</div>';
                    $('.page-product-box').parent().append(html);
                    $('.page-product-box').remove();

                    $('.nav-link').click(function () {
                        $('.nav-link').css('background-color', CONFIG_BACK_COLOR);
                        $('.nav-link').css('color', CONFIG_FONT_COLOR);
                        $(this).css('background-color', CONFIG_SELECTED_BACK_COLOR);
                        $(this).css('color', CONFIG_SELECTED_FONT_COLOR);
                    });
                    $('#nav0').click();
                    break;

                case 'blocks':
                    $('.page-product-box').hide();
                    var length = $('.page-product-box').length;
                    html = '';
                    for (var i = 0; i < length; i++) {
                        html +='<div class="card">\n' +
                        '  <div class="card-header">\n';
                        html += $('.page-product-box').eq(i).find('.page-product-heading').text();
                        $('.page-product-box').eq(i).find('.page-product-heading').remove();
                        html +='  </div>\n' +
                        '  <div class="card-body">\n' +
                            $('.page-product-box').eq(i).html() +
                        '  </div>\n' +
                        '</div>'
                    }
                    $('.page-product-box').parent().append(html);
                    $('.page-product-box').remove();
                    $('.card-header').css('background-color', CONFIG_BACK_COLOR);
                    $('.card-header').css('color', CONFIG_FONT_COLOR );
                    break;

                case 'accordion':
                    $('.page-product-box').hide();
                    var length = $('.page-product-box').length;
                    var collapsed = '';
                    html = '<div id="accordion" class="accordion16">';
                    for (var i = 0; i < length; i++) {
                        if (i != 0) {
                            collapsed = 'collapsed';
                        }
                        html += '<div class="card">\n' +
                            '  <div class="card-header" id="heading' + i + '" >\n' +
                            '  <button class="btn btn-link accordion-toggle  ' + collapsed + '" data-toggle="collapse" data-target="#collapse' + i + '" aria-expanded="false" aria-controls="collapse' + i + '">\n' +
                            $('.page-product-box').eq(i).find('.page-product-heading').text();
                            $('.page-product-box').eq(i).find('.page-product-heading').remove();
                            html += '  </button>\n' +
                            '  </div>\n' +
                            '   <div id="collapse' + i + '" class="collapse" aria-expanded="" aria-labelledby="heading' + i + '" data-parent="#accordion">\n' +
                            '  <div class="card-body">\n'
                            + $('.page-product-box').eq(i).html() +
                            '  </div>\n' +
                            '  </div>\n' +
                            '</div>';
                    }
                    html += '</div>';

                    $('.page-product-box').parent().append(html);
                    $('.page-product-box').remove();
                    $('#accordion').collapse('show');
                    $('.card-header').css('background-color', CONFIG_BACK_COLOR);
                    $('.card-header button').css('color', CONFIG_FONT_COLOR );
                    $('.tabs').remove();
                    $('#accordion .card-header .btn').click(function(){
                        if($(this).hasClass('active')) {
                            $(this).removeClass('active');
                            $(this).parent().css('background-color', CONFIG_BACK_COLOR);
                            $(this).css('color', CONFIG_FONT_COLOR);
                        } else {
                            $(this).addClass('active');
                            $(this).parent().css('background-color', CONFIG_SELECTED_BACK_COLOR);
                            $(this).css('color', CONFIG_SELECTED_FONT_COLOR);
                        }
                    });
                    $('#heading0 .btn').click();

                    break;
            }
        }

    });
})(jQuery);