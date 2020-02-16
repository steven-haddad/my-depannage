<div class="sg-cover"></div>
<div class="sg-modal">
    <div class="an_sizeguide">
        <i class="material-icons sg-btn-close">clear</i>
        <h3 class="sizeguide-title">{$an_staticblock->title|escape:'htmlall':'UTF-8'}</h3>
        {$an_staticblock->content nofilter}
        {foreach from=$an_staticblock->getChildrenBlocks() item=block}
            {$block->getContent() nofilter}
        {/foreach}
    </div>
</div>
<div class="open-modal-btn">Size Guide</div>


