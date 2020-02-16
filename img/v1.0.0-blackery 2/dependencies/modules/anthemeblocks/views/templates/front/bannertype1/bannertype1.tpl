{if $an_staticblock->link != ''}
<a class="banner-t0-link" href="{$an_staticblock->link}">
{/if}
<div class="banner-t0">
  {if $an_staticblock->getImageLink() != ''}
		<img src="{$an_staticblock->getImageLink()}" alt="{$an_staticblock->title|escape:'htmlall':'UTF-8'}">
		{else}
		<img src="https://via.placeholder.com/255x400" alt="{$an_staticblock->title|escape:'htmlall':'UTF-8'}">
		{/if}
  <div class="banner-t0-desc">
		<h2>{$an_staticblock->title|escape:'htmlall':'UTF-8'}</h2>
	</div>
</div>
{if $an_staticblock->link != ''}
</a>
{/if}
