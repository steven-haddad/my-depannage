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
 *  @author    Anvanto (anvantoco@gmail.com)
 *  @copyright 2007-2018  http://anvanto.com
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

spl_autoload_register(function ($class_name) {
    if (mb_strstr($class_name, 'ANPT')
        && file_exists(_PS_MODULE_DIR_.'anproductextratabs/models/'.$class_name.'.php')
    ) {
        include(_PS_MODULE_DIR_.'anproductextratabs/models/'.$class_name.'.php');
    }
});

class Anproductextratabs extends Module
{
    const AJAX_CONTROLLER_NAME = 'AdminAnProductTabs';
    const CONTROLLER_NAME = 'AdminAnProductTabsEdit';

    //common edit form
    const COMMON_NAME = 'name';
    const COMMON_ID = 'id';
    const COMMON_TYPE  = 'type';


    const DEFAULT_CONTENT_OFFSET = 16;
    const DEFAULT_CONTENT_TITLE = 'default_content_title';
    const DEFAULT_CONTENT_CONTENT = 'default_content_content';

    const CONTENT_ID = 'content_id';
    const CONTENT_OFFSET = 8;
    const CONTENT_TITLE = 'content_title';
    const CONTENT_CONTENT = 'content_content';
    const CONTENT_ACTIVE = 'content_active';

    const EDIT_ARGUMENT = 'anpt_edit';
    const DELETE_ARGUMENT = 'anpt_delete';

    const PREFIX = 'ANPRODUCTEXTRATABS_';
    const VIEW_TYPE = 'VIEW_TYPE';
    const TAB_TYPE = 'type';
    const TAB_TYPE_DEFAULT = 'content';
    const TAB_TYPE_CONTENT = 'content';
    const TAB_TYPE_CONTACT = 'contact';
    const TAB_TYPE_PRODUCTS = 'products';
    const VIEW_TYPE_DEFAULT = 'tabs';
    const VIEW_TYPE_TABS = 'tabs';
    const VIEW_TYPE_BLOCK = 'blocks';
    const VIEW_TYPE_ACCORDION = 'accordion';
    const CONFIGURATION_SUBMIT = 'submitAnproductextratabsModule';
    const DESIGN_SUBMIT = 'submitAnproductextratabsDesign';
    const CONFIG_BACK_COLOR = 'CONFIG_BACK_COLOR';
    const CONFIG_FONT_COLOR = 'CONFIG_FONT_COLOR';
    const CONFIG_SELECTED_BACK_COLOR = 'CONFIG_SELECTED_BACK_COLOR';
    const CONFIG_SELECTED_FONT_COLOR = 'CONFIG_SELECTED_FONT_COLOR';
    const ADMIN_TAB_SETTINGS = 'settings';
    const ADMIN_TAB_DESIGN = 'design';

    protected $submit_action = '';
    protected $views_version = '1.7';
    protected $views_prefix_admin = '';
    protected $views_prefix_hook = '';
    protected $views_path_admin = '';
    protected $views_path_hook = '';
    protected $media_path = '';
    protected $messages = array();

    public function __construct()
    {
        $this->name = 'anproductextratabs';
        $this->tab = 'front_office_features';
        $this->version = '2.1.0';
        $this->author = 'anvanto';
        $this->need_instance = 1;
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->bootstrap = true;

        $this->new = version_compare(_PS_VERSION_, '1.6.9.9', '>') ?  true : false;
        $this->morenew = version_compare(_PS_VERSION_, '1.7.3', '<') ? false : true;

        $languages = Language::getLanguages(1, 0, 0);
        foreach ($languages as $key => $language) {
            if ($language['id_lang'] == (int)Configuration::get('PS_LANG_DEFAULT')) {
                $languages[$key]['is_default'] = true;
            } else {
                $languages[$key]['is_default'] = false;
            }
        }
        $this->languages = $languages;
        $this->bootstrap = true;
        $this->module_key = '3b466206aa8f1f635aaa18f9c1523fd8';

        parent::__construct();

        $this->submit_action = $this->name.'_edit_form';

        if (!$this->new) {
            $this->views_version = '1.6';
        }

        $this->views_prefix_admin = 'views/templates/admin/';
        $this->views_prefix_hook = 'views/templates/hook/'.$this->views_version.'/';
        $this->views_path_admin = $this->local_path.$this->views_prefix_admin;
        $this->views_path_hook = $this->local_path.$this->views_prefix_hook;

        $this->displayName = $this->l('AN Product Extra Tabs Premium');
        $this->description = $this->l('The module creates additional description tabs with any format of content.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall the module?');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);

        $this->media_path = $this->local_path.'media';

        $this->messages = array(
            'update_order' => array(
                'success' => $this->l('The order has been updated successfully'),
                'error' => $this->l('An error occurred')
            ),
            'update' => array(
                'success' => $this->l('The tab has been updated successfully'),
                'error' => $this->l('An error occurred')
            ),
            'create' => array(
                'success' => $this->l('The tab has been created successfully'),
                'error' => $this->l('An error occurred')
            ),
            'delete' => array(
                'success' => $this->l('The tab has been deleted successfully'),
                'error' => $this->l('An error occurred'),
                'assurance' => $this->l('Are you sure?')
            ),
            'std' => array(
                'success' => $this->l('Process was completed successfully'),
                'error' => $this->l('An error occurred')
            ),
            'list_loaded' => array(
                'success' => $this->l('The list was generated successfully'),
                'error' => $this->l('An error occurred')
            ),
            'choose_cathegory' => array(
                'success' => $this->l('The list was generated successfully'),
                'error' => $this->l('Choose at least one category')
            ),
            'fill_title' => array(
                'success' => $this->l('The list was generated successfully'),
                'error' => $this->l('Please enter tab display name')
            )
        );

        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $this->context->smarty->assign(array(
            $this->name.'_msg' => Tools::jsonEncode($this->messages),
            'anpt_tinymce_format' => '{"format": "raw"}',
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code,
                'is_default' => true
            )
        ));
    }

    protected function registerController()
    {
        $tab = new Tab();
        $tab->active = true;

        foreach ((array)$this->languages as $lang) {
            $tab->name[$lang['id_lang']] = 'anproductextratabs';
        }

        $tab->class_name = self::AJAX_CONTROLLER_NAME;
        $tab->module = $this->name;
        $tab->id_parent = -1;

        return (bool)$tab->add();
    }

    protected function unregisterController()
    {
        if ($_tab = (int)Tab::getIdFromClassName(self::AJAX_CONTROLLER_NAME)) {
            $tab = new Tab($_tab);
            return $tab->delete();
        }

        return true;
    }

    public function install()
    {
        if (file_exists($this->local_path.'sql/install.php')) {
            include($this->local_path.'sql/install.php');
        } else {
            return false;
        }

        return parent::install()
            && $this->getParam(self::VIEW_TYPE . '_' . $this->context->shop->id, self::VIEW_TYPE_DEFAULT)
            && $this->registerHook('header')
            && (!$this->new ?
                $this->registerHook('displayFooterProduct') : $this->registerHook('displayProductExtraContent'))
            && $this->registerHook('actionAdminControllerSetMedia')
            && $this->registerHook('actionProductUpdate')
            && $this->registerHook('displayAdminProductsExtra')
            && $this->registerHook('backOfficeHeader')
            && $this->registerController();
    }

    public function uninstall()
    {
        if (file_exists($this->local_path.'sql/uninstall.php')) {
            include($this->local_path.'sql/uninstall.php');
        }

        return parent::uninstall()
            && $this->unregisterController()
            && $this->unregisterHook('header')
            && (!$this->new ?
                $this->unregisterHook('displayFooterProduct') : $this->unregisterHook('displayProductExtraContent'))
            && $this->unregisterHook('actionAdminControllerSetMedia')
            && $this->unregisterHook('actionProductUpdate')
            && $this->unregisterHook('displayAdminProductsExtra')
            && $this->unregisterHook('backOfficeHeader');
    }

    public function getContent()
    {
        $this->context->smarty->assign(array(
            $this->name.'_theme_url' => $this->context->link->getAdminLink(self::AJAX_CONTROLLER_NAME)
        ));
        $tab_value = '';

        if (Tools::isSubmit(self::CONFIGURATION_SUBMIT)) {
            if (Tools::getIsset(self::VIEW_TYPE)) {
                $this->getParam(self::VIEW_TYPE . '_' . $this->context->shop->id, Tools::getValue(self::VIEW_TYPE));
            }
            $tab_value = self::ADMIN_TAB_SETTINGS;
        } elseif (Tools::isSubmit('setDefaultDesign')) {
            Configuration::deleteByName(self::PREFIX . self::CONFIG_BACK_COLOR);
            Configuration::deleteByName(self::PREFIX . self::CONFIG_FONT_COLOR);
            Configuration::deleteByName(self::PREFIX . self::CONFIG_SELECTED_BACK_COLOR);
            Configuration::deleteByName(self::PREFIX . self::CONFIG_SELECTED_FONT_COLOR);
            $tab_value = self::ADMIN_TAB_DESIGN;
        } elseif (Tools::isSubmit(self::DESIGN_SUBMIT)) {
            $this->getParam(self::CONFIG_BACK_COLOR, Tools::getValue(self::CONFIG_BACK_COLOR));
            $this->getParam(self::CONFIG_FONT_COLOR, Tools::getValue(self::CONFIG_FONT_COLOR));
            $this->getParam(self::CONFIG_SELECTED_BACK_COLOR, Tools::getValue(self::CONFIG_SELECTED_BACK_COLOR));
            $this->getParam(self::CONFIG_SELECTED_FONT_COLOR, Tools::getValue(self::CONFIG_SELECTED_FONT_COLOR));
            $tab_value = self::ADMIN_TAB_DESIGN;
        } elseif (Tools::isSubmit($this->submit_action)) {
             $this->postProcess();
        }


        if (Tools::getIsset(self::EDIT_ARGUMENT)) {
            $id = (int)Tools::getValue(self::EDIT_ARGUMENT, 0);
            $collection = new ANPTTabCollection();
            return $this->renderEditForm(
                $id > 0 ? $collection->byId($id)->loadDefaultContent()->getFirst() : new ANPTTab()
            );
        }

        if (Tools::getIsset(self::DELETE_ARGUMENT)) {
            $id = (int)Tools::getValue(self::DELETE_ARGUMENT, 0);
            $collection = new ANPTTabCollection();

            $this->deletionProcess($id > 0 ? $collection->byId($id)->getFirst() : null);
        }
        $this->context->smarty->assign(array(
            'an_renderTabList' => $this->renderTabList(),
            'an_renderMultieditForms' => $this->renderMultieditForms(),
            'an_renderSettings' => $this->renderConfigForm(),
            'an_renderDesign' => $this->renderDesignForm(),
            'active_tab' => $tab_value,
            'an_languages' => implode(',', Language::getLanguages(1, 0, 1))
        ));

        return $this->display(__FILE__, $this->views_prefix_admin.'tabs.tpl');
    }

    protected function renderTabList()
    {
        $this->context->smarty->assign(array(
            'collection' => new ANPTTabCollection(),
            'edit_url' => Context::getContext()->link->getAdminLink('AdminModules').
                '&configure='.$this->name.'&'.self::EDIT_ARGUMENT,
            'delete_url' => Context::getContext()->link->getAdminLink('AdminModules').
                '&configure='.$this->name.'&'.self::DELETE_ARGUMENT
        ));

        return $this->display(__FILE__, $this->views_prefix_admin.'tab_list.tpl');
    }

    protected function renderMultieditForms()
    {
        $collection = new ANPTTabCollection();
        $collection->loadDefaultContent();

        $tree = new HelperTreeCategories('associated-categories-tree-'.uniqid(), $this->l('Associated categories'));
        $tree->setRootCategory((int)Category::getRootCategory()->id)
            ->setUseCheckBox(true)
            ->setUseSearch(true);

        $ret=$this->getHelperFormPartial($collection, false);


        return $tree->render().$ret;
    }

    protected function renderDesignForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = $this->getParam('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = self::DESIGN_SUBMIT;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => array(
                self::CONFIG_BACK_COLOR => $this->getParam(self::CONFIG_BACK_COLOR),
                self::CONFIG_FONT_COLOR => $this->getParam(self::CONFIG_FONT_COLOR),
                self::CONFIG_SELECTED_BACK_COLOR => $this->getParam(self::CONFIG_SELECTED_BACK_COLOR),
                self::CONFIG_SELECTED_FONT_COLOR => $this->getParam(self::CONFIG_SELECTED_FONT_COLOR),
            ),
            'languages' => $this->languages,
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array(
            array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('COLORS'),
                        'icon' => 'icon-cogs',
                    ),
                    'input' => array(
                        array(
                            'col' => 6,
                            'type' => 'color',
                            'name' => self::CONFIG_BACK_COLOR,
                            'label' => $this->l('Tab background'),
                        ),
                        array(
                            'col' => 6,
                            'type' => 'color',
                            'name' => self::CONFIG_FONT_COLOR,
                            'label' => $this->l('Tab font'),
                        ),
                        array(
                            'col' => 6,
                            'type' => 'color',
                            'name' => self::CONFIG_SELECTED_BACK_COLOR,
                            'label' => $this->l('Selected tab background'),
                        ),
                        array(
                            'col' => 6,
                            'type' => 'color',
                            'name' => self::CONFIG_SELECTED_FONT_COLOR,
                            'label' => $this->l('Selected tab font'),
                        ),

                    ),
                    'submit' => array(
                        'title' => $this->l('Save'),
                    ),
                    'buttons' => array(
                        array(
                            'type' => 'submit',
                            'title' => $this->l('Set default settings'),
                            'name' => 'setDefaultDesign',
                            'icon' => 'process-icon-save',
                        ),
                    ),
                ),
            )
        ));
    }

    protected function renderConfigForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = $this->getParam('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = self::CONFIGURATION_SUBMIT;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');


        $helper->tpl_vars = array(
            'fields_value' => array(
                self::VIEW_TYPE => $this->getParam(self::VIEW_TYPE . '_' . $this->context->shop->id)
            ),
            'languages' => $this->languages,
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array(
            array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('Settings'),
                        'icon' => 'icon-cogs',
                    ),
                    'input' => array(
                        array(
                            'col' => 6,
                            'type' => 'select',
                            'desc' => $this->l('Select a view type'),
                            'name' => self::VIEW_TYPE,
                            'label' => $this->l('View type'),
                            'options' => array(
                                'query' => array(
                                    array(
                                        'value' => self::VIEW_TYPE_TABS,
                                        'name' => 'Tabs'
                                    ),
                                    array(
                                        'value' => self::VIEW_TYPE_BLOCK,
                                        'name' => 'Blocks'
                                    ),
                                    array(
                                        'value' => self::VIEW_TYPE_ACCORDION,
                                        'name' => 'Accordion'
                                    )
                                ),
                                'id' => 'value',
                                'name' => 'name'
                            ),
                        )
                    ),
                    'submit' => array(
                        'title' => $this->l('Save'),
                    ),

                ),
            )
        ));
    }

    protected function getParam($key, $value = null)
    {
        return $value === null ?
            Configuration::get(self::PREFIX.$key) : Configuration::updateValue(self::PREFIX.$key, $value);
    }

    protected function renderEditForm(ANPTTab $tab = null)
    {
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper = new HelperForm();

        $helper->module = $this;

        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        $helper->title = $this->displayName;
        $helper->submit_action = $this->submit_action;

        $fields_form = array(
            array(
                'form' => array(
                    'legend' => array(
                        'title' => !isset($tab) ? $this->l('Add new tab') : $this->l('Edit tab '.$tab->name),
                    ),
                    'input' => $this->getEditDefaultFormInputs($helper, $tab),
                    'submit' => array(
                        'title' => !isset($tab) ? $this->l('Add') : $this->l('Save'),
                    )
                )
            )
        );



        $helper->languages = $this->languages;
        $helper->default_form_language = $this->context->language->id ? $this->context->language->id :(int)Configuration::get('PS_LANG_DEFAULT');
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
        );

        return $helper->generateForm($fields_form);
    }

    protected function createDefaultContentKey($key)
    {
        return mb_substr($key, self::DEFAULT_CONTENT_OFFSET);
    }

    protected function createContentKey($key, $prefix = null)
    {
        $contentKey = mb_substr($key, self::CONTENT_OFFSET);
        if ($prefix) {
            $contentKey = str_replace('_'.$prefix, '', $contentKey);
        }

        return $contentKey;
    }

    protected function getEditDefaultFormInputs($helper, ANPTTab $tab = null)
    {
        $fields = $this->getEditDefaultFormInputFields();

        if ($tab !== null) {
            $helper->fields_value[self::COMMON_ID] = $tab->id;
            $defaultContentFields = $this->getDefaultContentFields();
            foreach ($fields as $key => $item) {
                if (isset($item['lang']) && $item['lang']) {
                    if (in_array($key, $defaultContentFields)) {
                        $_value = array();
                        foreach ($this->languages as $lang) {
                            $id_lang = (int)$lang['id_lang'];
                            $_value[$id_lang] = '';
                        }

                        if ($tab->default_content->count() != 0) {
                            foreach ($tab->default_content as $content) {
                                $contentKey = $this->createDefaultContentKey($key);
                                $value = $content->{$contentKey};
                            }
                        }

                        if (!is_array($value)) {
                            $value = $_value;
                        }

                        foreach ($value as $lang => $_value) {
                            $helper->fields_value[$key][$lang] = $_value;
                        }
                    } else {
                        foreach ($this->languages as $lang) {
                            $id_lang = (int)$lang['id_lang'];
                            $helper->fields_value[$key][$id_lang] = $tab->{$key};
                        }
                    }
                } else {
                    if (in_array($key, $this->getDefaultContentFields())) {
                        if ($tab->default_content->count() == 0) {
                            continue;
                        }

                        foreach ($tab->default_content as $content) {
                            $contentKey = $this->createDefaultContentKey($key);
                            $helper->fields_value[$key] = $content->{$contentKey};
                        }
                    } else {
                        $helper->fields_value[$key] = $tab->{$key};
                    }
                }
            }
        }

        return $fields;
    }


    protected function getEditDefaultFormInputFields()
    {
        return array(
            self::COMMON_ID => array(
                'type' => 'hidden',
                'name' => self::COMMON_ID
            ),
            self::COMMON_NAME => array(
                'col' => 3,
                'type' => 'text',
                'name' => self::COMMON_NAME,
                'label' => $this->l('Tab name'),
                'hint' => $this->l("The name should not be empty"),
                'value' => '',
                'required' => true
            ),
            self::TAB_TYPE => array(
                'col' => 3,
                'type' => 'text',
                'name' => self::TAB_TYPE,
                'label' => $this->l('Tab type'),
                'hint' => $this->l(""),
                'disabled' => true,
                'required' => false
            ),
            self::TAB_TYPE => array(
                'col' => 6,
                'type' => 'select',
                'desc' => $this->l('Select tab type'),
                'name' => self::TAB_TYPE,
                'class' => 'select_tab',
                'label' => $this->l('Tab type'),
                'options' => array(
                    'query' => array(
                        array(
                            'value' => self::TAB_TYPE_CONTENT,
                            'name' => 'Content'
                        ),
                        array(
                            'value' => self::TAB_TYPE_CONTACT,
                            'name' => 'Contact form'
                        ),
                        array(
                            'value' => self::TAB_TYPE_PRODUCTS,
                            'name' => 'Product combinations'
                        )
                    ),
                    'id' => 'value',
                    'name' => 'name'
                ),
            ),
            self::DEFAULT_CONTENT_TITLE => array(
                'col' => 9,
                'type' => 'text',
                'name' => self::DEFAULT_CONTENT_TITLE,
                'label' => $this->l('Tab display name'),
                'lang' => true,
                'value' => '',
                'required' => true
            ),
            self::DEFAULT_CONTENT_CONTENT => array(
                'col' => 9,
                'class' => 'tab_type tab_content',
                'type' => 'textarea',
                'autoload_rte' => true,
                'name' => self::DEFAULT_CONTENT_CONTENT,
                'label' => $this->l('Tab default content'),
                'lang' => true,
                'value' => '',
            )
        );
    }

    protected function getEditFormInputs($helper, ANPTTab $tab, $unset = true)
    {
        if ($tab === null || $tab->id <= 0) {
            return array();
        }

        $fields = $this->getEditFormInputFields($tab);
        $content_to_parse = $tab->content;

        if ($tab->content->count() == 0) {
            if ($tab->default_content->count() == 0) {
                return $fields;
            }

            $content_to_parse = $tab->default_content;
        }

        $content_active_argument = self::CONTENT_ACTIVE.'_'.$tab->id;
        $content_id_argument = self::CONTENT_ID.'_'.$tab->id;

        if ($tab->content->count() != 0) {
            if ($tab->content->rewind() || $tab->content->valid()) {
                $helper->fields_value[$content_active_argument] = (int)$tab->content->current()->active;
                $helper->fields_value[$content_id_argument] = (int)$tab->content->current()->id;
            }
        }

        $fields_buffer = array($fields[$content_active_argument], $fields[$content_id_argument]);
        if ($unset) {
            unset($fields[$content_active_argument]);
            unset($fields[$content_id_argument]);
        }

        foreach ($fields as $key => $item) {
            if (isset($item['lang']) && $item['lang']) {
                foreach ($content_to_parse as $content) {
                    $contentKey = $this->createContentKey($key, $tab->id);
                    $value = $content->{$contentKey};
                    foreach ($this->languages as $lang) {
                        $helper->fields_value[$key][$lang['id_lang']] =
                            array_key_exists($lang['id_lang'], $value) ? $value[$lang['id_lang']] : '';
                    }
                }
            } else {
                foreach ($content_to_parse as $content) {
                    $contentKey = $this->createContentKey($key, $tab->id);
                    $helper->fields_value[$key] = $content->{$contentKey};
                }
            }
        }

        $fields[$content_active_argument] = $fields_buffer[0];
        $fields[$content_id_argument] = $fields_buffer[1];
        $helper->fields_value[self::TAB_TYPE . '_' . $tab->id] = $tab->type;

        $helper->fields_value['anps_theme_url'] =
            $this->context->link->getAdminLink(self::AJAX_CONTROLLER_NAME).'&ajax';

        return $fields;
    }

    protected function getEditFormInputFields(ANPTTab $tab)
    {
        $fields = array(
            self::CONTENT_ID.'_'.$tab->id => array(
                'type' => 'hidden',
                'name' => self::CONTENT_ID.'_'.$tab->id,
                'value' => '0',
            ),
            'token' => array(
                'type' => 'hidden',
                'name' => 'anps_theme_url'
            ),
            self::TAB_TYPE . '_' . $tab->id => array(
                'type' => 'hidden',
                'name' => self::TAB_TYPE . '_' . $tab->id,
            ),
            self::CONTENT_TITLE.'_'.$tab->id => array(
                'col' => 9,
                'type' => 'text',
                'required' => true,
                'name' => self::CONTENT_TITLE.'_'.$tab->id,
                'label' => $this->l('Tab display name'),
                'lang' => true,
                'value' => '',
                'required' => true
            ),
            self::CONTENT_ACTIVE.'_'.$tab->id => array(
                'type' => 'switch',
                'label' => $this->l('Apply to this product'),
                'name' => self::CONTENT_ACTIVE.'_'.$tab->id,
                'is_bool' => true,
                'values' => array(
                    array(
                        'id' => 'active_on',
                        'value' => 1,
                        'label' => $this->l('Yes')
                    ),
                    array(
                        'id' => 'active_off',
                        'value' => 0,
                        'label' => $this->l('No')
                    )
                ),
                'value' => 1
            )
        );
        if ($tab->type == 'content') {
            $fields[self::CONTENT_CONTENT.'_'.$tab->id] = array(
                'col' => 9,
                'type' => 'textarea',
                'name' => self::CONTENT_CONTENT.'_'.$tab->id,
                'label' => $this->l('Content'),
                'lang' => true,
                'autoload_rte' => true,
                'value' => '',
            );
        }
        return $fields;
    }

    protected function getEditFormFields()
    {
        return array_merge(array(self::COMMON_NAME), $this->getDefaultContentFields());
    }

    protected function getDefaultContentFields()
    {
        return array(
            self::DEFAULT_CONTENT_TITLE,
            self::DEFAULT_CONTENT_CONTENT,
            self::TAB_TYPE_DEFAULT,
        );
    }

    protected function getContentFields()
    {
        return array(
            self::CONTENT_TITLE,
            self::CONTENT_CONTENT,
            self::CONTENT_ACTIVE
        );
    }

    protected function postProcess()
    {
        $id = (int)Tools::getValue('id');
        $collection = new ANPTTabCollection();

        $tab = $id > 0 ? $collection->byId($id)->getFirst() : new ANPTTab($id);

        $content_collection = new ANPTTabDefaultContentCollection();
        $content = isset($tab->id) && $tab->id > 0 ? $content_collection->byTab($tab->id)->getFirst() : null;
        $content_collection->clear();

        foreach ($this->languages as $language) {
            $default_content = new ANPTTabDefaultContent($content ? $content->id : null, (int)$language['id_lang']);

            foreach ($this->getDefaultContentFields() as $field) {
                $contentKey = $this->createDefaultContentKey($field);
                $default_content->{$contentKey} = Tools::getValue($field.'_'.$language['id_lang']);
            }

            $content_collection->attach($default_content);
        }

        $tab->default_content = $content_collection;
        $tab->name = Tools::getValue('name', '');
        $tab->type = Tools::getValue('type', '');

        $this->context->smarty->assign(array(
            ($tab->id > 0 ? 'update_status' : 'insertion_status') => $tab->save()
        ));
    }

    protected function deletionProcess($tab = null)
    {
        if (!($tab instanceof ANPTTab)) {
            return false;
        }

        $this->context->smarty->assign(array(
            'deletion_status' => (bool)$tab->delete()
        ));
    }

    protected function isViewDefault()
    {
        return $this->getParam(self::VIEW_TYPE . '_' . $this->context->shop->id) == self::VIEW_TYPE_DEFAULT;
    }

    public function hookBackOfficeHeader()
    {
        if (in_array($this->name, array(Tools::getValue('configure', ''), Tools::getValue('module_name', '')))) {
            $this->context->controller->addJquery();
            $this->context->controller->addJS($this->_path.'views/js/tab.js');
            $this->context->controller->addJS($this->_path.'views/js/tab_collection.js');
            $this->context->controller->addJS($this->_path.'views/js/Sortable.min.js');
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
        $this->context->controller->addJS($this->_path.'views/js/lang_fix.js');
    }

    public function getCombinationsView($product)
    {
        $productsAttr = array();
        $id_lang = $this->context->language->id;
        $title_combinations = array();
        $config = array(
            'table_template'         => 'table-responsive',
            'display_image'          => true,
            'display_reference'      => true,
            'display_attributes'     => true,
            'combine_attributes'     => true,
            'display_availability'   => false,
            'display_quantity'       => false,
            'display_price'          => true,
            'display_add_to_cart'    => true,
            'display_field_quantity' => true,
            'display_sort'           => false,
            'new'                    => $this->new
        );
        $attributeCombinations = $product->getAttributeCombinations($id_lang);
        foreach ($attributeCombinations as $attributeCombination) {
            if (!$this->new) {
                $price_without_impact = $product->getPriceWithoutReduct(false, false);
            } else {
                $price_without_impact = Product::getPriceStatic(
                    (int)$product->id,
                    true,
                    $attributeCombination['id_product_attribute'],
                    2,
                    null,
                    false,
                    false,
                    $product->minimal_quantity
                );
            }

            $price = $product->getPrice(true, $attributeCombination['id_product_attribute'], 2);
            $impact = round($price - $price_without_impact, 2, PHP_ROUND_HALF_DOWN);
            $image = Product::getCombinationImageById($attributeCombination['id_product_attribute'], $id_lang);
            $productsAttr[$attributeCombination['id_product_attribute']]['comb'][] = $attributeCombination;
            $productsAttr[$attributeCombination['id_product_attribute']]['image'] = $image;
            $productsAttr[$attributeCombination['id_product_attribute']]['image']['link'] = $this->context->link->getImageLink($product->link_rewrite, $image['id_image'], Configuration::get(self::PREFIX.'image_size'));
            $productsAttr[$attributeCombination['id_product_attribute']]['image_big']['link'] = $this->context->link->getImageLink($product->link_rewrite, $image['id_image']);
            $productsAttr[$attributeCombination['id_product_attribute']]['price_without_impact_formatted'] = Tools::displayPrice($price_without_impact);
            $productsAttr[$attributeCombination['id_product_attribute']]['price_formatted'] = Tools::displayPrice($price);
            $productsAttr[$attributeCombination['id_product_attribute']]['impact'] = $impact;
            $productsAttr[$attributeCombination['id_product_attribute']]['impact_formatted'] = Tools::displayPrice($impact);
            $productsAttr[$attributeCombination['id_product_attribute']]['id_product'] = $product->id;
            $productsAttr[$attributeCombination['id_product_attribute']]['available_now'] = $product->available_now;
            $productsAttr[$attributeCombination['id_product_attribute']]['available_later'] = $product->available_later;
            $productsAttr[$attributeCombination['id_product_attribute']]['product'] = $product;

            $title_combinations[$attributeCombination['group_name']] = '';
        }

        $currency = new Currency($this->context->cart->id_currency);
        $config['sign'] = $currency->sign;

        $this->context->smarty->assign(array(
            "productData" => $productsAttr, //unwanted system behavior detected with 'product'
            "title_combinations" => $title_combinations,
            "config" => $config,
            "cart_url" => $this->context->link->getPageLink('cart'),
            "token" => Tools::getToken(false)
        ));

        if ($this->new) {
            $this->context->smarty->assign(array(
                'base_dir' => __PS_BASE_URI__
            ));
        }

        return $this->display(__FILE__, 'views/templates/hook/combinations.tpl');
    }

    public function hookHeader()
    {
        if (!$this->new) {
            $this->context->controller->addJS($this->_path.'/views/js/front/front.js');
            $this->context->controller->addJS($this->_path.'/views/js/tabs_builder.js');

            $this->context->controller->addJS($this->_path.'/views/js/tabs16.js');

            $this->context->controller->addCSS($this->_path.'/views/css/front.css');
            $this->context->controller->addCSS(_THEME_CSS_DIR_.'contact-form.css');
            $this->context->controller->addJS(_THEME_JS_DIR_.'contact-form.js');
            $this->context->controller->addJS(_PS_JS_DIR_.'validate.js');
        } else {
            $this->context->controller->registerStylesheet(
                "modules-anproductextratabs-fecss",
                "modules/{$this->name}/views/css/front.css",
                array('priority' => 150)
            );

            $this->context->controller->registerJavascript(
                "modules-anproductextratabs-builderjs",
                "modules/{$this->name}/views/js/tabs_builder.js",
                array('priority' => 200)
            );
            $this->context->controller->registerJavascript(
                "modules-anproductextratabs-fejs",
                "modules/{$this->name}/views/js/front/front.js",
                array('priority' => 200)
            );
        }
        Media::addJsDef(array(
            self::CONFIG_BACK_COLOR => $this->getParam(self::CONFIG_BACK_COLOR),
            self::CONFIG_FONT_COLOR => $this->getParam(self::CONFIG_FONT_COLOR),
            self::CONFIG_SELECTED_BACK_COLOR => $this->getParam(self::CONFIG_SELECTED_BACK_COLOR),
            self::CONFIG_SELECTED_FONT_COLOR => $this->getParam(self::CONFIG_SELECTED_FONT_COLOR),
            'tab_type' => $this->getParam(self::VIEW_TYPE . '_' . $this->context->shop->id),
        ));
    }

    public function renderContactForm()
    {
        $contactForm = new ContactControllerCore();
        $email = Tools::safeOutput(Tools::getValue(
            'from',
            ((isset($this->context->cookie) && isset($this->context->cookie->email) && Validate::isEmail($this->context->cookie->email)) ? $this->context->cookie->email : '')
        ));
        $this->context->smarty->assign(array(
            'errors' => $contactForm->errors,
            'email' => $email,
            'fileupload' => Configuration::get('PS_CUSTOMER_SERVICE_FILE_UPLOAD'),
            'max_upload_size' => (int)Tools::getMaxUploadSize()
        ));

        if (($id_customer_thread = (int)Tools::getValue('id_customer_thread')) && $token = Tools::getValue('token')) {
            $customer_thread = Db::getInstance()->getRow('
				SELECT cm.*
				FROM '._DB_PREFIX_.'customer_thread cm
				WHERE cm.id_customer_thread = '.(int)$id_customer_thread.'
				AND cm.id_shop = '.(int)$this->context->shop->id.'
				AND token = \''.pSQL($token).'\'
			');

            $order = new Order((int)$customer_thread['id_order']);
            if (Validate::isLoadedObject($order)) {
                $customer_thread['reference'] = $order->getUniqReference();
            }
            $this->context->smarty->assign('customerThread', $customer_thread);
        }

        $contactKey = md5(uniqid(microtime(), true));
        $this->context->cookie->__set('contactFormKey', $contactKey);

        $this->context->smarty->assign(array(
            'contacts' => Contact::getContacts($this->context->language->id),
            'message' => html_entity_decode(Tools::getValue('message')),
            'contactKey' => $contactKey,
        ));

        return $this->context->smarty->fetch(_PS_THEME_DIR_.'contact-form.tpl');
    }


    public function hookDisplayFooterProduct($params = null)
    {
        list($id_product, $id_shop) = $this->getProductData($params);
        $language = new Language($this->context->language->id ?
            (int)$this->context->language->id : (int)Configuration::get('PS_LANG_DEFAULT'));

        $content_collection = new ANPTTabContentCollection($language->id);
        $tabs = array();
        foreach ($content_collection->onlyActive()->byProduct($id_product)->orderByPosition() as $key => $_content) {
            $tab = array();
            $parentTab = ANPTTab::getById($_content->id_anproducttabs);
            if ($parentTab->type == self::TAB_TYPE_CONTENT) {
                $tpl_content = $_content->content;
            } elseif ($parentTab->type == self::TAB_TYPE_CONTACT) {
                $tpl_content = $this->renderContactForm();
            } elseif ($parentTab->type == self::TAB_TYPE_PRODUCTS) {
                $tpl_content = $this->getCombinationsView($params['product']);
            } else {
                return false;
            }

            $tab['id'] = $_content->id;
            $tab['title'] = $_content->title;
            $tab['content'] = $tpl_content;
            $tabs[] = $tab;
        }


        $this->context->smarty->assign(array(
            'id_lang' => $language->id,
            'languages' => $this->languages,
            'tabs' => $tabs,
            'display_type' => $this->getParam(self::VIEW_TYPE . '_' . $this->context->shop->id)
        ));

        return $this->display(
            __FILE__,
            $this->views_prefix_hook . 'tab_content.tpl'
        );
    }

    public function hookDisplayProductExtraContent($params = null)
    {
        list($id_product, $id_shop) = $this->getProductData($params);
        $language = new Language($this->context->language->id ?
            (int)$this->context->language->id : (int)Configuration::get('PS_LANG_DEFAULT'));
        $content = new ANPTTabContentCollection($language->id);
        $tabs = array();

        foreach ($content->onlyActive()->byProduct($id_product)->orderByPosition() as $key => $_content) {
            $tab = new PrestaShop\PrestaShop\Core\Product\ProductExtraContent();
            $parentTab = ANPTTab::getById($_content->id_anproducttabs);
            if ($parentTab->type == self::TAB_TYPE_CONTENT) {
                $tpl_content = $_content->content;
            } elseif ($parentTab->type == self::TAB_TYPE_CONTACT) {
                require_once _PS_MODULE_DIR_ . 'contactform/contactform.php';
                $contactForm = new Contactform();
                $urls['pages']['contact'] = $this->context->link->getPageLink('contact');
                $this->context->smarty->assign(array(
                    'urls' => $urls
                ));
                $this->context->smarty->assign($contactForm->getWidgetVariables());
                $tpl_content = $this->context->smarty->fetch(_PS_THEME_DIR_.'modules/contactform/views/templates/widget/contactform.tpl');
            } elseif ($parentTab->type == self::TAB_TYPE_PRODUCTS) {
                $tpl_content = $this->getCombinationsView($params['product']);
            } else {
                return false;
            }
            $this->context->smarty->assign(array(
                'id_lang' => $language->id,
                'languages' => $this->languages,
                'tab_content' => $tpl_content,
                'view_type' => $this->getParam(self::VIEW_TYPE . '_' . $this->context->shop->id)
            ));

            $tab->setTitle($_content->title)
                ->setContent($this->display(__FILE__, $this->views_prefix_hook.'tab_content.tpl'));
            $tabs[] = $tab;
        }

        return $tabs;
    }

    public function hookDisplayAdminProductsExtra($params = null)
    {
        $this->context->smarty->assign(array(
            $this->name.'_theme_url' => $this->context->link->getAdminLink(self::AJAX_CONTROLLER_NAME)
        ));

        list($id_product, $id_shop) = $this->getProductData($params);

        if (Validate::isLoadedObject(new Product($id_product))) {
            $collection = new ANPTTabCollection();
            $collection->loadContent($id_product, true);

            $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
            if (count($this->languages)<2) {
                $multilang = false;
            } else {
                $multilang = true;
            }
            $this->context->smarty->assign(array(
                'morenew' => $this->morenew,
                'new' => $this->new,
                'id_lang' => $language->id,
                'id_shop' => $id_shop,
                'id_product' => $id_product,
                'languages' => $this->languages,
                'multilang' => $multilang,
                'default_language' => Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'))
            ));

            return $this->display(__FILE__, $this->views_prefix_admin.'product_tab_header.tpl')
                .($this->new ? $this->getFormPartial($collection) : $this->getHelperFormPartial($collection))
                .$this->display(__FILE__, $this->views_prefix_admin.'product_tab_footer.tpl');
        } else {
            return $this->displayError($this->l('You must save this product before managing tabs.'));
        }
    }

    protected function getFormPartial(ANPTTabCollection $tab_collection, $unset = true)
    {
        $ret = '';
        foreach ($tab_collection as $tab) {
            $fields_value = new StdClass();

            $this->context->smarty->assign(array(
                'tab' => $tab,
                'languages' => $this->languages,
                'fields' => $this->getEditFormInputs($fields_value, $tab),
                'fields_value' => isset($fields_value->fields_value) ? $fields_value->fields_value : array()
            ));

            $ret .= $this->display(__FILE__, $this->views_prefix_admin.'form.tpl');
        }

        return $ret;
    }

    protected function getHelperFormPartial(ANPTTabCollection $tab_collection, $unset = true)
    {
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $default_lang_id = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper = new HelperForm();

        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->base_folder = realpath($this->context->smarty->getTemplateDir(0) . '../../default/template') . '/';
        $helper->base_tpl = 'helpers/form/form.tpl';
        $helper->first_call = false;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language    = $this->context->language->id ? $this->context->language->id : $default_lang_id;

        $helper->title = $this->displayName;
        $helper->submit_action = 'submit_tabs';

        $fields_form = array();

        foreach ($tab_collection as $tab) {
            $fields_form[] = array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('Edit ' . ANPTTab::$values[$tab->type] . ' ' .$tab->name),
                    ),
                    'input' => $this->getEditFormInputs($helper, $tab, $unset),
                    'submit' => array(
                        'title' => $this->l('Save'),
                        'class' => 'btn btn-success pull-right submit_tab_'.$tab->id,
                        'id' => $tab->id
                    )
                )
            );
        }


        $helper->languages = $this->languages;
        $helper->default_form_language = (int)$language->id;
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code,
            ),
            'languages' => $this->languages,
            'id_language' => $language->id,
        );

        return $helper->generateForm($fields_form);
    }

    protected function getProductData($params = null)
    {
        return array(
            isset($params['id_product']) ? (int)$params['id_product'] : (int)Tools::getValue('id_product'),
            (int)Context::getContext()->shop->id
        );
    }
}
