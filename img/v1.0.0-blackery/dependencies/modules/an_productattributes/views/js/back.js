/**
* 2019 Anvanto
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
*  @author Anvanto (anvantoco@gmail.com)
*  @copyright  2019 anvanto.com

*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
jQuery(document).ready(function () {
	
	changeTypeView();
	changeAddToCart();
	
	$('input[name=an_pa_display_add_to_cart]').on('click', function(){
		if ($(this).val() == '1'){
			$('input[name=an_pa_display_quantity]').parents('.form-group').show();
		} else {
			$('input[name=an_pa_display_quantity]').parents('.form-group').hide();
		}
	});
	
	$('.an-pa-type-view input').on('click', function(){
		changeTypeView();
	});
	
	function changeAddToCart(){
		if ($('input[name=an_pa_display_add_to_cart]:checked').val() == '1'){
			$('input[name=an_pa_display_quantity]').parents('.form-group').show();
		} else {
			$('input[name=an_pa_display_quantity]').parents('.form-group').hide();
		}
	}
		
	function changeTypeView(){
		if ($('.an-pa-type-view input[name=an_pa_type_view]:checked').val() != 'select'){
			$('.form-group .an-pa-type-select').each(function(){
				$(this).parents('.form-group').hide();
			});
		} else {
			$('.form-group .an-pa-type-select').each(function(){
				$(this).parents('.form-group').show();
			});
		}
	}

});