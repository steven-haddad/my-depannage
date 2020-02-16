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
<div id="_desktop_cart">
  <div class="blockcart cart-preview js-sidebar-cart-trigger {if $cart.products_count > 0}active{else}inactive{/if}" data-refresh-url="{$refresh_url}">
    <div class="header">
        <a class="blockcart-link" rel="nofollow" href="{$cart_url}">
            <svg 
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            width="14px" height="16px">
           <path fill-rule="evenodd"  fill="rgb(112, 112, 112)"
            d="M12.645,16.000 C12.645,16.000 12.645,16.000 12.644,16.000 L0.792,16.000 C0.634,16.000 0.483,15.932 0.375,15.813 C0.267,15.693 0.210,15.532 0.219,15.367 L0.984,4.023 C1.002,3.706 1.253,3.459 1.557,3.459 L11.880,3.459 C12.184,3.459 12.435,3.706 12.452,4.023 L13.215,15.336 C13.218,15.357 13.219,15.380 13.219,15.402 C13.219,15.732 12.962,16.000 12.645,16.000 ZM5.590,4.930 C5.590,4.511 5.265,4.172 4.864,4.172 C4.463,4.172 4.138,4.511 4.138,4.930 L4.138,5.361 C4.138,5.779 4.463,6.118 4.864,6.118 C5.265,6.118 5.590,5.779 5.590,5.361 L5.590,4.930 ZM9.299,4.930 C9.299,4.511 8.974,4.172 8.573,4.172 C8.172,4.172 7.847,4.511 7.847,4.930 L7.847,5.361 C7.847,5.779 8.172,6.118 8.573,6.118 C8.974,6.118 9.299,5.779 9.299,5.361 L9.299,4.930 ZM6.719,1.197 C5.833,1.197 5.113,1.948 5.113,2.872 L3.966,2.872 C3.966,1.288 5.201,0.000 6.719,0.000 C8.237,0.000 9.472,1.288 9.472,2.872 L8.324,2.872 C8.324,1.948 7.604,1.197 6.719,1.197 Z"/>
           </svg>

          <span>{l s='Cart' d='Shop.Theme.Checkout'}</span>
          <span class="cart-products-count">({$cart.products_count})</span>
        </a>
    </div>
    <div class="cart-dropdown js-cart-source hidden-xs-up">
      <div class="cart-dropdown-wrapper">
        <div class="cart-title">
          <h4 class="text-center">{l s='Shopping Cart' d='Shop.Theme.Checkout'}</h4>
        </div>
        {if $cart.products}
          <ul class="cart-items">
            {foreach from=$cart.products item=product}
              <li class="cart-product-line">{include 'module:ps_shoppingcart/ps_shoppingcart-product-line.tpl' product=$product}</li>
            {/foreach}
          </ul>
          <div class="cart-bottom">
            <div class="cart-subtotals">
              {foreach from=$cart.subtotals item="subtotal"}
                {if $subtotal}
                <div class="total-line {$subtotal.type}">
                  <span class="label">{$subtotal.label}</span>
                  <span class="value price">{$subtotal.value}</span>
                </div>
                {/if}
              {/foreach}
            </div>
            <hr>
            <div class="cart-total total-line">
              <span class="label">{$cart.totals.total.label}</span>
              <span class="value price price-total">{$cart.totals.total.value}</span>
            </div>
            <div class="cart-action">
              <div class="text-center">
                <a href="{$cart_url}" class="btn btn-primary">{l s='Proceed to checkout' d='Shop.Theme.Actions'}<i class="caret-right"></i></a>
              </div>
            </div>
          </div>
        {else}
          <div class="no-items">
            {l s='There are no more items in your cart' d='Shop.Theme.Checkout'}
          </div>
        {/if}
      </div>
    </div>

  </div>
</div>
