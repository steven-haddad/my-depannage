{**
* 2019 Anvanto
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
*  @copyright  2019 anvanto.com

*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="panel col-lg-12">
    <div class="panel-heading">
        <span>Top products</span>
    </div>
    <div class="panel-body">
       <table class="table">
	   <thead>
	   <tr>
			<th width="70">Photo</th>
			<th>Name</th>
			<th>Wishlist</th>
	   </tr>
	   </thead>
	   {foreach from=$topProducts item=item}
	   <tr>
			<td><img src="{$item.image|escape:'htmlall':'UTF-8'}" style="max-width: 50px;" alt="" /></td>
			<td><a href="{$item.link|escape:'htmlall':'UTF-8'}" target="_blank">{$item.name|escape:'htmlall':'UTF-8'}</a></td>
			<td>{$item.count_wishlist|intval}</td>
	   </tr>
	   {/foreach}
	   </table>
    </div>
</div>

{include file='./suggestions.tpl'}
{include file='./recommend.tpl'}
