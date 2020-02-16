<?php
/**
 * 2007-2019 PrestaShop
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
 * @author    Anvanto <anvantoco@gmail.com>
 * @copyright 2007-2019 Anvanto
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface; 

require_once _PS_MODULE_DIR_ . 'an_wishlist/classes/an_wish.php';
require_once _PS_MODULE_DIR_ . 'an_wishlist/classes/an_wishListing.php';

class an_wishlist extends Module implements WidgetInterface
{
    const PREFIX = 'an_wishlist_';

    public function __construct()
    {
        $this->name = 'an_wishlist';
        $this->tab = 'others';
        $this->version = '1.0.0';
        $this->author = 'Anvanto';
        $this->need_instance = 1;
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->bootstrap = true;
        $this->module_key = '';

        parent::__construct();

        $this->displayName = $this->l('AN Wishlist');
        $this->description = $this->l('');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall the module?');
        $this->controllers = array('ajax', 'list');
    }

    /**
     * @return bool
     */
    public function install()
    {
        Configuration::updateValue(self::PREFIX.'display_likes_product_mini', 1);
		Configuration::updateValue(self::PREFIX.'display_likes_product', 1);
		Configuration::updateValue(self::PREFIX.'display_likes_nav', 1);
		Configuration::updateValue(self::PREFIX.'display_wishlist_in_cart', 1);
	
		if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
		
		$res = (bool)Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'an_wishlist` (
            `id_an_wishlist` int(10) NOT NULL auto_increment,
            `id_product` int(10) unsigned NOT NULL,
            `id_product_attribute` int(10) unsigned NOT NULL,
            `id_customer` int(10) unsigned NOT NULL,
            `id_shop` int(10) unsigned NOT NULL,
			`date_add` datetime NOT NULL,
            PRIMARY KEY  (`id_an_wishlist`, `id_product` ,`id_product_attribute`, `id_customer`, `id_shop`)
		) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET = utf8');
		
		
        if (!parent::install() ||
			!$this->registerHook('header') ||
            !$this->registerHook('displayNav2') ||
			!$this->registerHook('displayProductAdditionalInfo') ||
			!$this->registerHook('displayProductListReviews') ||
			!$this->registerHook('customerAccount') ||
			!$this->registerHook('displayShoppingCartFooter') ||
			
			!$this->registerHook('registerGDPRConsent') ||
			!$this->registerHook('actionDeleteGDPRCustomer') ||
			!$this->registerHook('actionExportGDPRData') ||
			
			!$res
        ) {
            return false;
        }

        return true;
    }

    /**	
     * @return bool
     */
    public function uninstall()
    {
        $paramList = $this->getParamList();
        $this->deleteParams($paramList);
		
		$res = (bool)Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'an_wishlist`');
		
        if ($res) {
            return parent::uninstall() ||
            !$this->unregisterHook('header') ||
            !$this->unregisterHook('displayNav2') ||
            !$this->unregisterHook('displayProductAdditionalInfo') ||
            !$this->unregisterHook('displayProductListReviews') ||
            !$this->unregisterHook('customerAccount') ||
			
			!$this->unregisterHook('registerGDPRConsent') ||
			!$this->unregisterHook('actionDeleteGDPRCustomer') ||
			!$this->unregisterHook('actionExportGDPRData') ||			
			
            !$this->unregisterHook('displayShoppingCartFooter');
        }
        return false;
    }
    /**
     * @param $key
     * @param null $value
     * @param null $id_lang
     * @return bool|string
     */
    public static function getParam($key, $value = null, $id_lang = null)
    {
        return $value === null ? Configuration::get(
            self::PREFIX . $key,
            $id_lang
        ) : Configuration::updateValue(self::PREFIX . $key, $value);
    }

    public function getParamList()
    {
        return array(
            'display_likes_product_mini',
			'display_likes_product',	
			'display_likes_nav',
			'display_wishlist_in_cart',
        );
    }
	
    protected function deleteParams($keys)
    {
        foreach ($keys as $key) {
            $this->deleteParam($key);
        }
    }

    protected function deleteParam($key)
    {
        return Configuration::deleteByName(self::PREFIX.$key);
    }	
	
    protected function updateParam($key, $value)
    {
        return Configuration::updateValue(self::PREFIX.$key, $value);
    }
	
	public function getConfig(){
		$config = array();
		$paramList = $this->getParamList();
		foreach ($paramList as $key) {
			$config[$key] = $this->getParam($key);
		}
		return $config;
	}	

    /**
     *
     */
    public function hookHeader()
    {
		$this->context->controller->addJquery();
		$this->context->controller->registerStylesheet(
			"anwishcss",
			'modules/' . $this->name . '/views/css/front.css',
			array('server' => 'local', 'priority' => 150)
		);
		$this->context->controller->registerJavascript(
			"anwishjs",
			'modules/' . $this->name . '/views/js/front.js',
			array('server' => 'local', 'priority' => 150)
		);
		
		if (!Context::getContext()->customer->isLogged()) {
			$this->context->controller->registerStylesheet(
				"anwishcss2",
				'modules/' . $this->name . '/views/css/magnific-popup.css',
				array('server' => 'local', 'priority' => 150)
			);
			$this->context->controller->registerJavascript(
				"anwishjs2",
				'modules/' . $this->name . '/views/js/jquery.magnific-popup.min.js',
				array('server' => 'local', 'priority' => 150)
			);		
		}
    }

    public function hookCustomerAccount($params)
    {
        return $this->display(__FILE__, '/views/templates/front/my-account-link.tpl');
    }
	
    public function hookdisplayShoppingCartFooter($params)
    {
		$products = an_wish::getProductsWishlist((int) Context::getContext()->customer->id);
		
		$listing = new an_wishListing();
		$products =  $listing->prepare($products);
		
		$this->context->smarty->assign('products', $products);
		
		return $this->display(__FILE__, '/views/templates/front/shoppingCartFooter.tpl');
    }	
	
    /**
     * @param $hookName
     * @param array $params
     * @return mixed|void
     */
    public function renderWidget($hookName = null, array $params)
    {
		$this->smarty->assign($this->getWidgetVariables($hookName, $params));
		
		$tplFile = 'nav.tpl';
		
		$this->smarty->assign('an_wishlistAjax', Context::getContext()->link->getModuleLink('an_wishlist', 'ajax', [], true));	
		
		if (preg_match('/^displayNav\d*$/', $hookName)){
			$tplFile = 'nav.tpl';
		} elseif ($hookName == 'displayProductAdditionalInfo'){			
			$tplFile = 'product.tpl';
		} elseif ($hookName == 'displayProductListReviews'){
			$tplFile = 'product-miniature.tpl';
		}
		
		return $this->fetch('module:an_wishlist/views/templates/front/' . $tplFile);
    }
    /**
     * @param $hookName
     * @param array $params
     * @return array
     */
    public function getWidgetVariables($hookName, array $params)
    {
		
        $return = array(
			'hook' => $hookName,
			'token' => Tools::getToken(false),
		);
		
		if (preg_match('/^displayNav\d*$/', $hookName)){
			$return['count'] = an_wish::countProductsCustomer((int) Context::getContext()->customer->id);
		}
		
		if ($hookName == 'displayProductAdditionalInfo' | $hookName == 'displayProductListReviews'){
			$return['id_product'] = $params['smarty']->tpl_vars['product']->value['id_product'];
			$return['status'] = an_wish::issetItem($return['id_product'], (int) Context::getContext()->customer->id);
			$return['countWishlists'] = an_wish::countWishlistsProduct($return['id_product']);			
		}
		
		$return['config'] = $this->getConfig();

		return $return;
    }
	
    public function hookActionDeleteGDPRCustomer($customer)
    {
         if (!empty($customer['id'])) {
            $sql = "DELETE FROM "._DB_PREFIX_."an_wishlist WHERE id_customer = '".(int)$customer['id']."'";
            if (Db::getInstance()->execute($sql)) {
                return json_encode(true);
            }
        } 
    }

    public function hookActionExportGDPRData($customer)
    {
         if (!empty($customer['id'])) {
            $sql = "SELECT id_product FROM "._DB_PREFIX_."an_wishlist WHERE id_customer = '".(int)$customer['id']."'";
            if ($res = Db::getInstance()->executeS($sql)) {

                $pIds = array();
                foreach ($res as $val) {
                    $pIds[] = $val['id_product'];
                }
                $productsIds = implode(",",  $pIds);

                $sql = 'SELECT p.`id_product` as "Id", p.`reference`, pl.`name`
		        FROM `'._DB_PREFIX_.'product` p
		        '.Shop::addSqlAssociation('product', 'p').'
		        LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = '.(int)$this->context->language->id.Shop::addSqlRestrictionOnLang('pl').')
		        WHERE p.id_product IN ('.$productsIds.')';

                $items = Db::getInstance()->executeS($sql);

                return json_encode($items);
            }
        } 
    }	

	
    public function getContent()
    {		

	        // TOP Products
		$wish = new an_wish;
		$topProducts = $wish->getTopProducts();
		
		foreach ($topProducts as $key => $product){
			 $id_image = Product::getCover($product['id_image']);
			 
             $image = new Image($id_image);
             $image = Context::getContext()->link->getImageLink($product['link_rewrite'], $product['id_image'], ImageType::getFormattedName('cart'));
			 $topProducts[$key]['image'] = $image;
		}
		
		$this->context->smarty->assign('topProducts', $topProducts);	 

		$output = null;

        if (Tools::isSubmit('submit'.$this->name)) {
            $output = $this->getSubmitOutput();
        }

        return $this->display(__FILE__, 'views/templates/admin/config_top.tpl').$output.$this->displayForm().$this->display(__FILE__, 'views/templates/admin/config_footer.tpl');

    }	
	
    protected function getSubmitOutput()
    {
        $params = array();
        $paramList = $this->getParamList();

        foreach ($paramList as $key) {
            $params[$key] = Tools::getValue(self::PREFIX.$key);
        } 
 
        foreach ($paramList as $key) {
            $this->updateParam($key, $params[$key]);
        } 

        return $this->displayConfirmation($this->l('Settings updated'));
    }


    public function displayForm()
    {

		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $fields_form = array();

        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Settings'),
            ),
            'input' => array(
			
                array(
                    'type' => 'switch',
                    'label' => $this->l('Number of adding to wishlists (product miniature)'),
                    'name' => self::PREFIX.'display_likes_product_mini',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'is_enabled_on',
                            'value' => 1
                        ),
                        array(
                            'id' => 'is_enabled_off',
                            'value' => 0
                        )
                    ),
                ),	

                array(
                    'type' => 'switch',
                    'label' => $this->l('Number of adding to wishlists (product page)'),
                    'name' => self::PREFIX.'display_likes_product',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'is_enabled_on',
                            'value' => 1
                        ),
                        array(
                            'id' => 'is_enabled_off',
                            'value' => 0
                        )
                    ),
                ),				

                array(
                    'type' => 'switch',
                    'label' => $this->l('Number of items in the wishlist (navigation bar)'),
                    'name' => self::PREFIX.'display_likes_nav',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'is_enabled_on',
                            'value' => 1
                        ),
                        array(
                            'id' => 'is_enabled_off',
                            'value' => 0
                        )
                    ),
                ),	

                array(
                    'type' => 'switch',
                    'label' => $this->l('Wishlist products in the cart'),
                    'name' => self::PREFIX.'display_wishlist_in_cart',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'is_enabled_on',
                            'value' => 1
                        ),
                        array(
                            'id' => 'is_enabled_off',
                            'value' => 0
                        )
                    ),
                ),
				
            ),
            'submit' => array(
                'title' => $this->l('Save'),
            )
        );	

        $helper = new HelperForm();

        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;

        $helper->title = $this->displayName;
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = array(
            'save' =>
                array(
                    'desc' => $this->l('Save'),
                    'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                        '&token='.Tools::getAdminTokenLite('AdminModules'),
                ),
            'back' => array(
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            )
        );

        $paramList = $this->getParamList();

        foreach ($paramList as $key) {
            $helper->fields_value[self::PREFIX.$key] = $this->getParam($key);
        } 

        return $helper->generateForm($fields_form);
    }
}
