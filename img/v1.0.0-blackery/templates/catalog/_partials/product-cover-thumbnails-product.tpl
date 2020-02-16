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
<div class="images-container">
  {block name='product_cover'}
    <div class="product-cover">
      <img class="js-qv-product-cover" src="{$product.cover.bySize.large_default.url}" alt="{$product.cover.legend}" title="{$product.cover.legend}" style="width:100%;" itemprop="image">
      <div class="layer hidden-sm-down" data-toggle="modal" data-target="#product-modal">
          <svg 
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          width="20px" height="21px">
         <path fill-rule="evenodd"  fill="rgb(7, 7, 7)"
          d="M19.304,20.500 L14.652,20.500 C14.267,20.500 13.955,20.188 13.955,19.803 C13.955,19.418 14.267,19.106 14.652,19.106 L17.622,19.106 L12.998,14.482 C12.725,14.210 12.725,13.769 12.998,13.498 C13.270,13.225 13.710,13.225 13.983,13.498 L18.607,18.122 L18.607,15.152 C18.607,14.767 18.919,14.455 19.303,14.455 C19.688,14.455 20.000,14.767 20.000,15.152 L20.000,19.803 C20.000,20.188 19.688,20.500 19.304,20.500 ZM19.304,6.545 C18.919,6.545 18.607,6.233 18.607,5.848 L18.607,2.878 L14.121,7.364 C13.985,7.500 13.807,7.568 13.629,7.568 C13.451,7.568 13.272,7.500 13.136,7.364 C12.864,7.092 12.864,6.651 13.136,6.379 L17.622,1.893 L14.652,1.893 C14.267,1.893 13.955,1.581 13.955,1.197 C13.955,0.812 14.267,0.500 14.652,0.500 L19.303,0.500 C19.688,0.500 20.000,0.812 20.000,1.197 L20.000,5.848 C20.000,6.233 19.688,6.545 19.304,6.545 ZM2.379,19.107 L5.348,19.107 C5.733,19.107 6.045,19.419 6.045,19.803 C6.045,20.188 5.733,20.500 5.348,20.500 L0.697,20.500 C0.312,20.500 0.000,20.188 0.000,19.803 L0.000,15.152 C0.000,14.767 0.312,14.455 0.697,14.455 C1.082,14.455 1.394,14.767 1.394,15.152 L1.394,18.121 L6.017,13.498 C6.289,13.225 6.730,13.225 7.002,13.497 C7.274,13.769 7.274,14.210 7.002,14.482 L2.379,19.107 ZM6.372,7.568 C6.194,7.568 6.015,7.500 5.879,7.364 L1.393,2.878 L1.393,5.848 C1.393,6.233 1.081,6.545 0.696,6.545 C0.312,6.545 0.000,6.233 0.000,5.848 L0.000,1.197 C0.000,0.812 0.312,0.500 0.696,0.500 L5.348,0.500 C5.733,0.500 6.045,0.812 6.045,1.197 C6.045,1.581 5.733,1.893 5.348,1.893 L2.378,1.893 L6.864,6.379 C7.136,6.650 7.136,7.091 6.864,7.364 C6.728,7.500 6.550,7.568 6.372,7.568 Z"/>
         </svg>
      </div>
              {block name='product_flags'}
      <a href="{$product.url}">
        <ul class="product-flags">
          {foreach from=$product.flags item=flag}
            <li class="product-flag {$flag.type}">{$flag.label}</li>
          {/foreach}
          {if $product.has_discount}
            {if $product.discount_type === 'percentage'}
              <li class="product-flag discount-percentage">{$product.discount_percentage}</li>
             {else}
                <li class="product-flag discount-percentage">
                    {l s='- %amount%' d='Shop.Theme.Catalog' sprintf=['%amount%' => $product.discount_to_display]}
                </li>
              {/if}
          {/if}     


        </ul>
      </a>
      {/block}
    </div>
  {/block}

  {block name='product_images'}
    <div class="js-qv-mask mask">
      <ul class="product-images js-qv-product-images">
        {foreach from=$product.images item=image}
          <li class="thumb-container">
            <img
              class="thumb js-thumb {if $image.id_image == $product.cover.id_image} selected {/if}"
              data-image-medium-src="{$image.bySize.medium_default.url}"
              data-image-large-src="{$image.bySize.large_default.url}"
              src="{$image.bySize.slider_photo.url}"
              alt="{$image.legend}"
              title="{$image.legend}"
              width="100"
              itemprop="image"
            >
          </li>
        {/foreach}
      </ul>
    </div>
  {/block}

</div>
{hook h='displayAfterProductThumbs'}
