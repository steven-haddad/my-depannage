{if $an_staticblock->formdata}
<div class="visitors-block"
data-min-value="{$an_staticblock->formdata->additional_field_real_time_visitor_counter_minValue}"
data-max-value="{$an_staticblock->formdata->additional_field_real_time_visitor_counter_maxValue}"
data-stroke-value="{$an_staticblock->formdata->additional_field_real_time_visitor_counter_strokeValue}"
data-min-interval="{$an_staticblock->formdata->additional_field_real_time_visitor_counter_minInterval}"
data-max-interval="{$an_staticblock->formdata->additional_field_real_time_visitor_counter_maxInterval}"
>
    <div class="visitors-block-text">
        <svg 
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        width="19px" height="11px">
        <path fill-rule="evenodd"  fill="rgb(7, 7, 7)"
        d="M9.093,0.000 C5.653,0.000 2.533,1.929 0.231,5.062 C0.043,5.319 0.043,5.677 0.231,5.934 C2.533,9.071 5.653,11.000 9.093,11.000 C12.533,11.000 15.653,9.071 17.955,5.938 C18.143,5.681 18.143,5.322 17.955,5.066 C15.653,1.929 12.533,0.000 9.093,0.000 ZM9.340,9.373 C7.056,9.520 5.170,7.591 5.314,5.247 C5.432,3.314 6.960,1.748 8.846,1.627 C11.130,1.480 13.016,3.409 12.872,5.753 C12.751,7.682 11.222,9.248 9.340,9.373 ZM9.226,7.584 C7.995,7.663 6.979,6.625 7.060,5.364 C7.122,4.322 7.947,3.481 8.964,3.413 C10.194,3.333 11.211,4.371 11.130,5.632 C11.064,6.678 10.239,7.520 9.226,7.584 Z"/>
        </svg>
        <span class="visitors-counter">{$an_staticblock->formdata->additional_field_real_time_visitor_counter_minValue}</span>
        
    </div>
</div>
{/if}