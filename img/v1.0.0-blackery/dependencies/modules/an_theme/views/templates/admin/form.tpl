{**
* 2007-2017 PrestaShop
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
*  @author    Apply Novation <applynovation@gmail.com>
*  @copyright 2016-2017 Apply Novation
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}

{if count($tabs) > 1}
    <ul class="nav nav-tabs an_theme col-sm-2 col-xs-12">
    {foreach from=$tabs item=_tab key=i}
        <li{if $id_tab == $i} class="active"{/if}><a href="{$_tab.link|escape:'quotes':'UTF-8'}">{$_tab.legend.title|escape:'htmlall':'UTF-8'}</a></li>
    {/foreach}
		<li><a  class="an_theme-menu-moreproducts" href="//goo.gl/Sk1GH4
" target="_blank">See more products</a></li>
		<li><div class="an_theme-text-menu">
<strong>Rating:</strong> <br />
If you like this theme, Please RATE me 5 stars <a href="//goo.gl/rhYnsL
">here</a>.<br />  
Thank you very much! 
		</div></li>
    </ul>
{/if}

<div class="tab-content an_theme col-sm-10 col-xs-12">
    {if is_array($tab)}
        <div id="tab" class="tab-pane{if isset($tab.legend.class)} active {$tab.legend.class|escape:'htmlall':'UTF-8'}{/if}">
        {$tab.form}
        </div>
    {else}
        {$tab}
    {/if}
</div>
