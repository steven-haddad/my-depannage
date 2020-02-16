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
			
	{if !$configuration.is_catalog AND $config.display_add_to_cart=='1'}
	<div class="an_productattributes-qty-add clearfix">
		
		{if $config.display_quantity=='1'}
		<div class="an_productattributes-qty-container">
		  <input type="number" name="qty" value="{$minimal_quantity|escape:'htmlall':'UTF-8'}" class="input-group form-control an_productattributes-qty" min="{$minimal_quantity|escape:'htmlall':'UTF-8'}" aria-label="Quantity" style="display: block;">
		</div>
		{/if}
		
		<div class="an_productattributes-add">
		  <button class="btn btn-primary js-an_productattributes-add-to-cart" data-button-action="add-to-cart" type="submit" {if $availableForOrder !='1'} disabled="disabled"{/if}>
			<i class="material-icons shopping-cart"></i>
			{l s='Add to cart' mod='an_productattributes'} 
		  </button>
		</div>
	</div>
	{/if}
</form>
</div>