{if $an_staticblock->link!=''}
<a href="{$an_staticblock->link}">
{/if}
	{if $an_staticblock->getImageLink() != ''}
		<img src="{$an_staticblock->getImageLink()}" alt="{$an_staticblock->title|escape:'htmlall':'UTF-8'}">
		{else}
		<img src="https://via.placeholder.com/1920x800" alt="{$an_staticblock->title|escape:'htmlall':'UTF-8'}">
		{/if}
	<div class="anthemeblocks-homeslider-desc">
		<div class="container">
			<h2>{$an_staticblock->title|escape:'htmlall':'UTF-8'}</h2>
			{$an_staticblock->content nofilter}
			{if $an_staticblock->link!='' and $an_staticblock->formdata->additional_field_item_button == 0}
			<button class="btn btn-primary">{l s='Shop now' mod='anthemeblocks'}</button>
			{/if}
		</div>
	</div>
{if $an_staticblock->link != '' }
</a>
{/if}