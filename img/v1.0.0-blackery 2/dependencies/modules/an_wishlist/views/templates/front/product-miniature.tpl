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

<div class="an_wishlist-mini js-an_wishlist-container">
	<span class="js-an_wishlist-addremove{if $status} an_wishlist-in{/if}" data-url="{$link->getModuleLink('an_wishlist', 'ajax', [], true)|escape:'quotes'}?token={$token|escape:'htmlall':'UTF-8'}&action=addRemove&id_product={$id_product|intval}">
		<i class="material-icons">favorite</i>
	</span>
	{if ($config.display_likes_product_mini)}
	<div class="an_wishlist-mini-count js-an_wishlist-product-count">{$countWishlists|intval}</div>
	{/if}
</div>