/**
* 2007-2015 PrestaShop
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
*  @author    Apply Novation (Artem Zwinger) <applynovation@gmail.com>
*  @copyright 2016-2017 Apply Novation
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

jQuery(document).ready(function () {
	var fields = {
		BORDER_WIDTH: 	'BORDER_WIDTH',
		BORDER_RADIUS: 	'BORDER_RADIUS',
		BORDER_COLOR: 	'BORDER_COLOR',
		BUTTON_WIDTH: 	'BUTTON_WIDTH',
		BUTTON_BG: 		'BUTTON_BG',
		BUTTON_ICO: 	'BUTTON_ICO',
		FONT_COLOR: 	'FONT_COLOR',
		FONT_SIZE: 		'FONT_SIZE',
		BUTTON_HEIGHT: 	'BUTTON_HEIGHT',
		OPACITY: 		'OPACITY',
		BUTTON_MARGIN_X:'BUTTON_MARGIN_X',
		BUTTON_MARGIN_Y:'BUTTON_MARGIN_Y',
	};

	var num_validator = [
		[fields.BORDER_WIDTH, 0, 100, "borderWidth"],
		[fields.BORDER_RADIUS, 0, 100, "borderRadius"],
		[fields.BUTTON_WIDTH, 1, 150, "width"],
		[fields.BUTTON_HEIGHT, 1, 150, "height"],
		[fields.BUTTON_HEIGHT, 1, 150, "lineHeight"],
		[fields.OPACITY, 0, 100, "opacity"],
		[fields.FONT_SIZE, 1, 100, "fontSize"],
		[fields.BUTTON_MARGIN_X, 0, 500],
		[fields.BUTTON_MARGIN_Y, 0, 500],
	];

	var configuration = [];
	configuration[fields.BORDER_WIDTH] 		= parseInt(jQuery('#'+fields.BORDER_WIDTH).val()) || 0;
	configuration[fields.BORDER_RADIUS] 	= parseInt(jQuery('#'+fields.BORDER_RADIUS).val()) || 0;
	configuration[fields.BUTTON_WIDTH] 		= parseInt(jQuery('#'+fields.BUTTON_WIDTH).val()) || 0;
	configuration[fields.BUTTON_HEIGHT] 	= parseInt(jQuery('#'+fields.BUTTON_HEIGHT).val()) || 0;
	configuration[fields.OPACITY] 			= parseInt(jQuery('#'+fields.OPACITY).val()) || 0;
	configuration[fields.BUTTON_MARGIN_X] 	= parseInt(jQuery('#'+fields.BUTTON_MARGIN_X).val()) || 0;
	configuration[fields.BUTTON_MARGIN_Y] 	= parseInt(jQuery('#'+fields.BUTTON_MARGIN_Y).val()) || 0;
	configuration[fields.FONT_SIZE] 		= parseInt(jQuery('#'+fields.FONT_SIZE).val()) || 0;

	var scrolltopbtn = jQuery("#scrolltopbtn");
	scrolltopbtn.css('display', 'block');

	for (var i = 0; i < num_validator.length; i++) {
		(function(i) {
			jQuery('#'+num_validator[i][0]).on("keyup", function (event) {
				var value = parseInt(jQuery(this).val()) || 0;
				if (jQuery(this).val() == '') return true;
				return value > num_validator[i][2] || value < num_validator[i][1] || validate(event) ?
					jQuery(this).val(configuration[num_validator[i][0]]) && false :
					configuration_set(num_validator[i][0], value) && (num_validator[i][3] !== undefined ? scrolltopbtn.css(num_validator[i][3], num_validator[i][3] == 'lineHeight' ? value+'px' : value) : true);
			});
		})(i);
	}

	jQuery('#'+fields.BUTTON_ICO).change(function () {
		scrolltopbtn.html("&#x"+jQuery(this).children("option:selected").val()+";");
	});

	setInterval(function() {
		scrolltopbtn.css({
			borderColor: jQuery("input[name='"+fields.BORDER_COLOR+"']").val(),
			backgroundColor: jQuery("input[name='"+fields.BUTTON_BG+"']").val(),
			color: jQuery("input[name='"+fields.FONT_COLOR+"']").val()
		});
	}, 1000);


	var configuration_set = function(field, value) {
		return Boolean(configuration[field] = value);
	};

	var validate = function(event) {
		return event.which != 8 && isNaN(String.fromCharCode(event.which));
	}
});