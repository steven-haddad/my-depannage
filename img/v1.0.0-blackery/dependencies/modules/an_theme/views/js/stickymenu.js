/**
* 2007-2017 PrestaShop
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
*  @author    Apply Novation <applynovation@gmail.com>
*  @copyright 2016-2017 Apply Novation
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

/* 

 $(document).ready(function() {
 
	$(window).on('load resize scroll', function() {
		
		var headerHeight = $('.header-top').outerHeight();
		var scrollHeight = headerHeight - $('#_desktop_top_menu').outerHeight();
		
		if ($(window).width() >= 1024 && $(window).scrollTop() > scrollHeight) {
			$('#_desktop_top_menu').addClass('fixed-menu');
			$('#top-menu').addClass('container');
			$('.header-top').css('height', headerHeight + 'px');
		} else {
			$('#_desktop_top_menu').removeClass('fixed-menu');
			$('#top-menu').removeClass('container');
			$('.header-top').css('height', 'auto');
		}
	}); 
}); */


 $(document).ready(function() {
 	if($('div').is(".header-top.tablet-h")){
	 	var scrollHeight = $('#amegamenu').offset().top + $('#amegamenu').height();

		$(window).on('load resize scroll', function() {
			var headerHeight = $('.header-top').outerHeight();
			if ($(window).width() >= 1024 && $(window).scrollTop() > scrollHeight) {
				$('.header-top.tablet-h').addClass('fixed-menu');
				$('#top-menu').addClass('container');
			} else {
				$('.header-top.tablet-h').removeClass('fixed-menu');
				$('#top-menu').removeClass('container');
			}
		}); 
	}
}); 


//  $(document).ready(function() {
 
//   $(window).scroll(function() {
//     if ($(window).scrollTop() > 160) {
//         $('#_desktop_top_menu').addClass('fixed-menu');
// 		$('#top-menu').addClass('container');
//     }
//     else{
//         $('#_desktop_top_menu').removeClass('fixed-menu');
// 		$('#top-menu').removeClass('container');
//     }
//   }); 

// }); 

