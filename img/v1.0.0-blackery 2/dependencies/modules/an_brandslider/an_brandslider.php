<?php
/**
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
 */

// @codingStandardsIgnoreStart
if (!defined('_PS_VERSION_')) {
    exit;
}
// @codingStandardsIgnoreEnd

// @codingStandardsIgnoreStart
class an_brandslider extends Module
// @codingStandardsIgnoreEnd
{
    const SALT = 'aLko';
    const PREFIX = 'anb_';
    const DO_SHOW_TITLE = 'AN_BRANDSLIDER_SHOW_BLOCK_TITLE';
    const TITLE = 'AN_BRANDSLIDER_TITLE';
    const MANUFACTURERS = 'AN_MANUFACTURERS_LIST';
    const MANUFACTURERS_FRONT = 'items';
    const JS_FILE = 'AN_BRANDSLIDER_JS_FILE';

    protected $titleParams = array();

    protected $params = array(
        'displayName' => array(
                'label'=>'displayName',
                'value' => false,
                'type'=> 'switch',
                'hint' => '',
            ),
        'selectHook' => array(
            'label' => 'selectHook',
            'type'=> 'selectHook',
            'hint' => '',
        ),
        'imageType' => array(
                'label'=>'imageType',
                'type'=> 'imageType',
                'hint' => '',
            ),
        'margin' => array(
                'label'=>'margin',
                'value' => 0,
                'type'=> 'number',
                'max' => 300,
                'min' => 0,
                'suffix' => 'px',
                'hint' => 'margin-right(px) on item',
            ),
        'center' => array(
                'label'=>'center',
                'value' => false,
                'type'=> 'switch',
                'hint' => 'Center item. Works well with even an odd number of items',
            ),
        'loop' => array(
                'label'=>'loop',
                'value' => false,
                'type'=> 'switch',
                'hint' => 'Infinity loop. Duplicate last and first items to get loop illusion',
            ),
        'nav' => array(
                'label'=>'nav',
                'value' => true,
                'type'=> 'switch',
                'hint' => 'Show next/prev buttons',
            ),
        'navRewind' => array(
                'label'=>'navRewind',
                'value' => true,
                'type'=> 'switch',
                'hint' => 'Go to first/last',
            ),
        'mouseDrag' => array(
                'label'=>'mouseDrag',
                'value' => true,
                'type'=> 'switch',
                'hint' => 'Mouse drag enabled',
            ),
        'touchDrag' => array(
                'label'=>'touchDrag',
                'value' => true,
                'type'=> 'switch',
                'hint' => 'Touch drag enabled',
            ),
        'dots' => array(
                'label'=>'dots',
                'value' => false,
                'type'=> 'switch',
                'hint' => 'Show dots navigation',
            ),
        'lazyLoad' => array(
                'label'=>'lazyLoad',
                'value' => false,
                'type'=> 'switch',
                'hint' => 'Lazy load images. data-src and data-src-retina for highres.
                    Also load images into background inline style if element is not <img>',
            ),
        'autoplay' => array(
                'label'=>'autoplay',
                'value' => false,
                'type'=> 'switch'
            ),
        'autoplayTimeout' => array(
                'label'=>'autoplayTimeout',
                'value' => 5000,
                'type'=> 'number',
                'min' => 0,
                'max' => 10000,
                'hint' => 'Autoplay interval timeout',
            ),
        'autoplayHoverPause' => array(
                'label'=>'autoplayHoverPause',
                'value' => false,
                'type'=> 'switch',
                'hint' => 'Pause on mouse hover',
            ),
        'smartSpeed' => array(
                'label'=>'smartSpeed',
                'value' => 250,
                'type'=> 'number',
                'min' => 0,
                'max' => 10000,
            ),
        'responsiveRefreshRate' => array(
                'label'=>'responsiveRefreshRate',
                'value' => 200,
                'type'=> 'number',
                'hint' => 'Responsive refresh rate',
                'min' => 0,
                'max' => 10000,
            ),
    );

    protected $responsive = array(
            0 => array(
                'items' => array(
                        'label'=>'0 px: items',
                        'value' => 1,
                        'type'=> 'number',
                        'min' => 1,
                        'max' => 50,
                        'hint' => 'The number of items you want to see on the screen',
                    ),
            ),
            480 => array(
                'items' => array(
                        'label'=>'480 px: items',
                        'value' => 1,
                        'type'=> 'number',
                        'min' => 1,
                        'max' => 50,
                        'hint' => 'The number of items you want to see on the screen',
                    ),
            ),
            768 => array(
                'items' => array(
                        'label'=>'768 px: items',
                        'value' => 3,
                        'type'=> 'number',
                        'min' => 1,
                        'max' => 50,
                        'hint' => 'The number of items you want to see on the screen',
                    ),
            ),
            992 => array(
                'items' => array(
                        'label'=>'992 px: items',
                        'value' => 5,
                        'type'=> 'number',
                        'min' => 1,
                        'max' => 50,
                        'hint' => 'The number of items you want to see on the screen',
                    ),
            ),
            1200 => array(
                'items' => array(
                        'label'=>'1200 px: items',
                        'value' => 6,
                        'type'=> 'number',
                        'min' => 1,
                        'max' => 50,
                        'hint' => 'The number of items you want to see on the screen',
                    ),
            ),
    );

    /**
     * an_brandslider constructor.
     */
    public function __construct()
    {
        $this->name = 'an_brandslider';
        $this->tab = 'front_office_features';
        $this->version = '1.0.9';
        $this->author = 'anvanto';
        $this->bootstrap = true;
        $this->module_root_path = _PS_MODULE_DIR_.$this->name;
        $this->configuration_source = $this->module_root_path.'/configuration.json';
        $this->module_key = '84518a68dd61b4bb924b6ddf12c95e8c';

        Module::__construct();

        $this->displayName = $this->l('AN Brand Slider: partners, manufacturers logo carousel');
        $this->description = $this->l('Shows brands that are presented in the shop');

        $this->titleParams[self::TITLE] = array(
            'col' => 3,
            'type' => 'text',
            'name' => self::TITLE,
            'label' => $this->l('Block title'),
            'lang' => true,
            'value' => ''
        );

        $this->titleParams[self::DO_SHOW_TITLE] = array(
            'type' => 'switch',
            'label' => $this->l('Show block title'),
            'name' => self::DO_SHOW_TITLE,
            'is_bool' => true,
            'values' => array(
                array(
                    'id' => 'active_on',
                    'value' => true,
                    'label' => $this->l('Yes')
                ),
                array(
                    'id' => 'active_off',
                    'value' => false,
                    'label' => $this->l('No')
                )
            ),
            'value' => true
        );
    }

    /**
     * @return bool
     */
    public function install()
    {
        if (!parent::install()) {
            return false;
        }

        $imported = $this->importConfiguration($this->configuration_source);

        $languages = $this->context->controller->getLanguages();
        foreach (array_merge($this->titleParams, $this->params) as $param => $value) {
            if (!array_search($param, $imported)) {
                if (isset($value['value'])) {
                    $val = $value['value'];
                    if (isset($value['lang']) && $value['lang']) {
                        foreach ($languages as $lang) {
                            $val[(int)$lang['id_lang']] = $value['value'];
                        }
                    }
                }

                $this->getParam($param, $val);
            }
        }

        foreach ($this->responsive as $screen_px => $items) {
            foreach ($items as $key => $item) {
                if (!array_search($screen_px . $key, $imported)) {
                    $this->getParam($screen_px . $key, $item['value']);
                }
            }
        }

        $hooksList=$this->getHooksList();

        foreach ($hooksList as $_hook) {
            if (!$this->registerHook($_hook)) {
                return false;
            }
        }

        return $this->generateJS()
            && $this->registerHook('displayHeader')
            && $this->registerHook('actionObjectLanguageAddAfter')
            && $this->hookActionObjectLanguageAddAfter()
            && $this->setManufacturers(array_map(function ($man) {
                return (int)$man['id_manufacturer'];
            }, (array)Manufacturer::getManufacturers()));
    }

    /**
     * @return bool
     */
    public function uninstall()
    {
        foreach (array_merge($this->titleParams, $this->params) as $param => $value) {
            if (!Configuration::deleteByName($param)) {
                return false;
            }
        }

        Configuration::deleteByName(self::MANUFACTURERS);

        foreach ($this->responsive as $screen_px => $items) {
            foreach ($items as $key => $item) {
                if (!Configuration::deleteByName($screen_px.$key)) {
                    return false;
                }
            }
        }
        
        @unlink($this->local_path.'views/js/' . (string)$this->getParam(self::JS_FILE));
        return parent::uninstall();
    }

    /**
     * @param null $params
     * @return bool
     */
    public function hookActionObjectLanguageAddAfter($params = null)
    {
        $lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
        if ($params !== null && $params['object'] instanceof Language && Validate::isLoadedObject($params['object'])) {
            $languages = array_merge(
                Language::getLanguages(0, 0, 1),
                array((int)$params['object']->id)
            );
        } else {
            $languages = Language::getLanguages(0, 0, 1);
        }

        foreach ($this->getLangKeys() as $key) {
            $values[$lang_default] = $this->getParam($key, null, $lang_default);
            
            foreach ($languages as $id_lang) {
                $value = $this->getParam($key, null, (int)$id_lang);

                if ($value === false || empty($value)) {
                    $values[(int)$id_lang] = $values[$lang_default];
                }
            }

            $this->getParam($key, $values);
        }

        return true;
    }

    /**
     * @return array
     */
    public function getLangKeys()
    {
        return array(
            static::TITLE
        );
    }

    /**
     * @param $params
     */
    public function hookDisplayHeader($params)
    {
        $this->context->controller->addJquery();
        if (version_compare(_PS_VERSION_, '1.7.0.0', '<') == 1) {
            $this->context->controller->addCss($this->_path . 'views/css/owl.carousel.min.css', 'all');
            $this->context->controller->addJs($this->_path . 'views/js/owl.carousel.min.js');
            $this->context->controller->addCss($this->_path . 'views/css/front.css', 'all');
            $this->context->controller->addJs($this->_path . 'views/js/' . (string)$this->getParam(self::JS_FILE));
        } else {
            $this->context->controller->registerStylesheet(
                'owlcarousel-css',
                'modules/' . $this->name . '/views/css/owl.carousel.min.css',
                array('media' => 'all', 'priority' => 150)
            );
            $this->context->controller->registerJavascript(
                'owlcarousel-js',
                'modules/' . $this->name . '/views/js/owl.carousel.min.js',
                array('position' => 'bottom', 'priority' => 150)
            );
            $this->context->controller->registerStylesheet(
                'an-brandslider-css',
                'modules/' . $this->name . '/views/css/front.css',
                array('media' => 'all', 'priority' => 150)
            );
            $this->context->controller->registerJavascript(
                'an-brandslider-js',
                'modules/' . $this->name . '/views/js/' . (string)$this->getParam(self::JS_FILE),
                array('position' => 'bottom', 'priority' => 150)
            );
        }
    }

    /**
     * @param null $params
     * @return string
     */
    public function displayContent($params = null)
    {
        $link = new Link();
        $img_format = new ImageType((int)$this->getParam('imageType'));

        if (!isset($img_format->name)) {
            $types = ImageType::getImagesTypes('manufacturers');
            $img_format = array_shift($types);
        }

        if (isset($img_format)) {
            $img_format = is_object($img_format) ? $img_format->name : $img_format['name'];

            $_manufacturers = Manufacturer::getManufacturers();
            $items = $this->getMenuItems();

            $manufacturers = array_map(function ($item) use ($_manufacturers) {
                foreach ($_manufacturers as $_manufacturer) {
                    if ((int)$_manufacturer['id_manufacturer'] == $item) {
                        return $_manufacturer;
                    }
                }
            }, $items);
            $manufacturers = array_filter($manufacturers);

            foreach ($manufacturers as $key => &$manufacturer) {
                $manufacturer['link'] = $link->getmanufacturerLink($manufacturer['id_manufacturer'], $manufacturer['link_rewrite']);
                if (version_compare(_PS_VERSION_, '1.7.0.0', '>=') == 1) {
                    $manufacturer['image'] = $this->context->language->iso_code.'-default';
                    if (file_exists(_PS_MANU_IMG_DIR_ . $manufacturer['id_manufacturer'] . '-' . $img_format.'.jpg')) {
                        $manufacturer['image'] = $manufacturer['id_manufacturer'];
                    }
                    if (file_exists(_PS_MANU_IMG_DIR_.$manufacturer['image'].'-'.$img_format.'.jpg')) {
                        $manufacturer['image'] = __PS_BASE_URI__ . 'img/m/' . $manufacturer['image'] . '-' . $img_format . '.jpg';
                    } elseif (file_exists(_PS_MANU_IMG_DIR_.$manufacturer['id_manufacturer'].'.jpg')) {
                        $manufacturer['image'] = __PS_BASE_URI__ .'img/m/'.$manufacturer['id_manufacturer'].'.jpg';
                    }
                } else {
                    $image = _PS_MANU_IMG_DIR_.$manufacturer['id_manufacturer'].'.jpg';
                    $manufacturer['image'] = $this->context->language->iso_code.'-default';
                    if (file_exists($image)) {
                        $manufacturer['image'] = ImageManager::thumbnail(
                            $image,
                            'manufacturer_' . (int)$manufacturer['id_manufacturer'] . '.' . $img_format,
                            350,
                            $img_format,
                            true,
                            true
                        );
                    } else {
                        $manufacturer['image'] = __PS_BASE_URI__ . 'img/'
                            . $this->context->language->iso_code . '-default.jpg';
                    }
                }
            }

            if (count($manufacturers)) {
                list($sliderOptions, $an_brandslider_options) = $this->getParams();

                $this->context->smarty->assign(array(
                    'an_manufacturers' => $manufacturers,
                    'an_brandslider_options'=> $an_brandslider_options,
                    'an_slider_options' => Tools::jsonEncode($sliderOptions),
                    'doshowtitle' => (bool)$sliderOptions[self::DO_SHOW_TITLE],
                    'title' => $sliderOptions[self::TITLE]
                ));
                
                return $this->display(__FILE__, 'slider.tpl');
            }
        }
    }

    /**
     * @return bool|int
     */
    protected function generateJS()
    {
        list($sliderOptions, $an_brandslider_options) = $this->getParams();
        $languages = $this->context->controller->getLanguages();

        $export = $this->generateJSName($this->killJS());

        if ($this->getParam(self::JS_FILE, $export)) {
            $this->context->smarty->assign('an_slider_options', Tools::jsonEncode($sliderOptions));
            return @file_put_contents(
                $this->local_path . 'views/js/' . $export,
                $this->display($this->name, 'js_generator.tpl')
            );
        }

        return true;
    }

    /**
     * @return string
     */
    protected function killJS()
    {
        $file = (string)$this->getParam(self::JS_FILE);
        @unlink($this->local_path.'views/js/' . $file);
        return $file;
    }

    /**
     * @param $name
     * @return string
     */
    protected function generateJSName($name)
    {
        return ($name !== false ? md5($name.self::SALT) : md5("slider")) . '.js';
    }

    /**
     * @param $key
     * @param null $value
     * @param null $lang
     * @return bool|string
     */
    public function getParam($key, $value = null, $lang = null)
    {
        if (is_null($value)) {
            return Configuration::get(self::PREFIX.$key, $lang === null ? null : (int)$lang);
        }

        return Configuration::updateValue(self::PREFIX.$key, $value);
    }

    /**
     * @param $type
     * @param $new_value
     * @return bool|int|string
     */
    protected function checkType($type, $new_value)
    {
        switch ($type) {
            case 'switch':
                $new_value = (bool)$new_value;
                break;
                
            case 'text':
                $new_value = pSQL((string)$new_value);
                break;
                    
            case 'number':
                $new_value = (int)$new_value;
                break;
                
            case 'imageType':
                $new_value = pSQL((string)$new_value);
                break;

            case 'selectHook':
                $new_value = pSQL((string)$new_value);
                break;

            case 'select':
                $new_value = pSQL((string)$new_value);
                break;

            default:
                $new_value = '';
        }
        
        return $new_value;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        $stores = Shop::getContextListShopID();
        if (count($stores) > 1) {
            return $this->displayWarning($this->l('Please, select a shop of your multistore first you want to apply changes for.'));
        }
        if (Tools::getIsset($this->name)) {
            $this->setManufacturers((array)Tools::getValue(self::MANUFACTURERS_FRONT));

            foreach (array_merge($this->params, $this->titleParams) as $key => $item) {
                if ($item['lang'] === true) {
                    $new_value = array();
                    foreach ($this->context->controller->getLanguages() as $lang) {
                        $new_value[(int)$lang['id_lang']] = $this->checkType(
                            $item['type'],
                            Tools::getValue($key."_{$lang['id_lang']}")
                        );
                    }
                } else {
                    $new_value = $this->checkType($item['type'], Tools::getValue($key));
                }

                $this->getParam($key, $new_value);
            }

            foreach ($this->responsive as $screen_px => $items) {
                foreach ($items as $key => $item) {
                    $new_value = $this->checkType($item['type'], Tools::getValue($screen_px.$key));
                    $this->getParam($screen_px . $key, $new_value);
                }
            }

            $this->generateJS();
            $this->exportConfiguration();

            Tools::redirectAdmin('index.php?tab=AdminModules&conf=4&configure=' . $this->name . '&token='
                . Tools::getAdminToken('AdminModules' . (int)(Tab::getIdFromClassName('AdminModules'))
                . (int)$this->context->employee->id));
        }

        return $this->displayForm(). $this->display(__FILE__, 'views/templates/admin/config_footer.tpl');
    }

    /**
     * @return string
     */
    public function displayForm()
    {
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $languages = $this->context->controller->getLanguages();
        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;
        $helper->title = $this->displayName;
        $helper->submit_action = $this->name;

        $fields_form = array(
            $this->getTitleForm($helper),
            $this->getManufacturersForm($helper),
            $this->getSettingsForm($helper),
            $this->getResponsiveSettingsForm($helper)
        );

        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->languages = $this->context->controller->getLanguages();
        $helper->default_form_language = (int)$this->context->language->id;
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code
            ),
            'languages' => $languages,
            'id_language' => $this->context->language->id,
            'choices' => $this->renderChoicesSelect(),
            'selected_links' => $this->makeMenuOption(),
        );

        return $helper->generateForm($fields_form);
    }

    /**
     * @return array
     */
    protected function getParams()
    {
        $sliderOptions = $an_brandslider_options = array();

        foreach (array_merge($this->params, $this->titleParams) as $key => $item) {
            $new_value = $this->getParam(
                $key,
                null,
                isset($item['lang']) && $item['lang'] ? $this->context->language->id : 0
            );
                
            if ($key != 'displayName' && $item['type'] != 'imageType'&& $item['type'] != 'selectHook') {
                $sliderOptions[$key] = $new_value;
            } else {
                $an_brandslider_options[$key] = $new_value;
            }
        }

        foreach ($this->responsive as $screen_px => $items) {
            $sliderOptions['responsive'][$screen_px] = array();

            foreach ($items as $key => $item) {
                $new_value = $this->checkType($item['type'], $this->getParam($screen_px.$key));
                $sliderOptions['responsive'][$screen_px][$key] = $new_value;
            }
        }

        return array($sliderOptions, $an_brandslider_options);
    }

    /**
     * @return string
     */
    protected function renderChoicesSelect()
    {
        $this->context->smarty->assign(array(
            'manufacturers' => Manufacturer::getManufacturers(false, $this->context->language->id),
            'items' => $this->getMenuItems()
        ));

        return $this->display(__FILE__, 'views/templates/admin/choices.tpl');
    }

    /**
     * @return string
     */
    protected function makeMenuOption()
    {
        $this->context->smarty->assign(array(
            'id_lang' => $this->context->language->id,
            'menu_item' => $this->getMenuItems(),
            'module' => $this
        ));

        return $this->display(__FILE__, 'views/templates/admin/menu_option.tpl');
    }

    /**
     * @return array|mixed
     */
    protected function getMenuItems()
    {
        $items = Tools::getValue('items');

        if (is_array($items) && count($items)) {
            return $items;
        } else {
            $shops = Shop::getContextListShopID();
            $conf = null;

            if (count($shops) > 1) {
                foreach ($shops as $key => $shop_id) {
                    $shop_group_id = Shop::getGroupFromShop($shop_id);
                    $conf .= (string)($key > 1 ? ',' : '')
                        . Configuration::get(self::MANUFACTURERS, null, $shop_group_id, $shop_id);
                }
            } else {
                $shop_id = (int)$shops[0];
                $shop_group_id = Shop::getGroupFromShop($shop_id);
                $conf = Configuration::get(
                    self::MANUFACTURERS,
                    null,
                    $shop_group_id,
                    $shop_id
                );
            }

            if (Tools::strlen($conf)) {
                return array_map(function ($i) {
                    return (int)$i;
                }, explode(',', $conf));
            } else {
                return array();
            }
        }
    }

    /**
     * @param $man_list
     * @return bool
     */
    protected function setManufacturers($man_list)
    {
        $items = is_array($man_list) ? (string)implode(',', array_unique($man_list)) : (string)$man_list;
        $shops = Shop::getContextListShopID();

        if (count($shops) == 1) {
            foreach ($shops as $shop_id) {
                $group = Shop::getGroupFromShop($shop_id);
                Configuration::updateValue(
                    self::MANUFACTURERS,
                    $items,
                    false,
                    $group ? $group : null,
                    $shop_id
                );
            }
        }

        return true;
    }

    /**
     * @param $helper
     * @return array
     */
    protected function getTitleForm($helper)
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Title'),
                ),
                'input' => $this->getTitleFormInputs($helper),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            )
        );
    }

    /**
     * @param $helper
     * @return array
     */
    protected function getManufacturersForm($helper)
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Manufacturers'),
                ),
                'input' => $this->getManufacturersFormInputs($helper),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            )
        );
    }

    /**
     * @param $helper
     * @return array
     */
    protected function getSettingsForm($helper)
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Basic settings'),
                ),
                'input' => $this->getSettingsFormInputs($helper),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            )
        );
    }

    /**
     * @param $helper
     * @return array
     */
    protected function getResponsiveSettingsForm($helper)
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Responsive settings'),
                ),
                'input' => $this->getResponsiveSettingsFormInputs($helper),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
               )
           );
    }

    /**
     * @param $helper
     * @return array
     */
    protected function getTitleFormInputs($helper)
    {
        $fields = array(
            self::TITLE => $this->titleParams[self::TITLE],
            self::DO_SHOW_TITLE => $this->titleParams[self::DO_SHOW_TITLE]
        );

        $languages = $this->context->controller->getLanguages();

        foreach ($fields as $key => $item) {
            if (isset($item['lang']) && $item['lang']) {
                foreach ($languages as $lang) {
                    $id_lang = (int)$lang['id_lang'];
                    $helper->fields_value[$key][$id_lang] = $this->getParam($key, null, $id_lang);
                }
            } else {
                $helper->fields_value[$key] = $this->getParam($key);
            }
        }

        return $fields;
    }

    /**
     * @param $helper
     * @return array
     */
    protected function getManufacturersFormInputs($helper)
    {
        return array(
            array(
                'type' => 'link_choice',
                'label' => '',
                'name' => 'link',
                'lang' => true,
            )
        );
    }

    /**
     * @param $helper
     * @return array
     */
    protected function getSettingsFormInputs($helper)
    {
        $inputs = array();
        foreach ($this->params as $key => $item) {
            $helper->fields_value[$key] = $this->getParam($key);
            
            if (!isset($item['label']) | $item['label'] == '') {
                $item['label'] = Tools::ucfirst(ltrim(preg_replace('/[A-Z]/', ' $0', $key)));
            }

            switch ($item['type']) {
                case 'imageType':
                    $inputs[$key] = array(
                        'type' => 'select',
                        'label' => $item['label'],
                        'name' => $key,
                        'options' => array(
                            'query' => ImageType::getImagesTypes('manufacturers'),
                            'id' => 'id_image_type',
                            'name' => 'name',
                        ),
                    );
                    break;

                case 'selectHook':
                    $inputs[$key] = array(
                        'type' => 'select',
                        'label' => $this->l('Select hook'),
                        'name' => $key,
                        'options' => array(
                            'query' => $this->getHooksQuery(),
                            'name' => 'name',
                            'id' => 'value',
                        ),
                    );
                    break;

                case 'switch':
                    $inputs[$key] = array(
                        'type' => 'switch',
                        'label' => $item['label'],
                        'name' => $key,
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => $key.'_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => $key.'_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        ),
                    );
                    break;

                case 'select':
                    $inputs[$key] = $item;
                    break;

                case 'text':
                    $inputs[$key] = array(
                        'type' => 'text',
                        'label' => $item['label'],
                        'name' => $key,
                        'lang' => isset($item['lang']) && (bool)$item['lang']
                    );
                    break;

                case 'number':
                    $inputs[$key] = array(
                        'col' => '3',
                        'type' => 'number',
                        'label' => $item['label'],
                        'name' => $key,
                        'min' => $item['min'],
                        'max' => $item['max'],
                        'suffix' => isset($item['suffix']) ? $item['suffix'] : ''
                    );
                    break;
            }
            
            if (isset($inputs[$key], $item['hint']) && $item['hint'] != '') {
                $inputs[$key]['hint'] = $item['hint'];
            }
        }

        return $inputs;
    }

    /**
     * @param $helper
     * @return array
     */
    protected function getResponsiveSettingsFormInputs($helper)
    {
        $inputs = array();

        foreach ($this->responsive as $screen_px => $items) {
            foreach ($items as $key => $item) {
                if (!isset($item['label']) | $item['label'] == '') {
                    $item['label'] = Tools::ucfirst(
                        ltrim(
                            preg_replace(
                                '/[A-Z]/',
                                ' $0',
                                $screen_px . ' px: ' . $key
                            )
                        )
                    );
                }
                
                $key = $screen_px.$key;
                
                $helper->fields_value[$key] = $this->getParam($key);
                
                switch ($item['type']) {
                    case 'switch':
                        $inputs[$key] = array(
                            'type' => 'switch',
                            'label' => $item['label'],
                            'name' => $key,
                            'is_bool' => true,
                            'values' => array(
                                array(
                                    'id' => $key.'_on',
                                    'value' => 1,
                                    'label' => $this->l('Yes')
                                ),
                                array(
                                    'id' => $key.'_off',
                                    'value' => 0,
                                    'label' => $this->l('No')
                                )
                            ),
                        );
                        break;

                    case 'text':
                        $inputs[$key] = array(
                            'type' => 'text',
                            'label' => $item['label'],
                            'name' => $key,
                        );
                        break;

                    case 'number':
                        $inputs[$key] = array(
                            'col' => '3',
                            'type' => 'number',
                            'label' => $item['label'],
                            'name' => $key,
                            'min' => $item['min'],
                            'max' => $item['max'],
                        );
                        break;
                }
                
                if (isset($inputs[$key], $item['hint']) && $item['hint'] != '') {
                    $inputs[$key]['hint'] = $item['hint'];
                }
            }
        }

        return $inputs;
    }

    /**
     * return array of names imported params
     */
    protected function importConfiguration($configuration_source = null)
    {
        $configuration_source = $configuration_source === null ? $this->configuration_source : $configuration_source;
        $config = Tools::jsonDecode(Tools::file_get_contents($configuration_source), 1);

        if (count((array)$config) == 0) {
            return array();
        }

        $importedParams = array();
        $mergedParams = array_merge($this->titleParams, $this->params);

        foreach ($config as $param => $value) {
            if ($param == 'responsive') {
                foreach ($value as $width => $items) {
                    foreach ($items as $key => $item) {
                        if (array_key_exists($width, $this->responsive)) {
                            if ($this->getParam($width . $key, $item)) {
                                $importedParams[] = $width . $key;
                            }
                        }
                    }
                }
            } else {
                if (array_key_exists($param, $mergedParams)) {
                    if (isset($mergedParams[$param]['lang']) && $mergedParams[$param]['lang']) {
                        foreach (Language::getLanguages(1, 0, 1) as $id_lang) {
                            if (array_key_exists($id_lang, $value)) {
                                $val[$id_lang] = $value[(string)$id_lang];
                            }else{
                                $val[$id_lang] = '';
                            }
                        }
                    } else {
                        $val = $value;
                    }


                    if ($this->getParam($param, $val)) {
                        $importedParams[$param] = $param;
                    }
                }
            }
        }

        if (count($importedParams)>0) {
            return $importedParams;
        } else {
            return array();
        }
    }

    /**
     * @param null $configuration_source
     * @return bool|int
     */
    protected function exportConfiguration($configuration_source = null)
    {
        $configuration_source = $configuration_source === null ? $this->configuration_source : $configuration_source;
        $languages = Language::getLanguages(1, 0, 1);

        $data = array(
            "responsive" => array()
        );

        foreach ($this->responsive as $screen_px => $items) {
            foreach ($items as $key => $item) {
                $data["responsive"][$screen_px][$key] = $this->getParam($screen_px.$key);
            }
        }

        foreach (array_merge($this->titleParams, $this->params) as $param => $value) {
            if (isset($value['lang']) && $value['lang']) {
                foreach (Language::getLanguages(1, 0, 1) as $id_lang) {
                    $data[$param][$id_lang] = $this->getParam($param, null, $id_lang);
                }
            } else {
                $data[$param] = $this->getParam($param);
            }
        }

        return @file_put_contents($configuration_source, Tools::jsonEncode($data));
    }

    /**
     * @return array
     */
    protected function getHooksList()
    {
        $filePath=_PS_MODULE_DIR_ . 'an_brandslider/config_hooks.php';
        if (file_exists($filePath)) {
            return include $filePath;
        } else {
            return array();
        }
    }

    /**
     * @return array
     */
    protected function getHooksQuery()
    {
        $hooksQuery=array();

        foreach ($this->getHooksList() as $hookname) {
            $hooksQuery[]=array('name' => $hookname , 'value' => $hookname);
        }

        return $hooksQuery;
    }

    /**
     * @param $function
     * @param $args
     * @return bool|string
     */
    public function __call($function, $args)
    {
        $hookName = str_replace('hook', '', $function);
        if ($hookName==self::getParam('selectHook')) {
            return $this->displayContent($args);
        }
    }
}
