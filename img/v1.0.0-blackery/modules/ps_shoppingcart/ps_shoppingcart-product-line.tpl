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

   <span class="product-image">
      <img src="{$product.cover.bySize.cart_default.url}" alt="{$product.name}" class="img-fluid">
  </span>
  <div class="product-infos">
      <a class="product-name" href="{$product.url}">{$product.name}</a>
      {foreach from=$product.attributes key="attribute" item="value"}
      <div class="product-line-info">
        <span class="label">{$attribute}:</span>
        <span class="value">{$value}</span>
    </div>
    {/foreach}
    <span class="product-price">{$product.price}</span>
    <span class="product-quantity">x {$product.quantity}</span>
</div>
<div class="product-remove">
    <a
    class                       = "remove-from-cart"s
    rel                         = "nofollow"
    href                        = "{$product.remove_from_cart_url}"
    data-link-action            = "delete-from-cart"
    title                       = "{l s='remove from cart' d='Shop.Theme.Actions'}"
    > 
    {if !isset($product.is_gift) || !$product.is_gift}
    <i class="material-icons">&#xE5CD;</i>
    {/if}
</a>
</div>

{if $product.customizations|count}{/if}