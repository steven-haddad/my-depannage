{*
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
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author    Anvanto <applynovation@gmail.com>
* @copyright 2007-2018 Anvanto
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}
<script>
    jQuery(document).ready(function(){
        jQuery('.an_tabs_btn').click(function(){
            $('.an_tabs_btn').removeClass('btn-info');
            $(this).addClass('btn-info');
            $('.tab_content').hide();
            $('#' + $(this).attr('id') + '_content').show();
        });
    });
</script>
<div id="tabs" class="anproductextratabs-style col-lg-3 col-md-12">
    <div class="tabswrapper">
        <button id="btn_tab_1" class="btn btn-default {if !$active_tab} btn-info {/if} an_tabs_btn">
            {l s='Tab templates' mod='anproductextratabs'}
        </button>
        <button id="btn_tab_2" class="btn btn-default an_tabs_btn">
            {l s='Tabs multiedit' mod='anproductextratabs'}
        </button>
        <button id="btn_tab_3" class="btn btn-default {if $active_tab == 'settings'}  btn-info {/if} an_tabs_btn">
            {l s='Settings' mod='anproductextratabs'}
        </button>
        <button id="btn_tab_4"  class="btn btn-default  {if $active_tab == 'design'} btn-info {/if} an_tabs_btn">
            {l s='Design' mod='anproductextratabs'}
        </button>
        <a href="https://addons.prestashop.com/contact-form.php?id_product=26048" class="btn btn-default an_tabs_btn">
            {l s='Support' mod='anproductextratabs'}
        </a>
        <a href="https://addons.prestashop.com/en/2_community-developer?contributor=496537" class="btn btn-default an_tabs_btn">
            {l s='Another modules' mod='anproductextratabs'}
        </a>
    </div>
</div>
<div class="anproductextratabs-style col-lg-9 col-md-12">
    <div id="btn_tab_1_content" class="tab_content" {if $active_tab} style="display: none" {/if}>{$an_renderTabList}</div> {* HTML form, no escape necessary *}
    <div id="btn_tab_2_content" class="tab_content" style="display: none">{$an_renderMultieditForms}</div> {* HTML form, no escape necessary *}
    <div id="btn_tab_3_content" class="tab_content" {if $active_tab != 'settings'} style="display: none" {/if}> {$an_renderSettings}</div> {* HTML form, no escape necessary *}
    <div id="btn_tab_4_content" class="tab_content" {if $active_tab != 'design'} style="display: none" {/if}> {$an_renderDesign}</div> {* HTML form, no escape necessary *}
</div>
<script>var languageids = [{$an_languages}]</script>
<div class="clearfix"></div>