{**
* 2007-2018 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
*         DISCLAIMER   *
* Do not edit or add to this file if you wish to upgrade Prestashop to newer
* versions in the future.
* ****************************************************
*
*  @author     Anvanto (anvantoco@gmail.com)
*  @copyright  anvanto.com
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

var an_brandslider_params = JSON.parse("{$an_slider_options|escape:'javascript':'UTF-8'}");
{if version_compare($smarty.const._PS_VERSION_, '1.7.0.0', '<')}
an_brandslider_params['navText'] = ['<i class="an_brandslider-icon an_brandslider-icon-prev"></i>','<i class="an_brandslider-icon an_brandslider-icon-next"></i>'];
{else}
an_brandslider_params['navText'] = ['<i class="material-icons">&#xE314;</i>','<i class="material-icons">&#xE315;</i>'];
{/if}
an_brandslider_params['navContainer'] = '.an_brandslider-items .owl-stage-outer';
$(document).ready(function(){ $('.an_brandslider-items').owlCarouselAnBS(an_brandslider_params); });