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

	$(document).on('change','.an_productattributes [data-product-attribute], .an_productattributes-select select', function() {
		
		var self = this;
		
		getData($(this).closest('.an_productattributesForm').serialize(), function(data){ 
			isAvailableForOrder($(self).closest('.an_productattributesForm').find('.js-an_productattributes-add-to-cart'), data);
			setMinQty($(self).closest('.an_productattributesForm').find('.an_productattributes-qty'), data);
			setPrices($(self).closest(an_productattributes.config.product_price_and_shipping), $(self).closest(an_productattributes.config.product_price_and_shipping).find(an_productattributes.config.price), data);
			setImages($(self).closest(an_productattributes.config.thumbnail_container).find('img'), data);
			setVariants($(self).closest('.js-an_productattributes-standart'), data);
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

function setVariants(standart, data){
	if (data.variants){
		standart.html(data.variants);
	}
}
	
function setMinQty(qty, data){
	if (data.minimal_quantity){
		qty.attr('min', data.minimal_quantity).attr('value', data.minimal_quantity);
	}
}
	
function setPrices(priceContainer, price, data){
	priceContainer.find(an_productattributes.config.regular_price).remove();
	price.html(data.prices.price);
	if (data.prices.regular_price){
		$('<span class="regular-price">'+data.prices.regular_price+'</span>').insertAfter(price);
	}
}	

function setImages(img, data){
	if (data.images){
		if ($(img[0]).parents().hasClass('js-img-view-type')) {

			if ($(img[0]).parents().hasClass('type-standart')) {
				img.attr('src', data.images.home[data.cover_id]);
			}

			if ($(img[0]).parents().hasClass('type-hover')) {
				let keysArr = [],
				img_item = img[0],
				img_hover_container = img.parents('.product-thumbnail'),
				img_cover;
				for (var key in data.images.home) {
					keysArr.push(key);
				}
				
				img_hover_container.empty();
				$.each(keysArr, function(index, value) {
					if(index == 0) {
						img_hover_container.append(img_item);
					} else {
						img_hover_container.find('img:first').removeClass('cover').clone().appendTo(img_hover_container);
					}
					img_hover_container.find('img').eq(index).attr('src', data.images.home[value]);
					if(value == data.cover_id) {
						img_cover = img_hover_container.find('img').eq(index);
					}
					if (keysArr.length < 2) {
						img_hover_container.find('img').eq(index).addClass('only_one_item');
		
					} else {
						img_hover_container.find('img').eq(index).removeClass('only_one_item');
					}
				}); 
				img_cover.addClass('cover');
			}

			if ($(img[0]).parents().hasClass('type-slider')) {
				slider_delete($(img[0]).parents('.slider_product-wrapper'));
				let keysArr = [],
				img_item = $(img[0]).parents('.slider-product-item').removeClass('slick-slide slick-cloned'),
				img_hover_container = img.parents('.slider_product-wrapper');
				for (var key in data.images.home) {
					keysArr.push(key);
				}
				img_hover_container.empty();
				$.each(keysArr, function(index, value) {
					if(index == 0) {
						img_hover_container.append(img_item);
					} else {
						img_hover_container.find('.slider-product-item:first').clone().appendTo(img_hover_container);
					}
					img_hover_container.find('.slider-product-item').eq(index).find('img').attr('src', data.images.home[value]);
				}); 
				slider_init_one($(img[0]).parents('.an_slick-slider'));
			}

			if ($(img[0]).parents().hasClass('type-hover-slider')) {
				let keysArr = [],
				img_item = $(img[0]).parents('li:first'),
				img_hover_container = img.parents('.product-thumbnail ul'),
				img_cover,
				only_one_img;
				for (var key in data.images.home) {
					keysArr.push(key);
				}
				img_hover_container.empty();
				$.each(keysArr, function(index, value) {
					if(index == 0) {
						img_hover_container.append(img_item);
					} else {
						img_hover_container.find('li:first').removeClass('cover-item').addClass('no-cover-item').clone().appendTo(img_hover_container);
					}
					img_hover_container.find('img').eq(index).attr('src', data.images.home[value]);
					if(value == data.cover_id) {
						img_cover = img_hover_container.find('img').eq(index);
					}
					if (keysArr.length < 2) {
						only_one_img = true;	
					} else {
						only_one_img = false;
					}
				}); 
				if (only_one_img) {
					img_hover_container.addClass('only_one_item');
				} else {
					img_hover_container.removeClass('only_one_item');
				}
				img_cover.parents('li:first').removeClass('no-cover-item').addClass('cover-item');
			}
		
		} else {
			img.attr('src', data.images.home[data.cover_id]);
		}
		
	}
}

})(jQuery, window);

$

$(document).ready(function () {
	$(document).on('click', '.an_productattributes-dropdown-toggler', function(){
		$(this).parents('.an_productattributes-dropdown').toggleClass('open');
	});
	$(document).on('click', '.an_productattributes-dropdown-menu', function(){
		$(this).parents('.an_productattributes-dropdown').toggleClass('open');
	});
	$(document).on('click', '.js-an_productattributes-product-selectbox li', function(){
		$(this).parents('.js-an_productattributes-product-selectbox').find('.js-an_productattributes-filter-option').text($(this).children('.js-an_productattributes-text').text());
		$(this).parents('.js-an_productattributes-select').find('option').removeAttr('selected');
		$(this).parents('.js-an_productattributes-select').find('option').eq($(this).index()).attr('selected','');
	});

	

	//selectFilling();
	productQuantityChange();
	$(document).on('mouseleave', an_productattributes.config.product_miniature, function() {
		$('.an_productattributes-dropdown').removeClass('open');
	});
	
});
$( document ).ajaxStop(function() {
	selectFilling();
});

function selectFilling(){
	$('.js-an_productattributes-product-selectbox li.selected').each(function() {
		let item = $(this).parents('.js-an_productattributes-product-selectbox').find('.js-an_productattributes-filter-option');
		if (!item.hasClass('selected')) {
			item.text($(this).children('.js-an_productattributes-text').text());
			item.addClass('selected');
		}
	});
}

function productQuantityChange() {
	$( 'body' ).on( 'click', '.quantity-arrow-minus, .quantity-arrow-plus', function ( event ) {
		event.preventDefault();
		var input = $(this).siblings('.an_productattributes-qty');
		if ( input.val() > 1 ) {
			if ( $(this).hasClass( 'quantity-arrow-minus' )  ) {
				input.val( +input.val() - 1 );
			}
		}
		if ( $(this).hasClass( 'quantity-arrow-plus' ) ) {
			input.val( +input.val() + 1 );
		}
	});
}