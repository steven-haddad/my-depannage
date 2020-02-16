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
<div class="product-add-to-cart">
  {if !$configuration.is_catalog}


    {block name='product_quantity'}
      <div class="product-quantity product-variants-item clearfix">
        <div class="qty">
          <input
            type="text"
            name="qty"
            id="quantity_wanted"
            value="{$product.quantity_wanted}"
            class="input-group"
            min="{$product.minimal_quantity}"
            aria-label="{l s='Quantity' d='Shop.Theme.Actions'}"
          >
        </div>
      </div>

      <div class='quantity_availability'>
        <div class="add">
          <button
            class="btn btn-primary add-to-cart"
            data-button-action="add-to-cart"
            type="submit"
            {if !$product.add_to_cart_url}
              disabled
            {/if}
          >
          <svg 
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          width="14px" height="16px">
         <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
          d="M12.527,16.001 C12.526,16.001 12.526,16.001 12.526,16.001 L0.665,16.001 C0.507,16.001 0.356,15.933 0.247,15.814 C0.139,15.694 0.083,15.533 0.092,15.368 L0.857,4.024 C0.874,3.708 1.126,3.460 1.430,3.460 L11.761,3.460 C12.065,3.460 12.316,3.708 12.334,4.024 L13.097,15.337 C13.100,15.359 13.101,15.380 13.101,15.403 C13.101,15.733 12.844,16.001 12.527,16.001 ZM5.466,4.931 C5.466,4.513 5.141,4.174 4.740,4.174 C4.338,4.174 4.013,4.513 4.013,4.931 L4.013,5.362 C4.013,5.780 4.338,6.120 4.740,6.120 C5.141,6.120 5.466,5.780 5.466,5.362 L5.466,4.931 ZM9.178,4.931 C9.178,4.513 8.853,4.174 8.452,4.174 C8.051,4.174 7.725,4.513 7.725,4.931 L7.725,5.362 C7.725,5.780 8.051,6.120 8.452,6.120 C8.853,6.120 9.178,5.780 9.178,5.362 L9.178,4.931 ZM6.596,1.198 C5.710,1.198 4.989,1.949 4.989,2.873 L3.841,2.873 C3.841,1.290 5.077,0.002 6.596,0.002 C8.115,0.002 9.351,1.290 9.351,2.873 L8.203,2.873 C8.203,1.949 7.482,1.198 6.596,1.198 Z"/>
         </svg>
            {l s='Add to cart' d='Shop.Theme.Actions'}
          </button>
        </div>
      </div>
    {/block}

    {block name='product_availability'}
      <span id="product-availability">
        {if $product.show_availability && $product.availability_message}
          {if $product.availability == 'available'}
            <i class="material-icons rtl-no-flip product-available">&#xE5CA;</i>
          {elseif $product.availability == 'last_remaining_items'}
            <i class="material-icons product-last-items">&#xE002;</i>
          {else}
            <i class="material-icons product-unavailable">&#xE14B;</i>
          {/if}
          {$product.availability_message}
        {/if}
      </span>
    {/block}
    
    {block name='product_minimal_quantity'}
      <p class="product-minimal-quantity">
        {if $product.minimal_quantity > 1}
          {l
          s='The minimum purchase order quantity for the product is %quantity%.'
          d='Shop.Theme.Checkout'
          sprintf=['%quantity%' => $product.minimal_quantity]
          }
        {/if}
      </p>
    {/block}
  {/if}
</div>
{hook h='displayProductAdditionalInfo' product=$product}