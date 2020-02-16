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
    jQuery(document).ready(function () {
        jQuery('body').on('click', '.an_add_to_cart', function () {
            var $link = $(event.target),
                $cell = $link.closest('td'),
                data = {};
            $cell.find('[data-role]').each(function () {
                var $input = $(this),
                    role = $input.data('role'),
                    val = $input.val();
                data[role] = val;
            });

            if (data['id_product'] === undefined) {
                return;
            }

            if (data['id_product_attribute'] === undefined) {
                return;
            }
            data['qty'] = $cell.closest('tr').find('.an_input_q').val();
            if (data['qty'] === undefined || isNaN(data['qty']) || data['qty'] < 1) {
                data['qty'] = 1;
                $cell.find('[data-role="qty"]').val(1);
            }
            var handler = jQuery('#anproductextratabs_data').attr('data-ajax-action-url');
            data['add'] = 1;
            data['controller'] = 'cart';
            data['ajax'] = true;
            data['action'] = 'update';
            data['token'] = jQuery('.list_token').val();
            if (window.prestashop !== undefined) {
                $.post(handler, data, null, 'json')
                    .then(function (response) {
                        if ((!response.success && response.hasError) || (!response.hasError && !response.success)) {
                            return;
                        }
                        window.prestashop.emit('updateCart', {
                            reason: {
                                idProduct: data['id_product'],
                                idProductAttribute: data['id_product_attribute'],
                                linkAction: 'add-to-cart'
                            }
                        });

                    }).fail(function (response) {
                        window.prestashop.emit('handleError', {
                            eventType: 'addProductToCart',
                            resp: response
                        });
                    });
            } else {
                window.ajaxCart.add(data['id_product'], data['id_product_attribute'], true, null, data['qty'], null)
            }
        });
    });
