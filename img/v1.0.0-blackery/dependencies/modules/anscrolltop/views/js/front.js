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
	var start_opacity = jQuery("#scrolltopbtn").css("opacity");

	if (jQuery(window).scrollTop() < 200) jQuery("#scrolltopbtn").css({opacity: 0});
	
	jQuery("#scrolltopbtn").css({display: 'block'});

	jQuery(window).scroll(function() {
	    if (jQuery(window).scrollTop() > 200) jQuery("#scrolltopbtn").css({opacity: start_opacity});
	    else jQuery("#scrolltopbtn").css({opacity: 0});
	});

	jQuery("#scrolltopbtn")
		.on("click", function () {
			jQuery("html, body").animate({ scrollTop: 0 }, "slow");
			return false;
		})
		.on("mouseenter", function() {
			jQuery("#scrolltopbtn").css({opacity: 1});
		})
		.on("mouseleave", function() {
		    if (jQuery(window).scrollTop() > 200) jQuery("#scrolltopbtn").css({opacity: start_opacity});
		    else jQuery("#scrolltopbtn").css({opacity: 0});
		});
});