{*
* 2007-2015 PrestaShop
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
*  @author    Anvanto (anvantoco@gmail.com)
*  @copyright 2007-2018  http://anvanto.com
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}
{*
{foreach from=$tabs item=tab_content}
    {$tab_content->id|intval}
    {$tab_content->title.$id_lang|escape:'htmlall':'UTF-8'}
    {$tab_content->content.$id_lang|escape:'htmlall':'UTF-8' nofilter}
    {$tab_content->active|intval}
{/foreach}
*}
{foreach from=$tabs item=tab_content}
	<section class="page-product-box" view-type="{$display_type|escape:'htmlall':'UTF-8'}" id="{$tab_content['id']|escape:'htmlall':'UTF-8'}">
		<h3 class="page-product-heading">{$tab_content['title']|escape:'htmlall':'UTF-8'}</h3>
		<div  id="an_bootstraptabs" class="rte">{$tab_content['content'] nofilter}</div> {* HTML, no escape necessary *}
	</section>
{/foreach}

{*<ul class="nav nav-tabs" id="tab" role="tablist">*}
	{*{foreach from=$tabs item=tab_content}*}
		{*<li class="nav-item">*}
			{*<a class="nav-link active" id="{$tab_content['id']|escape:'htmlall':'UTF-8'}tab" data-toggle="tab" href="#{$tab_content['id']|escape:'htmlall':'UTF-8'}tab" role="tab" aria-controls="{$tab_content['id']|escape:'htmlall':'UTF-8'}tab" aria-selected="true">{$tab_content['title']|escape:'htmlall':'UTF-8'}</a>*}
		{*</li>*}
	{*{/foreach}*}
{*</ul>*}

{*<div class="tab-content" id="tabContent">*}
	{*{foreach from=$tabs item=tab_content}*}
		{*<div class="tab-pane fade show" id="{$tab_content['id']|escape:'htmlall':'UTF-8'}tab" role="tabpanel" aria-labelledby="{$tab_content['id']|escape:'htmlall':'UTF-8'}tab">{$tab_content['content']|escape:'htmlall':'UTF-8'}</div>*}
	{*{/foreach}*}
{*</div>*}
