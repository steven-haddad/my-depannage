{**
* 2007-2018 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*}
<div id="anproductextratabs_data"
	 data-ajax-action-url="{$cart_url nofilter}"></div> {* HTML, no escape necessary *}
<input type="hidden" class="list_token" value="{$token|escape:'htmlall':'UTF-8'}">
{if $productData}
	{if $config['table_template'] == 'table-responsive'}<div class="{$config['table_template']|escape:'htmlall':'UTF-8'}">{/if}
	<table class="an_table {if $config['display_sort']}an_sort{/if} {if $config['table_template'] != 'table-responsive'}{$config['table_template']|escape:'htmlall':'UTF-8'}{/if}{if $config['table_template'] != 'table'} table{/if}{if version_compare($smarty.const._PS_VERSION_, '1.7.0.0', '>')} anproductextratabs_17{/if}">
		<thead>
		<tr>
			{if $config['display_image']}
				<th class="tablesorter-noSort">{l s='Image' mod='anproductextratabs'}</th>
			{/if}

			{if $config['display_reference']}
				<th>{l s='Reference' mod='anproductextratabs'}</th>
			{/if}
			{if $config['display_attributes']}
				{if $config['combine_attributes']}
					<th>{l s='Attributes' mod='anproductextratabs'}</th>
				{else}
					{foreach from=$title_combinations key=k1 item=v1}
						<th>{$k1|escape:'htmlall':'UTF-8'}</th>
					{/foreach}
				{/if}
			{/if}

			{if $config['display_availability']}
				<th>{l s='Availability' mod='anproductextratabs'}</th>
			{/if}
			{if $config['display_quantity']}
				<th>{l s='Quantity' mod='anproductextratabs'}</th>
			{/if}
			{if $config['display_price']}
				<th>{l s='Price' mod='anproductextratabs'}</th>
			{/if}
			{if $config['display_add_to_cart']}
				<th>{l s='Quantity' mod='anproductextratabs'}</th>
			{/if}
			{if $config['display_field_quantity']}
				<th>{l s='Add to cart' mod='anproductextratabs'}</th>
			{/if}
		</tr>
		</thead>
		<tbody>
		{foreach from=$productData key=k item=v}
			<tr>
				{if $config['display_image']}
					<td><a href="{$v['image_big']['link']|escape:'htmlall':'UTF-8'}" rel="product_gal"><img src="{$v['image']['link']|escape:'htmlall':'UTF-8'}"></a></td>
				{/if}

				{if $config['display_reference']}
					<td>
						{if strlen($v['comb'][0]['reference']) > 0}
							{$v['comb'][0]['reference']|escape:'htmlall':'UTF-8'}
						{else}
							-
						{/if}
					</td>
				{/if}
				{if $config['display_attributes']}
					{if $config['combine_attributes']}
						<td>
							{foreach from=$productData[$k]['comb'] key=k3 item=v3}
								<b>{$v3['group_name']|escape:'htmlall':'UTF-8'}</b>: {$v3['attribute_name']|escape:'htmlall':'UTF-8'};
							{/foreach}
						</td>
					{else}
						{foreach from=$productData[$k]['comb'] key=k3 item=v3}
							<td>{$v3['attribute_name']|escape:'htmlall':'UTF-8'}</td>
						{/foreach}
					{/if}
				{/if}

				{if $config['display_availability']}
					<td>{if $productData[$k]['comb'][0]['quantity']}{$v['available_now']|escape:'htmlall':'UTF-8'}{else}{$v['available_later']|escape:'htmlall':'UTF-8'}{/if}</td>
				{/if}
				{if $config['display_quantity']}
					<td>{$productData[$k]['comb'][0]['quantity']|escape:'htmlall':'UTF-8'}</td>
				{/if}
				{if $config['display_price']}
					<td>
						<div>{$v['price_formatted']|escape:'htmlall':'UTF-8'}</div>
						{if $v['impact'] != 0}
							<div style="text-decoration: line-through">{$v['price_without_impact_formatted']|escape:'htmlall':'UTF-8'}</div>
							<div>{$v['impact_formatted']|escape:'htmlall':'UTF-8'}</div>
						{/if}
					</td>
				{/if}
				{if $config['display_field_quantity']}
					<td>
						<input type="number" value="{$productData[$k]['comb'][0]['minimal_quantity']|escape:'htmlall':'UTF-8'}" min="{$productData[$k]['comb'][0]['minimal_quantity']|escape:'htmlall':'UTF-8'}" data-role="qty" class="an_input_q">
					</td>
				{else}
					<input type="hidden" value="{$productData[$k]['comb'][0]['minimal_quantity']|escape:'htmlall':'UTF-8'}" min="{$productData[$k]['comb'][0]['minimal_quantity']|escape:'htmlall':'UTF-8'}" data-role="qty">
				{/if}
				{if $config['display_add_to_cart']}
					<td>
						{if $productData[$k]['comb'][0]['quantity'] > 0}
							<input type="hidden" data-role="id_product" value="{$v['id_product']|intval}">
							<input type="hidden" data-role="id_product_attribute" value="{$k|intval}">
							<a class="an_add_to_cart btn {if $config['new']} btn-primary  {/if}  add-to-cart" >{if $config['new']}<i class="material-icons shopping-cart"></i>{l s='Add to cart' mod='anproductextratabs'}{else}<img src="{$base_dir|escape:'htmlall':'UTF-8'}modules/anproductextratabs/views/img/cart.png" >{/if}</a>
						{/if}
					</td>
				{/if}
			</tr>
		{/foreach}
		</tbody>
	</table>
	{if $config['table_template'] == 'table-responsive'}
		</div>
	{/if}
{/if}