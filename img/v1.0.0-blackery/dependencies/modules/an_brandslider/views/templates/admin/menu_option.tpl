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

<select multiple="multiple" name="items[]" id="items" style="width: 300px; height: 160px;">
    {foreach from=$menu_item item=manID}
    <option selected="selected" value="{$manID|intval}">{Manufacturer::getNameById($manID)|escape:'htmlall':'UTF-8'}</option>
    {/foreach}
</select>