{*
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
*}
#scrolltopbtn {
	border: {$BORDER_WIDTH|intval}px solid {$BORDER_COLOR|escape:'htmlall':'UTF-8'};
	border-radius: {$BORDER_RADIUS|intval}px;
	position: fixed;
	top: {$TOP|escape:'htmlall':'UTF-8'};
	bottom: {$BOTTOM|escape:'htmlall':'UTF-8'};
	left: {$LEFT|escape:'htmlall':'UTF-8'};
	right: {$RIGHT|escape:'htmlall':'UTF-8'};
	opacity: {$OPACITY|escape:'htmlall':'UTF-8'};
	background-color: {$BUTTON_BG|escape:'htmlall':'UTF-8'};
	width: {$BUTTON_WIDTH|intval}px;
	height: {$BUTTON_HEIGHT|intval}px;
	line-height: {$BUTTON_HEIGHT|intval}px;
	font-size: {$FONT_SIZE|intval}px;
	color: {$FONT_COLOR|escape:'htmlall':'UTF-8'};
	text-align: center;
	font-family: "Ionicons";
	cursor: pointer;
	z-index: 9999;

	display: none;

	-webkit-transition: opacity 0.5s linear;
	-moz-transition: opacity 0.5s linear;
	-o-transition: opacity 0.5s linear;
	transition: opacity 0.5s linear;
}

#scrolltopbtn:hover { opacity: 1 }