
<div class="col-md-4 wrapper">
	<a class="logo_slogan-link" href="{$urls.base_url}">
		{if $an_staticblock->getImageLink() != ''}
		<div class="logo_slogan-img">
			<img src="{$an_staticblock->getImageLink()}" alt="">
		</div>
		{else}
		<div class="logo_slogan-img">
			<img src="https://via.placeholder.com/120x60" alt="{$an_staticblock->title|escape:'htmlall':'UTF-8'}">
		</div>
		{/if}
	
	</a>
	<div class="logo_slogan-content">
		{$an_staticblock->content nofilter}
	</div>
	{hook h='displayLogoAfter'}
</div>

