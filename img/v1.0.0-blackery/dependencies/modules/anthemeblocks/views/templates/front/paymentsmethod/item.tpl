{if $an_staticblock->link!=''}
<a href="{$an_staticblock->link}">
{/if}
    <div class="payments-image">
        <img src="{$an_staticblock->getImageLink()}" alt="{$an_staticblock->title|escape:'htmlall':'UTF-8'}">
    </div>
    <span>{$an_staticblock->title|escape:'htmlall':'UTF-8'}<span></span>
{if $an_staticblock->link!=''}
</a>
{/if}