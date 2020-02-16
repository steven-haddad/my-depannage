{*
 * 2007-2016 PrestaShop
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
 *  @author    Apply Novation (Artem Zwinger)
 *  @copyright 2016-2017 Apply Novation
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *}

{extends file="helpers/form/form.tpl"}

{block name="input"}
    {if $input.type == 'number' or $input.type == 'float'}
        <div class='input-group'>
        <input type="number"
            id="{if isset($input.id)}{$input.id|intval}{else}{$input.name|escape:'htmlall':'UTF-8'}{/if}"
            name="{$input.name|escape:'htmlall':'UTF-8'}"
            class="form-control"
            value="{$fields_value[$input.name]|escape:'html':'UTF-8'}"
            {if isset($input.size)} size="{$input.size|intval}"{/if}
            {if isset($input.maxchar) && $input.maxchar} data-maxchar="{$input.maxchar|intval}"{/if}
            {if isset($input.maxlength) && $input.maxlength} maxlength="{$input.maxlength|intval}"{/if}
            {if isset($input.readonly) && $input.readonly} readonly="readonly"{/if}
            {if isset($input.disabled) && $input.disabled} disabled="disabled"{/if}
            {if isset($input.autocomplete) && !$input.autocomplete} autocomplete="off"{/if}
            {if isset($input.required) && $input.required} required="required" {/if}
            {if isset($input.max)} max="{$input.max}"{/if}
            {if isset($input.min)} min="{$input.min}"{/if}
            {if isset($input.step)} step="{$input.step|floatval}"{/if}
            {if isset($input.placeholder) && $input.placeholder} placeholder="{$input.placeholder|escape:'htmlall':'UTF-8'}"{/if} />
            {if !empty($input.suffix)}
            <span class="input-group-addon">
                {$input.suffix|escape:'htmlall':'UTF-8'}
            </span>
            {/if}
        </div>
	{elseif $input.type == 'textarea'}
		<textarea
				id="{if isset($input.id)}{$input.id|intval}{else}{$input.name|escape:'htmlall':'UTF-8'}{/if}"
				name="{$input.name|escape:'htmlall':'UTF-8'}"
				class="form-control"
				rows="{$input.rows|escape:'htmlall':'UTF-8'}">{$fields_value[$input.name]|escape:'html':'UTF-8'}</textarea>
	{else}
		{$smarty.block.parent}
    {/if}
{/block}
