<div class="anthemeblocks-newsslider-title">
	<h3>{$an_staticblock->title|escape:'htmlall':'UTF-8'}</h3>
</div>
<div class="anthemeblocks-newsslider owl-dots_disabled owl-carousel owl-theme{if $an_staticblock->formdata && $an_staticblock->formdata->additional_field_newsslider_mobile=='0'}  anthemeblocks-newsslider-hide-mobile{/if}" id="anthemeblocks-newsslider_{$an_staticblock->id}" {if $an_staticblock->formdata} data-items="{$an_staticblock->formdata->additional_field_newsslider_items}" data-nav="{$an_staticblock->formdata->additional_field_newsslider_nav}" data-loop="{$an_staticblock->formdata->additional_field_newsslider_loop}"   data-autoplay="{$an_staticblock->formdata->additional_field_newsslider_autoplay}" data-autoplaytimeout="{$an_staticblock->formdata->additional_field_newsslider_autoplayTimeout}" data-smartspeed="{$an_staticblock->formdata->additional_field_newsslider_smartSpeed}"{/if}>
{foreach from=$an_staticblock->getChildrenBlocks() item=block}
	<div class="item">{$block->getContent() nofilter}</div>
{/foreach}
</div>