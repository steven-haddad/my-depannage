<?php
/**
* 2019 Anvanto
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
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author Anvanto (anvantoco@gmail.com)
*  @copyright  2019 anvanto.com

*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
 */
 
class an_wishlistajaxModuleFrontController extends
 ModuleFrontController
{
	
	public function initContent()
    {
        $result = array();
        if (Tools::isSubmit('action')) {
            $actionName = Tools::getValue('action', '') . 'Action';
            if (method_exists($this, $actionName)) {
                $result = $this->$actionName();
            }
        }

        die(Tools::jsonEncode($result));
    }	
	
    public function addRemoveAction()
    {
 		if (Tools::getValue('token') != Tools::getToken(false)){
			Tools::redirect('index.php?controller=404');
		} 
		
		$return = array();

        if (!Context::getContext()->customer->isLogged()) {
			$return['error'] = 'notLogged';
			$this->context->smarty->assign('myAccount', Context::getContext()->link->getPageLink('my-account', null));	
			$return['modal'] = $this->module->display($this->module->name, 'modal.tpl');
			$this->ajaxDie(Tools::jsonEncode($return));
        }

		
		$idProduct = (int) Tools::getValue('id_product');
 		$idCustomer = (int) Context::getContext()->customer->id;
		
		$wish = new an_wish;
		
		if ($wish->issetItem($idProduct, $idCustomer)){
			//	Delete
			$wish->removeItem($idProduct, $idCustomer);
			$return['status'] = 0;
		} else {
			//	Add
			$wish->id_product = $idProduct;
			$wish->id_customer = $idCustomer;
			$wish->add();
			$return['status'] = 1;
		}
		
		$return['count'] = $wish->countProductsCustomer($idCustomer);
		$return['countWishlists'] = an_wish::countWishlistsProduct($idProduct);

		$this->ajaxDie(Tools::jsonEncode($return));
    }	
}