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
{if count($products)>0 AND $config.display_wishlist_in_cart=='1'}
<div class="an_wishlist-list-cart">
	<h1>{l s='My wishlist' mod='an_wishlist'}</h1>

	<section id="products" class="clearfix"> 
		<div class="products row">
		{foreach from=$products item="product"}
		  {include file='catalog/_partials/miniatures/product.tpl' product=$product}
		{/foreach}
		</div>
	</section>
</div>
{/if}