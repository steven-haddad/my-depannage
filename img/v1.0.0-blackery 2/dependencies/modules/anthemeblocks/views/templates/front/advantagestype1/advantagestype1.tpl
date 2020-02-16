{$param['count'] = count($an_staticblock->getChildrenBlocks())}
<div class="advantages-box" {if $an_staticblock->getImageLink() != ''} style="background: url({$an_staticblock->getImageLink()}); background-size: cover;" {/if}>
  <div class="advantages-type-1 {if $an_staticblock->formdata and $an_staticblock->formdata->additional_field_advantagestype1_canteredimage == '1'} advantages-type-1-center{/if}">
    
    {foreach from=$an_staticblock->getChildrenBlocks() item=block}
      {$block->getContent($param) nofilter}
    {/foreach}
  </div>
</div>

