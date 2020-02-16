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

<script id='row_template' type="text/html">
    <tr data-id='tab_id'>
        <td>tab_id</td>
        <td>tab_name</td>
        <td class='move-handle'><div style='display: table; width: auto; cursor: pointer' class='form-control'><i class='icon-move'></i> tab_position</div></td>
        <td class='text-right'>
            <div class="btn-group-action">
                <div class="btn-group pull-right">
                    <a class='btn btn-default' href="{$edit_url nofilter}=tab_id" title="{l s='Edit' mod='anproductextratabs'}"> {* HTML, no escape necessary *}
                        <i class='icon-pencil'></i>
                        {l s='Edit' mod='anproductextratabs'}
                    </a>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{$delete_url nofilter}=tab_id" title="{l s='Delete' mod='anproductextratabs'}"> {* HTML, no escape necessary *}
                                <i class='icon-trash'></i>
                                {l s='Delete' mod='anproductextratabs'}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </td>
    </tr>
</script>
<script type="text/javascript">
    var tabs = new TabCollection(decodeURIComponent('{$anproductextratabs_theme_url|escape:'url':'UTF-8'}&ajax'));
    var template = jQuery('script#row_template').html();
    var anpt_messages = JSON.parse("{$anproductextratabs_msg|escape:'javascript':'UTF-8'}");
    var anpt_controller_url = decodeURIComponent('{$anproductextratabs_theme_url|escape:'url':'UTF-8'}&ajax');
    
    function reload_list () {
        if (tabs instanceof TabCollection) {
            tabs.clear();
        } else tabs = new TabCollection();
    }

    function generate_tab_list (data) {
        var i = 1;
        if (tabs.count()) {
            jQuery('#tab_list').html('');
            for (tabs.rewind(); tabs.valid(); tabs.next()) {
                tabs.current().position = i++;
                var tpl = template.replace(new RegExp('tab_id', 'g'), tabs.current().id)
                    .replace(new RegExp('tab_name', 'g'), tabs.current().name)
                    .replace(new RegExp('tab_position', 'g'), tabs.current().position);

                jQuery('#tab_list').append(tpl);
            }
            
            showSuccessMessage(anpt_messages.list_loaded.success);
        }
    }

    jQuery(document).ready(function () {
        {if isset($deletion_status)}
            {if $deletion_status === true}
           showSuccessMessage(anpt_messages.delete.success);
           {else}
           showErrorMessage(anpt_messages.delete.error);
           {/if}
        {/if}

        {if isset($insertion_status)}
            {if $insertion_status === true}
           showSuccessMessage(anpt_messages.create.success);
           {else}
           showErrorMessage(anpt_messages.create.error);
           {/if}
        {/if}

        {if isset($update_status)}
            {if $update_status === true}
           showSuccessMessage(anpt_messages.update.success);
           {else}
           showErrorMessage(anpt_messages.update.error);
           {/if}
        {/if}

        {if ($collection->count() > 0)}
        (function () {
            {foreach from=$collection item=tab}
            tabs.push(new Tab({$tab->id|intval}, {$tab->id_shop|intval}, "{$tab->name|escape:'htmlall':'UTF-8'}", {$tab->position|intval}));
            {/foreach}
            generate_tab_list();
        })();
        {/if}

        (function () {
            var items_table = document.getElementById('tab_list');
            var video_list_{$language.id_lang|intval} = new Sortable(items_table, {
                group: "name",
                sort: true,
                delay: 0,
                disabled: false,
                draggable: 'tr',
                handle: '.move-handle',
                store: null,
                animation: 150,

                setData: function (dataTransfer, dragEl) {
                    dataTransfer.setData('Text', dragEl.textContent);
                },

                onStart: function(event) {

                },

                onEnd: function (event) {

                },

                onSort: function (evt) {
                    tabs.change_sorting(evt.oldIndex, evt.newIndex, function () {
                        setTimeout(function () {
                            tabs.update_order(function (response) {
                                if (response.success === true) {
                                    showSuccessMessage(anpt_messages.update_order.success);
                                } else {
                                    showErrorMessage(anpt_messages.std.error);
                                }
                            });
                        }, 500);
                    });
                    generate_tab_list();
                }
            });
        })();
    });
</script>

<div class='panel col-lg-12'>
    <div class='panel-heading'>
        {l s='Tabs list' mod='anproductextratabs'}
        <span class="panel-heading-action">
            <a class="list-toolbar-btn" href="{$edit_url nofilter}"> {* HTML, no escape necessary *}
                <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{l s='Add' mod='anproductextratabs'}" data-html="true" data-placement="top">
                    <i class="process-icon-new"></i>
                </span>
            </a>
            <a class="list-toolbar-btn" href="#" onclick='return tabs.reload(function () { setTimeout(generate_tab_list, 500); }) && false'>
                <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{l s='Update' mod='anproductextratabs'}" data-html="true" data-placement="top">
                    <i class="process-icon-refresh"></i>
                </span>
            </a>
        </span>
    </div>
    <div class='table-responsive-row'>
        <table id="tab_list_table" class="table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>{l s='Tab ID' mod='anproductextratabs'}</th>
                    <th>{l s='Tab name' mod='anproductextratabs'}</th>
                    <th>{l s='Tab Position' mod='anproductextratabs'}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tab_list">
                <tr>
                    <td colspan='4'>
                        <div class='alert alert-info' style='margin-bottom: 0'>
                            {l s='Are you ready to create your first tab?' mod='anproductextratabs'}
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>{l s='Tab ID' mod='anproductextratabs'}</th>
                    <th>{l s='Tab name' mod='anproductextratabs'}</th>
                    <th>{l s='Tab Position' mod='anproductextratabs'}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="clearfix"></div>