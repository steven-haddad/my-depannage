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

{function name="categories" nodes=[] depth=0}
  {strip}
    {if $nodes|count}
      <ul class="category-sub-menu">
        {foreach from=$nodes item=node}
          <li data-depth="{$depth}">
            {if $depth===0}
              <a href="{$node.link}">{$node.name}</a>
              {if $node.children}
                <div class="navbar-toggler collapse-icons" data-toggle="collapse" data-target="#exCollapsingNavbar{$node.id}">
                  <i class="material-icons add"><svg 
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="8px" height="4px">
                   <path fill-rule="evenodd"  fill="rgb(7, 7, 7)"
                    d="M4.000,4.000 L0.670,0.500 L7.330,0.500 L4.000,4.000 Z"/>
                   </svg></i>
                  <i class="material-icons remove"><svg 
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="7px" height="4px">
                   <path fill-rule="evenodd"  fill="rgb(7, 7, 7)"
                    d="M3.500,-0.000 L6.986,4.000 L0.014,4.000 L3.500,-0.000 Z"/>
                   </svg></i>
                </div>
                <div class="collapse" id="exCollapsingNavbar{$node.id}">
                  {categories nodes=$node.children depth=$depth+1}
                </div>
              {/if}
            {else}
              <a class="category-sub-link" href="{$node.link}">{$node.name}</a>
              {if $node.children}
                <span class="arrows" data-toggle="collapse" data-target="#exCollapsingNavbar{$node.id}">
                  <i class="material-icons arrow-right">&#xE315;</i>
                  <i class="material-icons arrow-down">&#xE313;</i>
                </span>
                <div class="collapse" id="exCollapsingNavbar{$node.id}">
                  {categories nodes=$node.children depth=$depth+1}
                </div>
              {/if}
            {/if}
          </li>
        {/foreach}
      </ul>
    {/if}
  {/strip}
{/function}

{if $categories.children|count}
<div class="block-categories hidden-sm-down">
  <ul class="category-top-menu">
    <li>{categories nodes=$categories.children}</li>
  </ul>
</div>
{/if}
