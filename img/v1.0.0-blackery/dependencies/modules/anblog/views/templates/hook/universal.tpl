{*
* 2018 Anvanto
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
*  @copyright  2018 anvanto.com

*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{if isset($articles) AND !empty($articles)}
	<div class="clearfix"></div>
	<div class="secondary-blog">
		<div class="row">
			<div class="an_brandslider-title"><h3>Blog</h3></div>
		</div>
		{foreach from=$articles item=blog name=articlesListing}
			{if ($blog@iteration%$columnCount==1)&&$columnCount>1}
				<div class="row">
			{/if}
			<div class="{if $columnCount<=1}no{/if}col-lg-{floor(12/$columnCount|escape:'html':'UTF-8')}">

				{include file="module:anblog/views/templates/front/default/_listing_blog.tpl"}

			</div>
			{if ($blog@iteration%$columnCount==0&&$smarty.foreach.secondary_blog.last)&&$columnCount>1}
				</div>
			{/if}
		{/foreach}
	</div>
	<div class="clearfix"></div>
{/if}

