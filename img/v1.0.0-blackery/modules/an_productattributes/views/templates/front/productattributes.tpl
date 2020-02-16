{**
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
*}

<div class="an_productattributes">
<form method="post" class="an_productattributesForm" action="{$cart|escape:'htmlall':'UTF-8'}">
<input name="token" value="{$token|escape:'htmlall':'UTF-8'}" type="hidden">
<input name="id_product" value="{$productId|escape:'htmlall':'UTF-8'}" type="hidden">
{*<input name="id_customization" value="0" placeholder="" type="hidden"> *}
{if $config.display_quantity!='1'}
<input name="qty" type="hidden" value="{$minimal_quantity|escape:'htmlall':'UTF-8'}" min="{$minimal_quantity|escape:'htmlall':'UTF-8'}">
{/if}

	
	{if $config.type_view=='standart'}
	<div class="js-an_productattributes-standart">
		{include file='./product-variants.tpl'}
	</div>
	{/if}
	{if $config.type_view=='select' AND isset($productData) AND count($productData)>0}
	<div class="an_productattributes-select js-an_productattributes-select">
		{include file='./product-select.tpl'}
	</div>
	{/if}
			
	{if $config.display_add_to_cart=='1'}
	<div class="an_productattributes-qty-add clearfix">
		
		{if $config.display_quantity=='1'}
		<div class="an_productattributes-qty-container">
			<div class="quantity-arrow-minus"><span class="quantity-icon-minus"></span></div>	
			<input type="number" name="qty" value="{$minimal_quantity|escape:'htmlall':'UTF-8'}" class="input-group form-control an_productattributes-qty" min="{$minimal_quantity|escape:'htmlall':'UTF-8'}" aria-label="Quantity" style="display: block;">
			<div class="quantity-arrow-plus"><span class="quantity-icon-plus"></span></div>
		</div>
		{/if}
		
		<div class="an_productattributes-add">
		  <button class="btn an_productattributes-add-to-cart-btn js-an_productattributes-add-to-cart" data-button-action="add-to-cart" type="submit" {if $availableForOrder !='1'} disabled="disabled"{/if}>
			<svg 
			xmlns="http://www.w3.org/2000/svg"
			xmlns:xlink="http://www.w3.org/1999/xlink"
			width="13px" height="17px">
			<path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
			d="M12.440,16.946 C12.439,16.946 12.439,16.946 12.439,16.946 L0.571,16.946 C0.413,16.946 0.262,16.879 0.154,16.758 C0.045,16.638 -0.011,16.477 -0.002,16.312 L0.764,4.929 C0.781,4.612 1.033,4.363 1.337,4.363 L11.673,4.363 C11.978,4.363 12.229,4.612 12.247,4.929 L13.011,16.280 C13.013,16.302 13.014,16.324 13.014,16.347 C13.014,16.678 12.757,16.946 12.440,16.946 ZM5.375,5.839 C5.375,5.420 5.050,5.079 4.648,5.079 C4.247,5.079 3.922,5.420 3.922,5.839 L3.922,6.272 C3.922,6.691 4.247,7.032 4.648,7.032 C5.050,7.032 5.375,6.691 5.375,6.272 L5.375,5.839 ZM9.090,5.839 C9.090,5.420 8.764,5.079 8.363,5.079 C7.961,5.079 7.636,5.420 7.636,5.839 L7.636,6.272 C7.636,6.691 7.961,7.032 8.363,7.032 C8.764,7.032 9.090,6.691 9.090,6.272 L9.090,5.839 ZM6.506,2.093 C5.619,2.093 4.898,2.847 4.898,3.774 L3.749,3.774 C3.749,2.186 4.986,0.893 6.506,0.893 C8.025,0.893 9.262,2.186 9.262,3.774 L8.113,3.774 C8.113,2.847 7.392,2.093 6.506,2.093 Z"/>
			</svg>
			{l s='Add to cart' mod='an_productattributes'} 
		  </button>
		</div>
	</div>
	{/if}
</form>
</div>