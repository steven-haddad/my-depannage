<div class="about_us">
	<div class="about_us-img">
		{if $an_staticblock->getImageLink() != ''}
		<img src="{$an_staticblock->getImageLink()}" alt="{$an_staticblock->title|escape:'htmlall':'UTF-8'}">
		{else}
		<img src="https://via.placeholder.com/600x360" alt="{$an_staticblock->title|escape:'htmlall':'UTF-8'}">
		{/if}
	</div>
	<div class="about_us-content">
		<h2 class="about_us-title">{$an_staticblock->title|escape:'htmlall':'UTF-8'}</h2>
		<div class="about_us-text">
			{$an_staticblock->content nofilter}
		</div>
		{if $an_staticblock->link!=''}
		<div class="an_link-block">
			<a href="{$an_staticblock->link}" class="btn btn-primary">{l s='Read more' mod='anthemeblocks'}</a>
		</div>
		{/if}
	</div>
</div>

