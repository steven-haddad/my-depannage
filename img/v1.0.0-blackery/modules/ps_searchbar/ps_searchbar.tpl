{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
<!-- Block search module TOP -->
<div class="search-block col-lg-2 col-md-2 col-xs-12">
	<div class="search-button">
		<span>{l s='Search' d='Shop.Theme.Catalog'}</span>
		<svg 
		xmlns="http://www.w3.org/2000/svg"
		xmlns:xlink="http://www.w3.org/1999/xlink"
		width="16px" height="16px">
		<path fill-rule="evenodd"  fill="rgb(7, 7, 7)"
		d="M15.779,14.840 L11.939,11.000 C12.891,9.839 13.464,8.353 13.464,6.732 C13.464,3.016 10.449,0.000 6.732,0.000 C3.012,0.000 0.000,3.016 0.000,6.732 C0.000,10.449 3.012,13.464 6.732,13.464 C8.353,13.464 9.836,12.894 10.996,11.942 L14.837,15.779 C15.098,16.040 15.518,16.040 15.779,15.779 C16.040,15.521 16.040,15.098 15.779,14.840 ZM6.732,12.124 C3.756,12.124 1.337,9.706 1.337,6.732 C1.337,3.759 3.756,1.337 6.732,1.337 C9.705,1.337 12.128,3.759 12.128,6.732 C12.128,9.706 9.705,12.124 6.732,12.124 Z"/>
		</svg>
	</div>
	<div id="search_widget" class="search-widget" data-search-controller-url="{$search_controller_url}">
		<div class="container">
			<div class="search-head">
				<span>{l s='What are you looking for?' d='Shop.Theme.Catalog'}</span>
				<div class="search-btn-close"><i class="material-icons">close</i></div>
			</div>
			<form method="get" action="{$search_controller_url}">
				<input type="hidden" name="controller" value="search">
				<input type="text" name="s" value="{$search_string}" placeholder="{l s='Search' d='Shop.Theme.Catalog'}" aria-label="{l s='Search' d='Shop.Theme.Catalog'}">
				<button type="submit">
					<svg 
					xmlns="http://www.w3.org/2000/svg"
					xmlns:xlink="http://www.w3.org/1999/xlink"
					width="21px" height="21px">
					<path fill-rule="evenodd"  fill="rgb(112, 112, 112)"
					d="M19.762,18.587 L14.952,13.777 C16.145,12.323 16.863,10.461 16.863,8.432 C16.863,3.777 13.086,0.000 8.432,0.000 C3.773,0.000 0.000,3.777 0.000,8.432 C0.000,13.087 3.773,16.863 8.432,16.863 C10.461,16.863 12.319,16.149 13.772,14.957 L18.582,19.763 C18.909,20.089 19.436,20.089 19.762,19.763 C20.089,19.440 20.089,18.909 19.762,18.587 ZM8.432,15.185 C4.704,15.185 1.674,12.155 1.674,8.432 C1.674,4.708 4.704,1.674 8.432,1.674 C12.156,1.674 15.189,4.708 15.189,8.432 C15.189,12.155 12.156,15.185 8.432,15.185 Z"/>
					</svg>
					<span class="hidden-xl-down">{l s='Search' d='Shop.Theme.Catalog'}</span>
				</button>
				
			</form>
		</div>
	</div>
</div>
<!-- /Block search module TOP -->
