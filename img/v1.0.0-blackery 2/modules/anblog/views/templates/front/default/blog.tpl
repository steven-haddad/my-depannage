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
		{if isset($error)}
				<div id="blogpage">
					<div class="blog-detail">
						<div class="alert alert-warning">{l s='Sorry, no posts has been posted in the blog yet, but it will be done soon' mod='anblog'}</div>
					</div>
				</div>
			{else}	
			<div id="blogpage">
				<article class="blog-detail">
					{if $is_active}
						<h1 class="blog-title">{$blog->meta_title|escape:'html':'UTF-8'}</h1>
						<div class="blog-meta">
							{if $config->get('item_show_author','1')}
							<span class="blog-author">
								<i class="material-icons">person</i> <span>{l s='Posted By' mod='anblog'}: </span>
								<a href="{$blog->author_link|escape:'html':'UTF-8'}" title="{$blog->author|escape:'html':'UTF-8'}">{$blog->author|escape:'html':'UTF-8'}</a>
							</span>
							{/if}

							{if $config->get('item_show_category','1')}
							<span class="blog-cat"> 
								<i class="material-icons">list</i> <span>{l s='In' mod='anblog'}: </span>
								<a href="{$blog->category_link|escape:'html':'UTF-8'}" title="{$blog->category_title|escape:'html':'UTF-8'}">{$blog->category_title|escape:'html':'UTF-8'}</a>
							</span>
							{/if}

							{if $config->get('item_show_created','1')}
							<span class="blog-created">
								<span>{l s='On' mod='anblog'}:</span>
								<time class="date" datetime="{strtotime($blog->date_add)|date_format:"%Y"|escape:'html':'UTF-8'}">
									{assign var='blog_month' value=strtotime($blog->date_add)|date_format:"%B"}
									{l s=$blog_month mod='anblog'},	<!-- month-->
									{assign var='blog_day' value=strtotime($blog->date_add)|date_format:"%e"}	
									{l s=$blog_day mod='anblog'}, <!-- day of month -->
									{assign var='blog_year' value=strtotime($blog->date_add)|date_format:"%Y"}		
									{l s=$blog_year mod='anblog'}	<!-- year -->
								</time>
							</span>
							{/if}
							
							{if isset($blog_count_comment)&&$config->get('item_show_counter','1')}
							<span class="blog-ctncomment">
								<i class="material-icons">comment</i> <span>{l s='Comments' mod='anblog'}:</span>
								{$blog_count_comment|intval}
							</span>
							{/if}
							{if isset($blog->hits)&&$config->get('item_show_hit','1')}
							<span class="blog-hit">
								<i class="material-icons">visibility</i> <span>{l s='Views' mod='anblog'}:</span>
								{$blog->hits|intval}
							</span>
							{/if}
						</div>

						{if $blog->preview_url && $config->get('item_show_image','1')}
							<div class="blog-image">
								<img src="{$blog->preview_url|escape:'html':'UTF-8'}" title="{$blog->meta_title|escape:'html':'UTF-8'}" class="img-fluid" />
							</div>
						{/if}

						<div class="blog-description">
							{if $config->get('item_show_description',1)}
								{$blog->description nofilter}{* HTML form , no escape necessary *}
							{/if}
							{$blog->content nofilter}{* HTML form , no escape necessary *}
						</div>
						
						

						{if trim($blog->video_code)}
						<div class="blog-video-code">
							<div class="inner ">
								{$blog->video_code nofilter}{* HTML form , no escape necessary *}
							</div>
						</div>
						{/if}

						<div class="social-share">
							 {include file="module:anblog/views/templates/front/default/_social.tpl" social_code=$config->get('social_code','')}
						</div>
						{if $tags}
						<div class="blog-tags">
							<span>{l s='Tags:' mod='anblog'}</span>
						 
							{foreach from=$tags item=tag name=tag}
								 <a href="{$tag.link|escape:'html':'UTF-8'}" title="{$tag.tag|escape:'html':'UTF-8'}"><span>{$tag.tag|escape:'html':'UTF-8'}</span></a>
							{/foreach}
							 
						</div>
						{/if}

						{if !empty($samecats)||!empty($tagrelated)}
						<div class="extra-blogs row">
						{if !empty($samecats)}
							<div class="col-lg-6 col-md-6 col-xs-12">
								<h4>{l s='In Same Category' mod='anblog'}</h4>
								<ul>
								{foreach from=$samecats item=cblog name=cblog}
									<li><a href="{$cblog.link|escape:'html':'UTF-8'}">{$cblog.meta_title|escape:'html':'UTF-8'}</a></li>
								{/foreach}
								</ul>
							</div>
							<div class="col-lg-6 col-md-6 col-xs-12">
								<h4>{l s='Related by Tags' mod='anblog'}</h4>
								<ul>
								{foreach from=$tagrelated item=cblog name=cblog}
									<li><a href="{$cblog.link|escape:'html':'UTF-8'}">{$cblog.meta_title|escape:'html':'UTF-8'}</a></li>
								{/foreach}
								</ul>
							</div>
						{/if}
						</div>
						{/if}

						{if $productrelated}

						{/if}
						{if $config->get('item_show_listcomment','1') == 1}
							<div class="blog-comment-block clearfix">
								{if $config->get('item_comment_engine','local')=='facebook'}
									{include file="module:anblog/views/templates/front/default/_facebook_comment.tpl"}
								{elseif $config->get('item_comment_engine','local')=='diquis'}
									{include file="module:anblog/views/templates/front/default/_diquis_comment.tpl"}
								
								{elseif ($config->get('google_captcha_site_key') && $config->get('google_captcha_site_key')) || !$config->get('google_captcha_status')}
									{include file="module:anblog/views/templates/front/default/_local_comment.tpl"}
								{/if}
						{elseif $config->get('item_show_listcomment','1') == 0 && $config->get('item_show_formcomment','1') == 1 && (($config->get('google_captcha_site_key') && $config->get('google_captcha_site_key')) || !$config->get('google_captcha_status') ) }
							<div class="blog-comment-block clearfix">
								{include file="module:anblog/views/templates/front/default/_local_comment.tpl"}
							</div>
						{/if}
					{else}
						<div class="alert alert-warning">{l s='Sorry, This blog is not avariable. May be this was unpublished or deleted.' mod='anblog'}</div>
					{/if}

				</article>
			</div>
			
			<div class="hidden-xl-down hidden-xl-up datetime-translate">
				{l s='Sunday' mod='anblog'}
				{l s='Monday' mod='anblog'}
				{l s='Tuesday' mod='anblog'}
				{l s='Wednesday' mod='anblog'}
				{l s='Thursday' mod='anblog'}
				{l s='Friday' mod='anblog'}
				{l s='Saturday' mod='anblog'}
				
				{l s='January' mod='anblog'}
				{l s='February' mod='anblog'}
				{l s='March' mod='anblog'}
				{l s='April' mod='anblog'}
				{l s='May' mod='anblog'}
				{l s='June' mod='anblog'}
				{l s='July' mod='anblog'}
				{l s='August' mod='anblog'}
				{l s='September' mod='anblog'}
				{l s='October' mod='anblog'}
				{l s='November' mod='anblog'}
				{l s='December' mod='anblog'}
							
			</div>
		{/if}
	</section>
{/block}