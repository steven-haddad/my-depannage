{if $an_staticblock->link != ''}
<a href="{$an_staticblock->link}" class="advantages-type-1-link">
	{/if}
	<div class="advantages-type-1-item {if $an_staticblock->param['count'] > 3} advantages-type-1-item-fixd_w {/if}">
		{if $an_staticblock->getImageLink() != ''}
		<div class="advantages-img-wrapper">
			<img class="advantages-type-1-img" src="{$an_staticblock->getImageLink()}" alt="{$an_staticblock->title|escape:'htmlall':'UTF-8'}" />
		</div>
		{/if}
		<div class="advantages-type-1-desc">
			<h2 class="advantages-type-1-title">{$an_staticblock->title|escape:'htmlall':'UTF-8'}</h2>
			{$an_staticblock->content nofilter}
		</div>
	</div>
	{if $an_staticblock->link != ''}
</a>
{/if}

