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
{$image_limit = Module::getInstanceByName('an_theme')->getParam('segmentedviewsettinds_imagelimit')}

{block name='product_miniature_item'}   {* $product.images|@debug_print_var nofilter *}
  <article class="product-miniature js-product-miniature
	{if Module::isEnabled('an_theme')}
	js-img-view-type
	type-{Module::getInstanceByName('an_theme')->getParam('product_productImageChange')}
	{/if}
	{if Module::isEnabled('an_theme') and  Module::getInstanceByName('an_theme')->getParam('product_productMobileRow')}
    product-mobile-row
    {/if}
	{if isset($page) and $page.page_name == 'category'}
	    {if isset($smarty.cookies.an_collection_view)}
	        col-lg-{$smarty.cookies.an_collection_view}
	    {else}
            {Module::getInstanceByName('an_theme')->getParam('categoryPage_productsAmount')}
	    {/if}
	{/if}
	{if Module::isEnabled('an_productattributes') and Module::getInstanceByName('an_productattributes')->getParam('display_quantity') and Module::isEnabled('an_wishlist')}
		attrributes-type-column
	{/if}

" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
    <div class="thumbnail-container ">
		
		<div class="thumbnail-container-image " style="min-height: 250px;">
		{if isset($product->ean13) AND $product->ean13}
        <meta itemprop="gtin13" content="{l s='EAN Code:'}{$product->ean13}">
        {/if}
        {if isset($product->isbn) AND $product->isbn}
        <meta itemprop="gtin13" content="{l s='ISBN Code:'}{$product->isbn}">
        {/if}
        {if isset($product->upc) AND $product->upc}
        <meta itemprop="gtin13" content="{l s='UPC Code:'}{$product->upc}">
        {/if}
        {if isset($product.cover.large.url) AND $product.cover.large.url}
        <meta itemprop="image" content="{$product.cover.large.url}">
        {/if}
        {if isset($product.id_manufacturer) AND $product.id_manufacturer}
        <meta itemprop="brand" content="{Manufacturer::getnamebyid($product.id_manufacturer)}">
        {/if}
        {if isset($product.description_short) AND $product.description_short}
        <meta itemprop="description" content="{$product.description_short|strip_tags:'UTF-8'}">
        {/if}
		<meta itemprop="sku" content="{$product.id_product}">
		
		{block name='product_thumbnail'}	
        {if Module::isEnabled('an_theme')}
	        {if Module::getInstanceByName('an_theme')->getParam('product_productImageChange') == 'standart'}
	        <a href="{$product.url}" class="thumbnail product-thumbnail">
            <img
            src = "{$product.cover.bySize.home_default.url}"
            alt = "{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
            data-full-size-image-url = "{$product.cover.large.url}"
            data-width="{$product.cover.bySize.home_default.width}"
            data-height="{$product.cover.bySize.home_default.height}"
            > 
        </a>
	        {elseif Module::getInstanceByName('an_theme')->getParam('product_productImageChange') == 'hover'}
						<a href="{$product.url}" class="thumbnail product-thumbnail">
            {foreach from=$product.images item=image name=foo} 
            
                <img
                  class=" img_hover_change {if $image.id_image == $product.cover.id_image} cover {/if} {if $smarty.foreach.foo.total == 1 } only_one {/if}"
                  data-full-size-image-url="{$image.bySize.large_default.url} "
                  src="{$image.bySize.home_default.url}"
                  alt="{$image.legend}"
                  data-width="{$product.cover.bySize.home_default.width}"
                  data-height="{$product.cover.bySize.home_default.height}"
                >
            {/foreach}
            </a>
            {elseif Module::getInstanceByName('an_theme')->getParam('product_productImageChange') == 'slider'}
						<div class="slider_product-wrapper">
							<div class="slider-product-item">
							 <a href="{$product.url}" class="thumbnail product-thumbnail">
								<img
								src="
								{$product.cover.bySize.home_default.url}
								"
								 alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
								 data-full-size-image-url="{$product.cover.large.url}"
								 class="{if Module::getInstanceByName('an_theme')->getParam('global_lazyLoad')} b-lazy {/if} slider_product cover"
								 data-width="{$product.cover.bySize.home_default.width}"
								 data-height="{$product.cover.bySize.home_default.height}"
								>
							</a>
						 </div>
							 {foreach from=$product.images item=image}
								 {if $image.id_image != $product.cover.id_image}
								 <div class="slider-product-item">
								 <a href="{$product.url}" class="thumbnail product-thumbnail">
									 <img
									 class="{if Module::getInstanceByName('an_theme')->getParam('global_lazyLoad')} b-lazy {/if} slider_product not_cover"
										data-full-size-image-url="{$image.bySize.large_default.url}"
										src="
										{$image.bySize.home_default.url}
										"
										alt="{$image.legend}"
										data-width="{$product.cover.bySize.home_default.width}"
										data-height="{$product.cover.bySize.home_default.height}"
									 >
									</a>
								 </div>
									{/if}
								 {/foreach}
						 </div>
            {elseif Module::getInstanceByName('an_theme')->getParam('product_productImageChange') == 'hover-slider'}
				<a href="{$product.url}" class="thumbnail product-thumbnail hover_slider">
					<ul {if $product.images|@count == 1} class="only_one_item"{/if}>
						<li class="cover-item">
							<div class="hover-slider-img">
								<img
									class="hover-slider-image"
									src = "{$product.cover.bySize.home_default.url}"
									alt = "{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
									data-full-size-image-url = "{$product.cover.large.url}"
									data-width="{$product.cover.bySize.home_default.width}"
									data-height="{$product.cover.bySize.home_default.height}"
								>
							</div>
						</li>
                        {$image_limit_other = $image_limit}
                        {foreach from=$product.images item=image name=hoverslider}
                            {if $smarty.foreach.hoverslider.iteration == $image_limit and $image.id_image == $product.cover.id_image }
                            	{$image_limit_other = $image_limit-1}
                            {elseif $smarty.foreach.hoverslider.iteration > $image_limit and $image.id_image == $product.cover.id_image }
                                {$image_limit_other = $image_limit-1}
                            {/if}
                        {/foreach}
						{foreach from=$product.images item=image name=hoverslider}
                            {if $image.id_image != $product.cover.id_image and $smarty.foreach.hoverslider.iteration <= $image_limit_other}
								<li class="no-cover-item">
									<div class="hover-slider-img">
										{if Module::getInstanceByName('an_theme')->getParam('segmentedviewsettinds_textonlastimg') == 1}
											{if $smarty.foreach.hoverslider.iteration == $image_limit_other and ($product.images|@count-$image_limit)>0}
												<div class="more-images">
													{$product.images|@count-$image_limit}
													{if ($product.images|@count-$image_limit) == 1}
														{l s='more image' d='Shop.Theme.Actions'}
													{else}
														{l s='more images' d='Shop.Theme.Actions'}
													{/if}
												</div>
											{/if}
                                        {/if}
										<img
											class="hover-slider-image"
											data-full-size-image-url="{$image.bySize.large_default.url}"
											src="{$image.bySize.home_default.url}"
											alt="{$image.legend}"
											data-width="{$product.cover.bySize.home_default.width}"
											data-height="{$product.cover.bySize.home_default.height}"
										>
									</div>
								</li>
							{/if}
						{/foreach}
					</ul>
				</a>
	        {/if}
	    {else}
	    <a href="{$product.url}" class="thumbnail product-thumbnail">
	  	    <img
	        src = "{$product.cover.bySize.home_default.url}"
	        alt = "{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
					data-full-size-image-url = "{$product.cover.large.url}"
					data-width="{$product.cover.bySize.home_default.width}"
					data-height="{$product.cover.bySize.home_default.height}"
	        > 
	    </a>
		{/if}    
		{/block}

			<div class="highlighted-informations{if !$product.main_variants} no-variants{/if} hidden-sm-down">
		  {if Module::isEnabled('an_theme') and Module::getInstanceByName('an_theme')->getParam('global_showquickview') == 1}
		  	{block name='quick_view'}
			  <a class="quick-view" href="#" data-link-action="quickview">
					<svg 
					xmlns="http://www.w3.org/2000/svg"
					xmlns:xlink="http://www.w3.org/1999/xlink"
					width="21px" height="12px">
				<path fill-rule="evenodd"  fill="rgb(7, 7, 7)"
					d="M10.093,0.000 C6.272,0.000 2.807,2.104 0.250,5.522 C0.041,5.802 0.041,6.193 0.250,6.474 C2.807,9.896 6.272,12.000 10.093,12.000 C13.914,12.000 17.380,9.896 19.937,6.478 C20.145,6.198 20.145,5.807 19.937,5.526 C17.380,2.104 13.914,0.000 10.093,0.000 ZM10.367,10.225 C7.831,10.385 5.736,8.281 5.896,5.724 C6.027,3.616 7.725,1.907 9.819,1.775 C12.356,1.615 14.450,3.719 14.291,6.276 C14.156,8.380 12.458,10.089 10.367,10.225 ZM10.241,8.273 C8.874,8.360 7.745,7.227 7.835,5.852 C7.905,4.715 8.821,3.797 9.950,3.723 C11.317,3.636 12.446,4.768 12.356,6.144 C12.282,7.285 11.366,8.203 10.241,8.273 Z"/>
				</svg>
			  </a>
			{/block}
		  {/if}
			{if !Module::isEnabled('an_productattributes')}
				{block name='product_variants'}
				{if $product.main_variants}
					{include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
				{/if}
				{/block}
			{/if}
		  </div>
		</div>
		
      <div class="product-description">

        {block name='product_name'}
          <h3 class="h6 product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:50:'...'}</a></h3>
        {/block}
		
		{if Module::isEnabled('an_theme') and Module::getInstanceByName('an_theme')->getParam('product_imageQuickLookBar') == 1}
		<div class="product-miniature-images-all">
		{foreach from=$product.images item=image}
		  {if $image.id_image != $product.cover.id_image}
		  <a href="{$product.url}" class="">
			<img
			  class="product-miniature-images-all-img"
			  src="{$image.bySize.slider_photo.url}"
			  alt="{$image.legend}"
			>
		   </a>
		   {/if}
		  {/foreach}
		</div>
		{/if}

				{if (Module::isEnabled('an_theme') and Module::getInstanceByName('an_theme')->getParam('product_shortdescription') == 1) or (
					Module::isEnabled('an_theme') and Module::getInstanceByName('an_theme')->getParam('product_shortdescription') == 0 and isset($page) and ($page.page_name == 'category' or $page.page_name == 'search'))}
				{$max_length = Module::getInstanceByName('an_theme')->getParam('product_shortdescriptionlength')}
					{block name='product_description_short'}
							<p class="an_short_description {if Module::isEnabled('an_theme') and Module::getInstanceByName('an_theme')->getParam('product_shortdescription') == 0 and isset($page) and ($page.page_name == 'category' or $page.page_name == 'search')}grid-view-desc{/if}" id="an_short_description_{$product.id}">
									{if Module::isEnabled('an_theme') and Module::getInstanceByName('an_theme')->getParam('product_shortdescription') == 0 and isset($page) and ($page.page_name == 'category' or $page.page_name == 'search')}
											{$product.description_short|strip_tags:'UTF-8'|truncate:300:'...'}
									{else}
											{$product.description_short|strip_tags:'UTF-8'|truncate:$max_length:'...'}
									{/if}
							</p>
					{/block}
				{/if}
        {block name='product_price_and_shipping'}
          {if $product.show_price}
            <div class="product-price-and-shipping" itemprop="offers" itemscope itemtype="http://schema.org/Offer" priceValidUntil="">
							<meta itemprop="priceCurrency" content="{$currency.iso_code}">
							<meta itemprop="url" content="{$product.url}">
							<link itemprop="availability" href="http://schema.org/InStock">
              
              {hook h='displayProductPriceBlock' product=$product type="before_price"}
              <span class="sr-only">{l s='Price' d='Shop.Theme.Catalog'}</span>
							<span class="price" itemprop="price" content="{$product.price_tax_exc}">
								<span class="money" data-currency-{$currency.iso_code|lower}="{$product.price}">{$product.price}</span>


							</span>
							{if $product.has_discount}
                {hook h='displayProductPriceBlock' product=$product type="old_price"}
                <span class="sr-only">{l s='Regular price' d='Shop.Theme.Catalog'}</span>
								<span class="regular-price">{$product.regular_price}</span>
								
							{/if}
							
							<div class="product-miniature-attributes"> 
								<div class="product-miniature-actions"> 
								{hook h='displayProductPriceBlock' product=$product type='unit_price'}
								{hook h='displayProductPriceBlock' product=$product type='weight'}
								{block name='product_reviews'}
									{hook h='displayProductListReviews' product=$product}
								{/block}
								</div>
							</div> 
            </div>
          {/if}

        {/block}

        
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
  </article>
{/block}
