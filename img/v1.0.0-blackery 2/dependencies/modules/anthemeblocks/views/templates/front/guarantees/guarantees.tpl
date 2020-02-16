<div class="checkout-guarantee">
    <div class="checkout-guarantee-block">
        <span>{$an_staticblock->title|escape:'htmlall':'UTF-8'}</span>
         {if $an_staticblock->getImageLink() != ''}
            <img src="{$an_staticblock->getImageLink()}" alt="{$an_staticblock->title|escape:'htmlall':'UTF-8'}">
         {/if}
	</div>

</div>

