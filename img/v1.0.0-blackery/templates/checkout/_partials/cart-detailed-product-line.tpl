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

<td class="product-image">
    <a href="{$product.url}" class="cart__image">
         <img src="{$product.cover.bySize.checkout_default.url}" alt="{$product.name|escape:'quotes'}">
    </a>
</td>
<td class="product-title">
    <div class="product-title-wrap">
         <a href="{$product.url}" class="h4">{$product.name}</a>
         <span class="product-title-variant">
             {foreach from=$product.attributes key="attribute" item="value"}
                <span class="value">{$value}</span>

            {/foreach}
         </span>
    </div>
</td>
<td class="product-price text-center product-price-and-shipping">
    <span class="product-price-label">
        <span class="price">{$product.price}</span>
    </span>
</td>
<td class="product-quantity text-center">
     <div class="qty">
        {if isset($product.is_gift) && $product.is_gift}
          <span class="gift-quantity">{$product.quantity}</span>
        {else}
          <input
            class="js-cart-line-product-quantity"
            data-down-url="{$product.down_quantity_url}"
            data-up-url="{$product.up_quantity_url}"
            data-update-url="{$product.update_quantity_url}"
            data-product-id="{$product.id_product}"
            type="text"
            value="{$product.quantity}"
            name="product-quantity-spin"
            min="{$product.minimal_quantity}"
          />
        {/if}
      </div>
</td>
<td class="total-price text-center">
     <div class="price">
        <span class="product-price">

            {if isset($product.is_gift) && $product.is_gift}
              <span class="gift">{l s='Gift' d='Shop.Theme.Checkout'}</span>
            {else}
              {$product.total}
            {/if}

        </span>
      </div>
</td>
<td class="product-control text-right">
     <div class="cart-line-product-actions">
      <a
          class                       = "remove-from-cart"
          rel                         = "nofollow"
          href                        = "{$product.remove_from_cart_url}"
          data-link-action            = "delete-from-cart"
          data-id-product             = "{$product.id_product|escape:'javascript'}"
          data-id-product-attribute   = "{$product.id_product_attribute|escape:'javascript'}"
          data-id-customization   	  = "{$product.id_customization|escape:'javascript'}"
      >
        {if !isset($product.is_gift) || !$product.is_gift}
        <i class="material-icons">close</i>
        {/if}
      </a>

      {block name='hook_cart_extra_product_actions'}
        {hook h='displayCartExtraProductActions' product=$product}
      {/block}

    </div>
</td>


