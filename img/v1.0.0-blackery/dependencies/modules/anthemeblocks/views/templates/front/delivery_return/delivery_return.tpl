<div class="delivery_return-sg-cover"></div>
<div class="delivery_return-sg-modal">
    <div class="an_delivery_return">
        <i class="material-icons delivery_return-sg-btn-close">clear</i>

        {$an_staticblock->content nofilter}
        {foreach from=$an_staticblock->getChildrenBlocks() item=block}
            {$block->getContent() nofilter}
        {/foreach}
    </div>
</div>
<div class="delivery_return-open-modal-btn">Delivery & return</div>


