<div class="anthemeblocks-footer-payments-wrap col-md-2 links wrapper">
    <div class="title clearfix hidden-md-up" data-target="#footer_payment" data-toggle="collapse">
        <span class="h3">{$an_staticblock->title|escape:'htmlall':'UTF-8'}</span>
        <span class="float-xs-right">
            <span class="navbar-toggler collapse-icons">
            <i class="material-icons add">&#xE313;</i>
            <i class="material-icons remove">&#xE316;</i>
            </span>
        </span>
    </div>
    <h3 class="h3 hidden-sm-down">{$an_staticblock->title|escape:'htmlall':'UTF-8'}</h3>
    <ul id="footer_payment" class="anthemeblocks-footer-payments collapse" >
    {foreach from=$an_staticblock->getChildrenBlocks() item=block}
    <li>{$block->getContent() nofilter}</li>
    {/foreach}
    </ul>
</div>