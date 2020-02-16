<section class="anthemeblocks-products-columns products-columns">
{foreach from=$an_staticblock->getChildrenBlocks() item=block}
<div class="column-products">
	{$block->getContent() nofilter}
</div>
{/foreach}
</section>