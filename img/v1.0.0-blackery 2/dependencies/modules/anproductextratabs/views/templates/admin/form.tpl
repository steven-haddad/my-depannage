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
<div class='row anproductextratabs_forms'>
    <div class='col-lg-12'>
        <h4>{l s='Edit tab' mod='anproductextratabs'} {$tab->name|escape:'htmlall':'UTF-8'}</h4>

        <input type='hidden' name='id_shop' value='{$tab->id_shop|intval}'>
        <div class='col-md-3'>
            <label>Tab type: {$tab->getTypeFull($tab->type)|escape:'htmlall':'UTF-8'}</label>
        </div>
        {foreach from=$fields item=field}
        <div class='form-group'>

                {if $field.type == 'hidden'}
                    <input type='hidden' name='{$field.name|escape:'htmlall':'UTF-8'}' value='{if isset($fields_value[$field.name])}{$fields_value[$field.name]|escape:'htmlall':'UTF-8'}{/if}'>

                {elseif $field.type == 'switch'}
                <div class="form-group">
                    <div class='col-md-3 text-right'>
                        <label for='{$field.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|intval}'>{$field.label|escape:'htmlall':'UTF-8'}</label>
                    </div>
                    <div class='col-md-3'>
                        <select class='form-control' name='{$field.name|escape:'htmlall':'UTF-8'}'>
                            {if isset($field.values)}
                                {foreach from=$field.values item=value}
                                <option value='{$value.value|intval}'{if ($fields_value[$field.name] == $value.value) or ($fields_value[$field.name] != $value.value and $field.value == $value.value)} selected{/if}>{$value.label|escape:'htmlall':'UTF-8'}</option>
                                {/foreach}
                            {/if}
                        </select>
                    </div>
                </div>
                {elseif $field.type == 'textarea'}
                    {if $field.lang === true}
                        <div class="translations tabbable" id="{$field.name|escape:'htmlall':'UTF-8'}">
                            <div class="translationsFields tab-content">
                                {foreach from=$languages item=language}
                                <div class="translationsFields-{$field.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|intval} tab-pane translation-field translation-label-{$language.iso_code|escape:'htmlall':'UTF-8'}">
                                    <div class='col-md-3 text-right'>
                                        <label for='{$field.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|intval}'>{$field.label|escape:'htmlall':'UTF-8'}</label>
                                    </div>
                                    <div class='col-md-9'>
                                        <textarea class='rte autoload_rte form-control' id='{$field.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|intval}' name='{$field.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|intval}'>
                                        {if isset($fields_value[$field.name]) and isset($fields_value[$field.name][$language.id_lang])}
                                            {$fields_value[$field.name][$language.id_lang] nofilter} {* HTML, no escape necessary *}
                                        {/if}
                                        </textarea>
                                    </div>
                                </div>
                                {/foreach}
                            </div>
                        </div>
                    {else}

                    {/if}
                {else}
                    {if $field.lang === true}
                        <div class="translations tabbable" id="{$field.name|escape:'htmlall':'UTF-8'}">
                            <div class="translationsFields tab-content">
                                {foreach from=$languages item=language}
                                 <div class="translationsFields-{$field.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|intval} tab-pane translation-field translation-label-{$language.iso_code|escape:'htmlall':'UTF-8'}">
                                    <div class='col-md-3 text-right'>
                                        <label for='{$field.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|intval}'>{$field.label|escape:'htmlall':'UTF-8'}</label>
                                    </div>
                                    <div class='col-md-9'>
                                        <input value='{if isset($fields_value[$field.name]) and isset($fields_value[$field.name][$language.id_lang])}{$fields_value[$field.name][$language.id_lang]|escape:'htmlall':'UTF-8'}{/if}' type='{$field.type|escape:'htmlall':'UTF-8'}' class='form-control' id='{$field.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|intval}' name='{$field.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|intval}'>
                                    </div>
                                </div>
                                {/foreach}
                            </div>
                        </div>

                    {else}
                    <div class='col-md-3 text-right'>
                        <label for='{$field.name|escape:'htmlall':'UTF-8'}'>{$field.label|escape:'htmlall':'UTF-8'}</label>
                    </div>
                    <div class='col-md-9'>
                        <input value='{if isset($fields_value[$field.name])}{$fields_value[$field.name]|escape:'htmlall':'UTF-8'}{/if}' type='{$field.type|escape:'htmlall':'UTF-8'}' class='form-control' id='{$field.name|escape:'htmlall':'UTF-8'}' name='{$field.name|escape:'htmlall':'UTF-8'}'>
                    </div>
                    {/if}
                {/if}
        </div>
        {/foreach}
        <div class='form-group'>
            <div class="translations tabbable" id="apnt_button_submit">
                <div class="translationsFields tab-content">
                    {foreach from=$languages item=language}
                    <div class="translationsFields-apnt_button_submit_{$language.id_lang|intval} tab-pane translation-field translation-label-{$language.iso_code|escape:'htmlall':'UTF-8'}">
                        <button type='button' data-id-tab='{$tab->id|intval}' data-language='{$language.id_lang|intval}' name='submit_tabs' class='btn btn-success pull-right submit_tab_{$tab->id|intval}'><i class=''></i> {l s='Save' mod='anproductextratabs'}</button>
                    </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>