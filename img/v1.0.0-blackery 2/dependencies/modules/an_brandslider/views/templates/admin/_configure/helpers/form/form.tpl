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

{extends file="helpers/form/form.tpl"}

{block name="script"}
$(document).ready(function(){
    $('#menuOrderUp').click(function(e){
    	e.preventDefault();
        move(true);
    });

    $('#menuOrderDown').click(function(e){
        e.preventDefault();
        move();
    });

    $("#items").closest('form').on('submit', function(e) {
    	$("#items option").prop('selected', true);
    });

    $("#addItem").click(add);
    $("#availableItems").dblclick(add);
    $("#removeItem").click(remove);
    $("#items").dblclick(remove);

    function add()
    {
    	$("#availableItems option:selected").each(function(i) {
    		var val = $(this).val();
    		var text = $(this).text();
    		text = text.replace(/(^\s*)|(\s*$)/gi,"");
    		if (val == "PRODUCT")
    		{
    			val = prompt('{l s='Indicate the ID number for the product' mod='an_brandslider' js=1}');
    			if (val == null || val == "" || isNaN(val))
    				return;
    			text = '{l s='Product ID #' mod='an_brandslider' js=1}'+val;
    			val = "PRD"+val;
    		}
    		$("#items").append('<option value="'+val+'" selected="selected">'+text+'</option>');
            jQuery(this).remove();
    	});

    	serialize();
    	return false;
    }

    function remove()
    {
    	$("#items option:selected").each(function(i) {
            var val = $(this).val();
            var text = $(this).text();
            text = text.replace(/(^\s*)|(\s*$)/gi,"");
            
            $("#availableItems").append('<option value="'+val+'" selected="selected">'+text+'</option>');
    		$(this).remove();
    	});
    	serialize();
    	return false;
    }

    function serialize()
    {
    	var options = "";
    	
        $("#items option").each(function(i){
    		options += $(this).val()+",";
    	});

    	$("#itemsInput").val(options.substr(0, options.length - 1));
    }

    function move(up)
    {
            var tomove = $('#items option:selected');
            if (tomove.length >1)
            {
                    alert('{l s='Please select just one item' mod='an_brandslider'}');
                    return false;
            }
            if (up)
                    tomove.prev().insertAfter(tomove);
            else
                    tomove.next().insertBefore(tomove);
            serialize();
            return false;
    }
});
{/block}

{block name="input"}
    {if $input.type == 'link_choice'}
	    <div class="row">
	    	<div class="col-lg-1">
	    		<h4 style="margin-top:5px;">{l s='Change position' mod='an_brandslider'}</h4> 
                <a href="#" id="menuOrderUp" class="btn btn-default" style="font-size:20px;display:block;"><i class="icon-chevron-up"></i></a><br/>
                <a href="#" id="menuOrderDown" class="btn btn-default" style="font-size:20px;display:block;"><i class="icon-chevron-down"></i></a><br/>
	    	</div>
	    	<div class="col-lg-4">
	    		<h4 style="margin-top:5px;">{l s='Selected items' mod='an_brandslider'}</h4>
	    		{$selected_links|escape:'quotes':'UTF-8'}
	    	</div>
	    	<div class="col-lg-4">
	    		<h4 style="margin-top:5px;">{l s='Available items' mod='an_brandslider'}</h4>
	    		{$choices|escape:'quotes':'UTF-8'}
	    	</div>
	    	
	    </div>
	    <br/>
	    <div class="row">
	    	<div class="col-lg-1"></div>
	    	<div class="col-lg-4"><a href="#" id="removeItem" class="btn btn-default"><i class="icon-arrow-right"></i> {l s='Remove' mod='an_brandslider'}</a></div>
	    	<div class="col-lg-4"><a href="#" id="addItem" class="btn btn-default"><i class="icon-arrow-left"></i> {l s='Add' mod='an_brandslider'}</a></div>
	    </div>
    {elseif $input.type == 'number'}
        <div class='input-group'>
        <input type="number"
            id="{if isset($input.id)}{$input.id|intval}{else}{$input.name|escape:'htmlall':'UTF-8'}{/if}"
            name="{$input.name|escape:'htmlall':'UTF-8'}"
            class="form-control"
            onkeyup="return (function (el) {
                jQuery(el).val((parseInt(jQuery(el).val()) || 0));
                if (jQuery(el).val() < (parseInt(jQuery(el).attr('min')) || 0)) {
                    jQuery(el).val((parseInt(jQuery(el).attr('min')) || 0));
                } else if (jQuery(el).val() > (parseInt(jQuery(el).attr('max')) || 0)) {
                    jQuery(el).val((parseInt(jQuery(el).attr('max')) || 0));
                }
            })(this);"
            value="{$fields_value[$input.name]|escape:'html':'UTF-8'}"
            {if isset($input.size)} size="{$input.size|intval}"{/if}
            {if isset($input.maxchar) && $input.maxchar} data-maxchar="{$input.maxchar|intval}"{/if}
            {if isset($input.maxlength) && $input.maxlength} maxlength="{$input.maxlength|intval}"{/if}
            {if isset($input.readonly) && $input.readonly} readonly="readonly"{/if}
            {if isset($input.disabled) && $input.disabled} disabled="disabled"{/if}
            {if isset($input.autocomplete) && !$input.autocomplete} autocomplete="off"{/if}
            {if isset($input.required) && $input.required} required="required" {/if}
            {if isset($input.max)} max="{$input.max|intval}"{/if}
            {if isset($input.min)} min="{$input.min|intval}"{/if}
            {if isset($input.placeholder) && $input.placeholder} placeholder="{$input.placeholder|escape:'htmlall':'UTF-8'}"{/if} />
            {if !empty($input.suffix)}
            <span class="input-group-addon">
                {$input.suffix|escape:'htmlall':'UTF-8'}
            </span>
            {/if}
        </div>
	{else}
		{$smarty.block.parent}
    {/if}
{/block}
