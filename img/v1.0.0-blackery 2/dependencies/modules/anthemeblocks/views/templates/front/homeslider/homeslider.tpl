<div class="anthemeblocks_homeslider-block  {if $an_staticblock->formdata && $an_staticblock->formdata->additional_field_homeslider_mobile=='0'}  anthemeblocks-homeslider-hide-mobile{/if}">
	<div class="anthemeblocks-homeslider {if $an_staticblock->formdata->additional_field_homeslider_preloader =='0'}owl-carousel{/if} {if $an_staticblock->formdata} anthemeblocks-homeslider_{$an_staticblock->formdata->additional_field_homeslider_textpostion} owl-dots_{$an_staticblock->formdata->additional_field_homeslider_dots}{/if} owl-theme{if $an_staticblock->formdata && $an_staticblock->formdata->additional_field_homeslider_mobile=='0'}  anthemeblocks-homeslider-hide-mobile{/if}" id="anthemeblocks-homeslider_{$an_staticblock->id}" {if $an_staticblock->formdata} data-items="{$an_staticblock->formdata->additional_field_homeslider_items}" data-nav="{$an_staticblock->formdata->additional_field_homeslider_nav}" data-loop="{$an_staticblock->formdata->additional_field_homeslider_loop}"   data-autoplay="{$an_staticblock->formdata->additional_field_homeslider_autoplay}" data-autoplaytimeout="{$an_staticblock->formdata->additional_field_homeslider_autoplayTimeout}" data-smartspeed="{$an_staticblock->formdata->additional_field_homeslider_smartSpeed}"{/if}>

	{foreach from=$an_staticblock->getChildrenBlocks() item=block}
		<div class="item">{$block->getContent() nofilter}</div>
	{/foreach}

	</div>

	{if $an_staticblock->formdata}
        {if $an_staticblock->formdata->additional_field_homeslider_preloader}
        <div class="anthemeblocks-homeslider-loader">
            <div class="loader-dots">
                <div class="loader-image"></div>
            </div>
        </div>
        {/if}
    {/if}
</div>