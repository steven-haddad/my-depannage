{if $an_staticblock->link!=''}<a href="{$an_staticblock->link}">{/if}
<figure><img src="{$an_staticblock->getImageLink()}" alt="{$an_staticblock->title|escape:'htmlall':'UTF-8'}"></figure>
<span>{$an_staticblock->title|escape:"htmlall":"UTF-8"}</span>
{if $an_staticblock->link!=''}</a>{/if}   