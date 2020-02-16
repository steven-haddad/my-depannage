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
{extends file=$layout}

{block name='content'}
	<section id="main">
		{if isset($no_follow) AND $no_follow}
			{assign var='no_follow_text' value='rel="nofollow"'}
		{else}
			{assign var='no_follow_text' value=''}
		{/if} 
		<div id="blog-listing" class="blogs-container box">
			{if isset($filter.type)}
				{if $filter.type=='tag'}
					<h1>{l s='Filter Blogs By Tag' mod='anblog'} : <span>{$filter.tag|escape:'html':'UTF-8'}</span></h1>
				{elseif $filter.type=='author'}
					{if isset($filter.id_employee)}
						<h1>{l s='Filter Blogs By Blogger' mod='anblog'} : <span>{$filter.employee->firstname|escape:'html':'UTF-8'} {$filter.employee->lastname|escape:'html':'UTF-8'}</span></h1>
					{else}
						<h1>{l s='Filter Blogs By Blogger' mod='anblog'} : <span>{$filter.author_name|escape:'html':'UTF-8'}</span></h1>
					{/if}
					
				{/if}
			{else}
				<h1 class="blog-lastest-title">{l s='Lastest Blogs' mod='anblog'}</h1>
				{if $url_rss != ''}
					<h4 class="blog-lastest-rss"><a href="{$url_rss}">{$config->get('rss_title_item')}</a></h4>
				{/if}
			{/if}

			<div class="inner">
				{if count($leading_blogs)+count($secondary_blogs)>0}
					{if count($leading_blogs)}
					<div class="leading-blog">
						{foreach from=$leading_blogs item=blog name=leading_blog}

							{if ($smarty.foreach.leading_blog.iteration%$listing_leading_column==1)&&$listing_leading_column>1}
							  <div class="row">
							{/if}
							<div class="{if $listing_leading_column<=1}no{/if}col-lg-{floor(12/$listing_leading_column|escape:'html':'UTF-8')}">

									{include file="module:anblog/views/templates/front/default/_listing_blog.tpl"}

							</div>
							{if ($smarty.foreach.leading_blog.iteration%$listing_leading_column==0||$smarty.foreach.leading_blog.last)&&$listing_leading_column>1}
								</div>
							{/if}
						{/foreach}
					</div>
					{/if}


					{if count($secondary_blogs)}
					<div class="secondary-blog">


						{foreach from=$secondary_blogs item=blog name=secondary_blog}
							{if ($smarty.foreach.secondary_blog.iteration%$listing_secondary_column==1)&&$listing_secondary_column>1}
							  <div class="row">
							  	
							{/if}
							<div class="{if $listing_secondary_column<=1}no{/if}col-lg-{floor(12/$listing_secondary_column|escape:'html':'UTF-8')}">

									{include file="module:anblog/views/templates/front/default/_listing_blog.tpl"}



							</div>
							{if ($smarty.foreach.secondary_blog.iteration%$listing_secondary_column==0||$smarty.foreach.secondary_blog.last)&&$listing_secondary_column>1}
							</div>
							{/if}
						{/foreach}
					</div>
					{/if}
					<div class="top-pagination-content clearfix bottom-line">
									{include file="module:anblog/views/templates/front/default/_pagination.tpl"}

					</div>
				{else}
					<div class="alert alert-warning">{l s='Sorry, no posts has been posted in the blog yet, but it will be done soon.' mod='anblog'}</div>
				{/if}

			</div>
		</div>
	</section>
{/block}