<div class="notification_cookie" 
{if $an_staticblock->formdata}
    style="width: {$an_staticblock->formdata->additional_field_notification_cookie_block_width}px"
{/if}>
    <div class="notification_cookie-content">     
        {$an_staticblock->content nofilter}
        <div class="notification_cookie-action">
            {if $an_staticblock->link!=''}
            <a href="{$an_staticblock->link}" class="notification_cookie-link">{l s='Privacy policy' mod='anthemeblocks'}</a>
            {/if}
            <span class="notification_cookie-accept">{l s='Accept' mod='anthemeblocks'}<i class="material-icons">done</i></span>
        </div>
    </div>
</div>