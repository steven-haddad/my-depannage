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
 
 <div class="block-contact links wrapper">
   
   <div class="title clearfix hidden-md-up" data-target="#footer_contact_info" data-toggle="collapse">
      <span class="h3">{l s='Contacts' d='Shop.Theme.Global'}</span>
      <span class="float-xs-right">
        <span class="navbar-toggler collapse-icons">
          <i class="material-icons add">&#xE313;</i>
          <i class="material-icons remove">&#xE316;</i>
        </span>
      </span>
  </div>
 
  <ul id="footer_contact_info" class="collapse">
    
    {if $contact_infos.phone}
    <li>
      {* [1][/1] is for a HTML tag. *}
      <svg 
      xmlns="http://www.w3.org/2000/svg"
      xmlns:xlink="http://www.w3.org/1999/xlink"
      width="13px" height="12px">
      <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
      d="M12.306,9.470 C12.332,9.665 12.273,9.834 12.129,9.979 L10.439,11.657 C10.363,11.741 10.263,11.814 10.141,11.873 C10.018,11.932 9.897,11.970 9.779,11.987 C9.770,11.987 9.745,11.990 9.702,11.994 C9.660,11.998 9.605,12.000 9.537,12.000 C9.376,12.000 9.116,11.972 8.756,11.918 C8.396,11.862 7.956,11.727 7.435,11.511 C6.914,11.294 6.323,10.970 5.663,10.538 C5.002,10.106 4.299,9.513 3.554,8.758 C2.961,8.174 2.470,7.614 2.080,7.081 C1.691,6.547 1.377,6.053 1.140,5.600 C0.903,5.146 0.725,4.735 0.607,4.367 C0.488,3.998 0.408,3.680 0.365,3.413 C0.323,3.146 0.306,2.936 0.314,2.784 C0.323,2.631 0.327,2.547 0.327,2.530 C0.344,2.411 0.382,2.290 0.441,2.167 C0.501,2.044 0.573,1.945 0.658,1.869 L2.347,0.178 C2.466,0.059 2.601,0.000 2.754,0.000 C2.864,0.000 2.961,0.032 3.046,0.095 C3.130,0.159 3.202,0.237 3.262,0.331 L4.621,2.911 C4.697,3.046 4.718,3.195 4.684,3.356 C4.651,3.517 4.579,3.653 4.468,3.762 L3.846,4.386 C3.829,4.403 3.814,4.430 3.802,4.468 C3.789,4.506 3.782,4.538 3.782,4.564 C3.816,4.742 3.893,4.945 4.011,5.174 C4.113,5.377 4.269,5.625 4.481,5.917 C4.693,6.210 4.994,6.547 5.383,6.928 C5.764,7.318 6.103,7.621 6.399,7.837 C6.696,8.053 6.944,8.212 7.143,8.313 C7.342,8.415 7.494,8.476 7.600,8.498 L7.759,8.530 C7.776,8.530 7.803,8.523 7.841,8.511 C7.879,8.498 7.907,8.483 7.924,8.466 L8.648,7.729 C8.800,7.593 8.978,7.526 9.182,7.526 C9.326,7.526 9.440,7.551 9.525,7.601 L9.537,7.601 L11.989,9.051 C12.167,9.161 12.273,9.301 12.306,9.470 Z"/>
      </svg>
      {l s='[1]%phone%[/1]'
        sprintf=[
        '[1]' => '<a href="tel:'|cat:$contact_infos.phone|cat:'">',
        '[/1]' => '</a>',
        '%phone%' => $contact_infos.phone
        ]
        d='Shop.Theme.Global'
      }
    </li>
    {/if}

    {if $contact_infos.address.address1}
    <li>
      {* [1][/1] is for a HTML tag. *}
      <svg 
      xmlns="http://www.w3.org/2000/svg"
      xmlns:xlink="http://www.w3.org/1999/xlink"
      width="10px" height="13px">
     <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
      d="M5.000,0.000 C2.243,0.000 0.000,2.300 0.000,5.128 C0.000,5.865 0.147,6.569 0.437,7.221 C1.687,10.026 4.084,12.059 4.789,12.900 C4.842,12.963 4.919,12.999 5.000,12.999 C5.081,12.999 5.158,12.963 5.211,12.900 C5.916,12.060 8.312,10.027 9.563,7.221 C9.853,6.569 10.000,5.865 10.000,5.128 C10.000,2.300 7.757,0.000 5.000,0.000 ZM5.000,7.791 C3.568,7.791 2.403,6.596 2.403,5.128 C2.403,3.659 3.568,2.464 5.000,2.464 C6.432,2.464 7.597,3.659 7.597,5.128 C7.597,6.596 6.432,7.791 5.000,7.791 Z"/>
     </svg>
      {l
        s='[1]%city% %address%[/1]'
        sprintf=[
          '[1]' => '<a href="#">',
          '[/1]' => '</a>',
          '%city%' => $contact_infos.address.city,
          '%address%' => $contact_infos.address.address1
        ]
        d='Shop.Theme.Global'
      }
    </li>
    
    
    {/if}
    {if $contact_infos.fax}
    <li>
      {* [1][/1] is for a HTML tag. *}
      {l
        s='Fax: [1]%fax%[/1]'
        sprintf=[
          '[1]' => '<span>',
          '[/1]' => '</span>',
          '%fax%' => $contact_infos.fax
        ]
        d='Shop.Theme.Global'
      }
    </li>
    {/if}
    {if $contact_infos.email}
    <li>
    {* [1][/1] is for a HTML tag. *}
    <svg 
    xmlns="http://www.w3.org/2000/svg"
    xmlns:xlink="http://www.w3.org/1999/xlink"
    width="12px" height="9px">
    <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
    d="M12.000,7.500 C12.000,7.763 11.926,8.007 11.807,8.221 L8.019,3.982 L11.766,0.703 C11.912,0.935 12.000,1.206 12.000,1.500 L12.000,7.500 ZM6.000,4.752 L11.215,0.189 C11.001,0.072 10.760,-0.000 10.500,-0.000 L1.500,-0.000 C1.240,-0.000 0.999,0.072 0.786,0.189 L6.000,4.752 ZM7.454,4.476 L6.247,5.533 C6.176,5.594 6.088,5.625 6.000,5.625 C5.912,5.625 5.824,5.594 5.753,5.533 L4.546,4.476 L0.709,8.769 C0.939,8.914 1.208,9.000 1.500,9.000 L10.500,9.000 C10.792,9.000 11.061,8.914 11.291,8.769 L7.454,4.476 ZM0.234,0.703 C0.088,0.935 -0.000,1.206 -0.000,1.500 L-0.000,7.500 C-0.000,7.763 0.074,8.007 0.193,8.221 L3.981,3.982 L0.234,0.703 Z"/>
    </svg>
    {l
      s='[1]%email%[/1]'
      sprintf=[
        '[1]' => '<a href="mailto:'|cat:$contact_infos.email|cat:'" class="dropdown">',
        '[/1]' => '</a>',
        '%email%' => $contact_infos.email
      ]
      d='Shop.Theme.Global'
    }
    </li>
    {/if}
   
    
    </ul>
    {hook h='displaySocialLinks'}
 </div>
 