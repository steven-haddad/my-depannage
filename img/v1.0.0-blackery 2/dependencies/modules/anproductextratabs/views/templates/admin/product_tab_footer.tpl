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
{if !$new}
    </div>
</div>
{/if}
<script type='text/javascript'>
    var anpt_messages = JSON.parse("{$anproductextratabs_msg|escape:'javascript':'UTF-8'}");
    var anpt_controller_url = decodeURIComponent('{$anproductextratabs_theme_url|escape:'url':'UTF-8'}&ajax');

    jQuery(document).ready(function () {
        jQuery("[name='submit_tabs']").on('click', function () {
            {if $new}
            var id_anproducttabs = parseInt(jQuery(this).attr('data-id-tab')) || 0;
            {else}
            var id_anproducttabs = jQuery(this).attr('class').substr((new String('btn btn-success pull-right submit_tab_')).length);
            {/if}
            var id = parseInt(jQuery('input[name="content_id_'+id_anproducttabs+'"]').val()) || 0;
            var lang_id = parseInt(jQuery(this).attr('data-language')) || 0;

            var _title = {};
            var _content = {};
            var temp_content;
            {foreach from=$languages item=lang}


                temp_content ='';
                if (typeof tinyMCE !== 'undefined' &&  tinyMCE.get('content_content_' + id_anproducttabs + '_' +{$lang.id_lang|intval})) {
                    var temp_content = tinyMCE.get('content_content_' + id_anproducttabs + '_' +{$lang.id_lang|intval}).getContent()
                }
                _title[{$lang.id_lang|intval}] = jQuery('#content_title_'+id_anproducttabs+'_'+{$lang.id_lang|intval}).val();
                _content[{$lang.id_lang|intval}] = temp_content;
        {/foreach}

            jQuery.post(anpt_controller_url, {
                action: 'updateContent',
                id: id,
                id_anproducttabs: id_anproducttabs,
                id_product: {$id_product|intval},
                id_shop: {$id_shop|intval},
                title: _title,
                content: _content,
                {if $new}
                active: parseInt(jQuery("[name='content_active_"+id_anproducttabs+"'] :checked").val()) || 0
                {else}
                active: jQuery("#content_active_"+id_anproducttabs+"_on")[0].checked ? 1 : 0
                {/if}

            }).then(function (response) {
                if (response.content_id > 0) {
                    showSuccessMessage(anpt_messages.update.success);
                    jQuery('input[name="content_id_'+id_anproducttabs+'"]').attr('value', response.content_id);
                } else {
                    showErrorMessage(anpt_messages.update.error);
                }
            });

            return false;
        });

    });

    jQuery('.translations.tabbable').each(function () {
        var id = jQuery(this).attr('id');
        jQuery('.translationsFields-'+id+'_{$id_lang|intval}').removeClass('visible');
        jQuery('.translationsFields-'+id+'_{$id_lang|intval}').removeClass('active');
        {if $morenew}
            jQuery('.translationsFields-'+id+'_{$id_lang|intval}').addClass('visible');
        {else}
            jQuery('.translationsFields-' + id + '_{$id_lang|intval}').addClass('active');
        {/if}
    });

</script>

<style type='text/css'>
    .anproductextratabs_forms { margin: 20px 0; border: 1px solid #bbcdd2; padding: 20px 0 20px 0; }
    .anproductextratabs_forms h4 { border-bottom: 1px solid #bbcdd2; padding: 0 0 10px 0; }
    .anproductextratabs_forms .form-group { margin: 5px 0; display: table; width: 100%; }
    .pull-right { float: right !important; }
    {if $new}
    .mce-toolbar-grp{
        border-top: 1px solid #ccc !important;
        border-right: 1px solid #ccc !important;
        border-left: 1px solid #ccc !important;
    }
    .mce-edit-area{
        border-width: 1px !important;
        border-style: solid !important;
        border-color: #ccc !important;
    }
    .col-md-9, .col-md-3 { float: left }
    .tab-pane .text-right { text-align: left !important; }
    {/if}
</style>