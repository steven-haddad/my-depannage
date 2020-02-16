<?php
/**
* 2007-2015 PrestaShop
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
*  @author    Apply Novation (Artem Zwinger) <applynovation@gmail.com>
*  @copyright 2016-2017 Apply Novation
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Anscrolltop extends Module
{
    protected $config_form = false;

    protected $accepted_position = array(
        'top-left',
        'top-right',
        'bottom-left',
        'bottom-right'
    );

    const SALT = 'IDDQD';
    const PREFIX = 'SCROLLTOP_';

    const BUTTON_BG_NONE    = 'none';

    const BUTTON_ICO        = 'BUTTON_ICO';
    const BORDER_WIDTH      = 'BORDER_WIDTH';
    const BORDER_COLOR      = 'BORDER_COLOR';
    const BORDER_RADIUS     = 'BORDER_RADIUS';
    const BUTTON_BG         = 'BUTTON_BG';
    const BUTTON_WIDTH      = 'BUTTON_WIDTH';
    const BUTTON_HEIGHT     = 'BUTTON_HEIGHT';
    const BUTTON_MARGIN_X   = 'BUTTON_MARGIN_X';
    const BUTTON_MARGIN_Y   = 'BUTTON_MARGIN_Y';
    const OPACITY           = 'OPACITY';
    const POSITION          = 'POSITION';
    const FONT_COLOR        = 'FONT_COLOR';
    const FONT_SIZE         = 'FONT_SIZE';
    const CSS_FILE          = 'CSS_FILE';

    public function __construct()
    {
        $this->name = 'anscrolltop';
        $this->tab = 'front_office_features';
        $this->version = '1.0.7';
        $this->author = 'anvanto';
        $this->need_instance = 1;
        $this->bootstrap = true;
        $this->module_key = '3a484f3d1983a2323b714f018f5fb79d';
        
        parent::__construct();

        $this->configuration_file = $this->local_path.'configuration.json';
        $this->icons_file = $this->local_path.'icons.json';
        $this->front_css_path = $this->local_path.'views/css/';

        if (file_exists($this->icons_file)) {
            $this->icons = Tools::jsonDecode(Tools::file_get_contents($this->icons_file), 1);
        }

        $this->displayName = $this->l('AN Scroll Top Button Premium');
        $this->description = $this->l('A scroll top top button helps a user to get back quickly to the top of the page.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        if (file_exists($this->configuration_file)) {
            foreach ((array)Tools::jsonDecode(Tools::file_get_contents($this->configuration_file)) as $cfg => $val) {
                $this->getParam($cfg, $val);
            }
        }

        return parent::install()
            && (bool)$this->generateCSS()
            && $this->registerHook('header')
            && $this->registerHook('backOfficeHeader')
            && $this->registerHook('displayFooter');
    }

    public function uninstall()
    {
        foreach (array_keys($this->getConfigFormValues()) as $key) {
            Configuration::deleteByName(self::PREFIX.$key);
        }

        Configuration::deleteByName(self::PREFIX.self::CSS_FILE);

        return parent::uninstall();
    }

    public function getContent()
    {
        if (Tools::isSubmit('submitScrolltopModule')) {
            $this->postProcess();
        }

        $this->context->smarty->assign(array('ICON' => $this->getParam(self::BUTTON_ICO), 'errors' => $this->getErrors()));
        return $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl').$this->renderForm();
    }

    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = $this->getParam('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', null, 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitScrolltopModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    protected function generateCSS()
    {
        $cfg = $this->getConfigFormValues();
        $cfg[self::OPACITY] = number_format((int)$cfg[self::OPACITY]/100, 2);
        $method = "position".str_replace("-", "", $cfg[self::POSITION]);
        list($cfg['TOP'], $cfg['RIGHT'], $cfg['BOTTOM'], $cfg['LEFT']) = method_exists($this, $method) ? $this->{$method}($cfg) : $this->positionbottomright($cfg);

        $languages = $this->context->controller->getLanguages();

        $export = $this->generateCSSName($this->killCSS());

        if ($this->getParam(self::CSS_FILE, $export)) {
            $this->context->smarty->assign($cfg);
            return @file_put_contents($this->front_css_path.$export, $this->display($this->name, 'front.css.tpl'));
        }

        return true;
    }

    protected function killCSS()
    {
        $file = (string)$this->getParam(self::CSS_FILE);
        @unlink($this->local_path.'views/css/'.$file);
        return $file;
    }

    protected function generateCSSName($name)
    {
        return ($name !== false ? md5($name.self::SALT) : md5("front")).'.css';
    }

    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'col' => 1,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-compress"></i>',
                        'desc' => $this->l('Enter a border width'),
                        'name' => self::BORDER_WIDTH,
                        'label' => $this->l('Border width'),
                    ),
                    array(
                        'col' => 9,
                        'type' => 'color',
                        'prefix' => '<i class="icon icon-code"></i>',
                        'desc' => $this->l('Select a border color'),
                        'name' => self::BORDER_COLOR,
                        'label' => $this->l('Border color'),
                    ),
                    array(
                        'col' => 1,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-square-o"></i>',
                        'desc' => $this->l('Enter a border radius'),
                        'name' => self::BORDER_RADIUS,
                        'label' => $this->l('Border radius'),
                    ),
                    array(
                        'col' => 9,
                        'type' => 'color',
                        'prefix' => '<i class="icon icon-code"></i>',
                        'desc' => $this->l('Select a button background'),
                        'name' => self::BUTTON_BG,
                        'label' => $this->l('Button background'),
                    ),
                    array(
                        'col' => 1,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-compress"></i>',
                        'desc' => $this->l('Enter a button width'),
                        'name' => self::BUTTON_WIDTH,
                        'label' => $this->l('Button width'),
                    ),
                    array(
                        'col' => 1,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-compress"></i>',
                        'desc' => $this->l('Enter a button height'),
                        'name' => self::BUTTON_HEIGHT,
                        'label' => $this->l('Button height'),
                    ),
                    array(
                        'col' => 1,
                        'type' => 'select',
                        'prefix' => '<i class="icon icon-photo"></i>',
                        'desc' => $this->l('Enter a button icon'),
                        'name' => self::BUTTON_ICO,
                        'label' => $this->l('Button icon'),
                        'options' => array(
                            'query' => array_map(function ($i) {
                                return array(self::BUTTON_ICO => $i['code'], "name" => '&#x'.$i['code'].';');
                            }, $this->icons),
                            'id' => self::BUTTON_ICO,
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'col' => 9,
                        'type' => 'color',
                        'prefix' => '<i class="icon icon-code"></i>',
                        'desc' => $this->l('Select a icon color'),
                        'name' => self::FONT_COLOR,
                        'label' => $this->l('Icon color'),
                    ),
                    array(
                        'col' => 2,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-compress"></i>',
                        'desc' => $this->l('Enter a icon size'),
                        'name' => self::FONT_SIZE,
                        'label' => $this->l('Icon size'),
                    ),
                    array(
                        'col' => 2,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-compress"></i>',
                        'desc' => $this->l('Enter a button indention for x-coordinate'),
                        'name' => self::BUTTON_MARGIN_X,
                        'label' => $this->l('Button x-indent'),
                    ),
                    array(
                        'col' => 2,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-compress"></i>',
                        'desc' => $this->l('Enter a button indention for y-coordinate'),
                        'name' => self::BUTTON_MARGIN_Y,
                        'label' => $this->l('Button y-indent'),
                    ),
                    array(
                        'col' => 2,
                        'type' => 'text',
                        'prefix' => '<i class="icon"><b>%</b></i>',
                        'desc' => $this->l('Enter a button opacity'),
                        'name' => self::OPACITY,
                        'label' => $this->l('Button opacity'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'select',
                        'prefix' => '<i class="icon icon-eye"></i>',
                        'desc' => $this->l('Select a button position'),
                        'name' => self::POSITION,
                        'label' => $this->l('Button position'),
                        'options' => array(
                            'query' => array_map(function ($i) {
                                return array(self::POSITION => $i, 'name' => $i);
                            }, $this->accepted_position),
                            'id' => self::POSITION,
                            'name' => 'name'
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    protected function getConfigFormValues()
    {
        $params = array();
        
        foreach ($this->getConfigKeys() as $entity) {
            $params[$entity] = $this->getParam($entity);
        }

        return $params;
    }

    protected function getConfigKeys()
    {
        return array(
            self::BORDER_WIDTH,
            self::BORDER_COLOR,
            self::BORDER_RADIUS,
            self::BUTTON_BG,
            self::BUTTON_WIDTH,
            self::BUTTON_HEIGHT,
            self::BUTTON_ICO,
            self::BUTTON_MARGIN_X,
            self::BUTTON_MARGIN_Y,
            self::OPACITY,
            self::POSITION,
            self::FONT_COLOR,
            self::FONT_SIZE
        );
    }

    protected function getConfigColorKeys()
    {
        return array(
            self::BORDER_COLOR,
            self::BUTTON_BG,
            self::FONT_COLOR
        );
    }

    protected function getParam($key, $value = null, $default_value = null)
    {
        if (!is_string($key) || empty($key)) {
            return false;
        }

        return is_null($value) ? Configuration::get(self::PREFIX.$key, $default_value) : Configuration::updateValue(self::PREFIX.$key, $value);
    }

    protected function postProcess()
    {
        foreach ($this->getConfigKeys() as $key) {
            $value = Tools::getValue($key);

            if (in_array($key, $this->getConfigColorKeys())) {
                if (!empty($value)) {
                    if (!preg_match('/^(#[0-9a-fA-F]{6})$/', $value)) {
                        $this->_errors[] = Tools::displayError($this->l("That is not a color"));
                        continue;
                    }
                } else {
                    $value = self::BUTTON_BG_NONE;
                }
            }

            $this->getParam($key, $value);
        }

        @file_put_contents($this->configuration_file, Tools::jsonEncode($this->getConfigFormValues()));
        
        return $this->generateCSS() //needs a refresh but hookBackOfficeHeader we can't load the new css file
            && Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules').'&configure='.$this->name.'&tab_module='.$this->tab_module.'&module_name='.$this->name);
    }

    public function hookBackOfficeHeader()
    {
        if (in_array($this->name, array(Tools::getValue('module_name'), Tools::getValue('configure')))) {
            $this->context->controller->addCSS($this->_path.'/views/css/ionicons.min.css');
            $this->context->controller->addCSS($this->_path.'/views/css/'.$this->getParam(self::CSS_FILE));
            $this->context->controller->addCSS($this->_path.'/views/css/back.css');
            $this->context->controller->addJquery();
            $this->context->controller->addJS($this->_path.'views/js/back.js');
        }
    }

    public function hookHeader()
    {
        if (version_compare(_PS_VERSION_, "1.7.0.0", "<")) {
            $this->context->controller->addCSS($this->_path.'/views/css/ionicons.min.css');
            $this->context->controller->addJS($this->_path.'/views/js/front.js');
            $this->context->controller->addCSS($this->_path.'/views/css/'.$this->getParam(self::CSS_FILE));
        } else {
            $this->context->controller->registerStylesheet("modules-scrolltop-fe1", "modules/{$this->name}/views/css/ionicons.min.css", array('priority' => 1));
            $this->context->controller->registerStylesheet("modules-scrolltop-fe2", "modules/{$this->name}/views/css/".$this->getParam(self::CSS_FILE), array('priority' => 150));
            $this->context->controller->registerJavascript("modules-scrolltop-fe3", "modules/{$this->name}/views/js/front.js", array('position' => AbstractAssetManager::DEFAULT_JS_POSITION, 'priority' => 150));
        }
    }

    public function hookDisplayFooter()
    {
        $this->context->smarty->assign(array('ICON' => $this->getParam(self::BUTTON_ICO)));

        return $this->display($this->name, "display_footer.tpl");
    }

    protected function positiontopleft($cfg)
    {
        return array($cfg[self::BUTTON_MARGIN_Y]."px", "auto", "auto", $cfg[self::BUTTON_MARGIN_X]."px");
    }

    protected function positiontopright($cfg)
    {
        return array($cfg[self::BUTTON_MARGIN_Y]."px", $cfg[self::BUTTON_MARGIN_X]."px", "auto", "auto");
    }

    protected function positionbottomleft($cfg)
    {
        return array("auto", "auto", $cfg[self::BUTTON_MARGIN_Y]."px", $cfg[self::BUTTON_MARGIN_X]."px");
    }

    protected function positionbottomright($cfg)
    {
        return array("auto", $cfg[self::BUTTON_MARGIN_X]."px", $cfg[self::BUTTON_MARGIN_Y]."px", "auto");
    }
}
