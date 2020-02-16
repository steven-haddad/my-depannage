{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
<div id="_desktop_contact_link">
  <div id="contact-link">
    {if $contact_infos.phone}
    <span>
        {* [1][/1] is for a HTML tag. *}
        <svg 
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        width="16px" height="15px">
       <path fill-rule="evenodd"  fill="#333333"
        d="M15.305,11.838 C15.337,12.081 15.263,12.294 15.083,12.474 L12.971,14.571 C12.876,14.677 12.751,14.767 12.598,14.841 C12.444,14.915 12.293,14.963 12.145,14.984 C12.135,14.984 12.103,14.987 12.050,14.992 C11.997,14.997 11.928,15.000 11.843,15.000 C11.642,15.000 11.317,14.966 10.867,14.897 C10.417,14.828 9.866,14.658 9.215,14.388 C8.564,14.118 7.826,13.713 7.000,13.173 C6.174,12.633 5.296,11.891 4.364,10.948 C3.623,10.217 3.009,9.518 2.522,8.851 C2.035,8.183 1.643,7.566 1.347,7.000 C1.051,6.433 0.828,5.919 0.680,5.458 C0.532,4.997 0.431,4.600 0.379,4.267 C0.326,3.933 0.304,3.670 0.315,3.480 C0.326,3.289 0.331,3.183 0.331,3.162 C0.352,3.014 0.400,2.863 0.474,2.710 C0.548,2.556 0.638,2.431 0.744,2.336 L2.856,0.223 C3.004,0.074 3.173,0.000 3.364,0.000 C3.501,0.000 3.623,0.040 3.729,0.119 C3.835,0.199 3.925,0.297 3.999,0.413 L5.698,3.639 C5.793,3.808 5.820,3.994 5.777,4.195 C5.735,4.396 5.645,4.566 5.508,4.703 L4.729,5.482 C4.708,5.503 4.690,5.538 4.674,5.585 C4.658,5.633 4.650,5.673 4.650,5.704 C4.692,5.927 4.788,6.181 4.936,6.467 C5.063,6.721 5.259,7.031 5.523,7.397 C5.788,7.762 6.164,8.183 6.651,8.660 C7.127,9.147 7.551,9.526 7.921,9.796 C8.292,10.066 8.601,10.265 8.850,10.392 C9.099,10.519 9.289,10.596 9.422,10.623 L9.620,10.662 C9.641,10.662 9.676,10.654 9.723,10.638 C9.771,10.623 9.806,10.604 9.827,10.583 L10.732,9.661 C10.922,9.492 11.145,9.407 11.399,9.407 C11.579,9.407 11.722,9.439 11.827,9.502 L11.843,9.502 L14.908,11.313 C15.130,11.451 15.263,11.626 15.305,11.838 Z"/>
       </svg>
          {l
            s='[1]%phone%[/1]'
            sprintf=[
              '[1]' => '<a href="mailto:'|cat:$contact_infos.phone|cat:'" class="dropdown">',
              '[/1]' => '</a>',
              '%phone%' => $contact_infos.phone
            ]
            d='Shop.Theme.Global'
          }
    </span>
    {else}
      <a href="{$urls.pages.contact}">{l s='Contact us' d='Shop.Theme.Global'}</a>
    {/if}
  </div>
</div>
