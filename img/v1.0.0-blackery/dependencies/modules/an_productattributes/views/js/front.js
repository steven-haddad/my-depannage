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
(function ($, window, undefined) {
	'use strict';
	
	resizeProduct();
	
	$(document).ajaxSuccess(function() {
		resizeProduct();
	});
	
	function resizeProduct(){
		$('.js-product-miniature').each( function(){
			var marginBottom = $(this).find('.an_productattributes').height()+40+'px'
			$(this).find('.thumbnail-container').css('margin-bottom', marginBottom);		
		});
	}

	$(document).on('change','.an_productattributes [data-product-attribute], .an_productattributes-select select', function() {
		
		var self = this;
		
		getData($(this).closest('.an_productattributesForm').serialize(), function(data){ 			
			isAvailableForOrder($(self).closest('.an_productattributesForm').find('.js-an_productattributes-add-to-cart'), data);
			setMinQty($(self).closest('.an_productattributesForm').find('.an_productattributes-qty'), data);			
			setPrices($(self).closest(an_productattributes.config.product_price_and_shipping), $(self).closest(an_productattributes.config.product_price_and_shipping).find(an_productattributes.config.price), data);
 			setImages($(self).closest(an_productattributes.config.thumbnail_container).find('img'), data);
			setVariants(self, data);
		});
	});

	$(document).on('click','.an_productattributes-dropdown-menu li', function() {
		
		var self = this;
				
		if (attributeGroups){
			generateInputs($(this).closest('.an_productattributesForm'), parseInt($(this).closest(an_productattributes.config.product_miniature).attr('data-id-product')), $(this).data('value'));
		}		

		getData($(this).closest('.an_productattributesForm').serialize(), function(data){ 
			isAvailableForOrder($(self).closest('.an_productattributesForm').find('.js-an_productattributes-add-to-cart'), data);
			setMinQty($(self).closest('.an_productattributesForm').find('.an_productattributes-qty'), data);
			setPrices($(self).closest(an_productattributes.config.product_price_and_shipping), $(self).closest(an_productattributes.config.product_price_and_shipping).find(an_productattributes.config.price), data);
 			setImages($(self).closest(an_productattributes.config.thumbnail_container).find('img'), data);
		});
	}); 

function getData(dataUrl, callback){	
	$.ajax({
		type: "POST",
		url: an_productattributes.controller,
		async: false,
		data: dataUrl + '&action=getProductAttributes',
		dataType: 'json',
	}).done(function(data){
		callback(data);
	});
}

function generateInputs(an_productattributesForm, productId, attrebuteID){
	$('.an_productattributes-hiddeninputs').remove();
	
	$.each(attributeGroups[productId][attrebuteID], function(index, value) {
		an_productattributesForm.append("<input name='group[" + value['id_attribute_group'] + "]' value='" + value['id_attribute'] + "' type='hidden' class='an_productattributes-hiddeninputs' />");
	});
}
	
function isAvailableForOrder(addToCart, data){
	if (data.availableForOrder !== true){
		addToCart.attr('disabled', 'disabled');
	} else {
		addToCart.removeAttr('disabled')
	}
}

function setVariants(self, data){
	if (data.variants){
		$(self).closest('.js-an_productattributes-standart').html(data.variants);
	}
}
	
function setMinQty(qty, data){
	if (data.minimal_quantity){
		qty.attr('min', data.minimal_quantity).attr('value', data.minimal_quantity);
	}
}
	
function setPrices(priceContainer, price, data){
	priceContainer.find(an_productattributes.config.regular_price).remove();
	if (data.prices.regular_price){
		priceContainer.prepend('<span class="regular-price">'+data.prices.regular_price+'</span>');
	}
	
	price.html(data.prices.price);
}	

function setImages(img, data){
	if (data.images){
		img.attr('src', data.images.home[data.cover_id]);
	}
}

})(jQuery, window);

$(document).ready(function () {
	
	$('.an_productattributes-dropdown-toggler').on('click', function() {
		$(this).parents('.an_productattributes-dropdown').toggleClass('open');
	});
	$('.an_productattributes-dropdown-menu').on('click', function() {
		$(this).parents('.an_productattributes-dropdown').toggleClass('open');
	});

	$('.js-an_productattributes-product-selectbox li:first-child').each(function() {
		$(this).parents('.js-an_productattributes-product-selectbox').find('.js-an_productattributes-filter-option').text($(this).children('.js-an_productattributes-text').text());
	});
	$('.js-an_productattributes-product-selectbox li').on('click', function() {
		$(this).parents('.js-an_productattributes-product-selectbox').find('.js-an_productattributes-filter-option').text($(this).children('.js-an_productattributes-text').text());
		$(this).parents('.js-an_productattributes-select').find('option').removeAttr('selected');
		$(this).parents('.js-an_productattributes-select').find('option').eq($(this).index()).attr('selected','');
	});
	
	$(an_productattributes.config.product_miniature).hover(function(){}, function(){
		$('.an_productattributes-dropdown').removeClass('open');
	});
});