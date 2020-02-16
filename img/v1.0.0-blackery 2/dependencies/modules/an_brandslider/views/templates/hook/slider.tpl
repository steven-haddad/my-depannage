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
*         DISCLAIMER   *
* Do not edit or add to this file if you wish to upgrade Prestashop to newer
* versions in the future.
* ****************************************************
*
*  @author     Anvanto (anvantoco@gmail.com)
*  @copyright  anvanto.com
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div id="an_brandslider-block" class="clearfix col-lg-12">
	{if $doshowtitle && $title != ''}
	<div class="an_brandslider-title">{$title|escape:'htmlall':'UTF-8'}</div>
	{/if}
	<div class="owl-carousel an_brandslider-items">
		{foreach from=$an_manufacturers item=manufacturer}
		<div class="an_brandslider-item">
			<a href="{$manufacturer.link|escape:'html':'UTF-8'}" title="{l s='More about %s' sprintf=[$manufacturer.name] mod='an_brandslider'}">
				{if version_compare($smarty.const._PS_VERSION_, '1.7.0.0', '<>')}
					<img src="{$manufacturer.image|escape:'html':'UTF-8' }" alt="" />
				{else}
					{$manufacturer.image|escape:'quotes':'UTF-8'}
				{/if}
				{if isset($an_brandslider_options.displayName) && $an_brandslider_options.displayName == true}
					<span>{$manufacturer.name|escape:'html':'UTF-8'}</span>
				{/if}
			</a>
		</div>
		{/foreach}
	</div>
</div>
