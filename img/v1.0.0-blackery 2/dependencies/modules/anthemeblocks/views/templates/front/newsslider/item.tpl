{if $an_staticblock->link!=''}
<a href="{$an_staticblock->link}">
{/if}
	{if $an_staticblock->getImageLink() != ''}
	<img src="{$an_staticblock->getImageLink()}" alt="{$an_staticblock->title|escape:'htmlall':'UTF-8'}">
	{else}
	<img src="https://via.placeholder.com/540x400" alt="{$an_staticblock->title|escape:'htmlall':'UTF-8'}">
	{/if}
	<div class="anthemeblocks-newsslider-desc">
		<h2>
			{$an_staticblock->content nofilter}
		</h2>
	</div>
{if $an_staticblock->link != '' }
</a>
{/if}