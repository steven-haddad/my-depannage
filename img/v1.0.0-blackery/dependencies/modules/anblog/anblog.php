<?php
/**
 * 2018 Anvanto
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
 *  @copyright  2018 anvanto.com

 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    // module validation
    exit;
}

require_once _PS_MODULE_DIR_.'anblog/loader.php';

class anblog extends Module
{
    private static $an_xml_fields = array(
        'title',
        'guid',
        'description',
        'author',
        'comments',
        'pubDate',
        'source',
        'link',
        'content'
    );
    public $base_config_url;
    private $_html = '';

    public function __construct()
    {
        $currentIndex = '';

        $this->name = 'anblog';
        $this->tab = 'front_office_features';
        $this->version = '3.0.2';
        $this->author = 'Anvanto';
        $this->controllers = array('blog', 'category', 'list');
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->new174 = version_compare(_PS_VERSION_, '1.7.4.0', '>=') ?  true : false;

        $this->secure_key = Tools::encrypt($this->name);

        parent::__construct();

        $this->base_config_url = $currentIndex.'&configure='.$this->name.'&token='.Tools::getValue('token');
        $this->displayName = $this->l('AN Blog Management');
        $this->description = $this->l('Manage Blog Content');
    }

    /**
     * Uninstall
     */
    private function uninstallModuleTab($class_sfx = '')
    {
        $tab_class = 'Admin'.Tools::ucfirst($this->name).Tools::ucfirst($class_sfx);

        $id_tab = Tab::getIdFromClassName($tab_class);
        if ($id_tab != 0) {
            $tab = new Tab($id_tab);
            $tab->delete();
            return true;
        }
        return false;
    }

    /**
     * Install Module Tabs
     */
    private function installModuleTab($title, $class_sfx = '', $parent = '')
    {
        $class = 'Admin'.Tools::ucfirst($this->name).Tools::ucfirst($class_sfx);
        @copy(_PS_MODULE_DIR_.$this->name.'/logo.gif', _PS_IMG_DIR_.'t/'.$class.'.gif');
        if ($parent == '') {
            // validate module
            $position = Tab::getCurrentTabId();
        } else {
            // validate module
            $position = Tab::getIdFromClassName($parent);
        }

        $tab1 = new Tab();
        $tab1->class_name = $class;
        $tab1->module = $this->name;
        $tab1->id_parent = (int)$position;
        $langs = Language::getLanguages(false);
        foreach ($langs as $l) {
            // validate module
            $tab1->name[$l['id_lang']] = $title;
        }
        $tab1->add(true, false);
    }

    /**
     * @see Module::install()
     */
    public function install()
    {
        /* Adds Module */
        if (parent::install() && $this->registerANHook()) {
            $res = true;

            Configuration::updateValue('ANBLOG_CATEORY_MENU', 1);
            Configuration::updateValue('ANBLOG_IMAGE_TYPE', 'jpg');
            
            Configuration::updateValue('ANBLOG_DASHBOARD_DEFAULTTAB', '#fieldset_0');
            Configuration::updateValue('link_rewrite', 'blog');
            /* Creates tables */
            $res &= $this->createTables();
            $res &= $this->installConfig();
            $res &= $this->registerHook('displayLeftColumn');
            
            Configuration::updateValue('AP_INSTALLED_ANBLOG', '1');
            //DONGND: check thumb column, if not exist auto add
            if (Db::getInstance()->executeS(
                'SHOW TABLES LIKE \'%anblog_blog%\''
            )
                && count(
                    Db::getInstance()->executes(
                        'SELECT "thumb" FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = "'._DB_NAME_.'"
                         AND TABLE_NAME = "'._DB_PREFIX_.'anblog_blog" AND COLUMN_NAME = "thumb"'
                    )
                )<1
            ) {
                Db::getInstance()->execute(
                    'ALTER TABLE `'._DB_PREFIX_.'anblog_blog` ADD `thumb` varchar(255) DEFAULT NULL'
                );
            }

            $id_parent = Tab::getIdFromClassName('IMPROVE');
            
            $class = 'Admin'.Tools::ucfirst($this->name).'Management';
            $tab1 = new Tab();
            $tab1->class_name = $class;
            $tab1->module = $this->name;
            $tab1->id_parent = $id_parent;
            $langs = Language::getLanguages(false);
            $this->registerHook('displayHome');
            AnblogConfig::updateHooksValues(
                array (
                        'displayHome' =>
                                array (
                                        'status' => '1',
                                        'postCount' => '3',
                                    )),
                $this->context->shop->getContextShopID()
            );
            foreach ($langs as $l) {
                // validate module
                $tab1->name[$l['id_lang']] = $this->l('AN Blog Management');
            }
            $tab1->add(true, false);
            
            // insert icon for tab
            Db::getInstance()->execute(
                ' UPDATE `'._DB_PREFIX_.'tab` SET `icon` = "create" WHERE `id_tab` = "'.(int)$tab1->id.'"'
            );
            
            $this->installModuleTab(
                'Dashboard',
                'dashboard',
                'AdminAnblogManagement'
            );
            $this->installModuleTab(
                'Categories',
                'categories',
                'AdminAnblogManagement'
            );
            $this->installModuleTab(
                'Posts',
                'blogs',
                'AdminAnblogManagement'
            );
            $this->installModuleTab(
                'Comments',
                'comments',
                'AdminAnblogManagement'
            );
            $this->installModuleTab(
                'Module configuration',
                'module',
                'AdminAnblogManagement'
            );

            $this->moveImageFolder();
            
            return (bool)$res;
        }
        return false;
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (file_exists(_PS_THEME_DIR_.'/views/css/modules/anblog/assets/admin/blogmenu.css')) {
            $this->context->controller->addCss($this->_path.'views/assets/admin/blogmenu.css');
        } else {
            $this->context->controller->addCss($this->_path.'views/css/admin/blogmenu.css');
        }
    }

    public function getContent()
    {
        if (Tools::isSubmit('submitBlockCategories')) {
            // validate module
            if (Tools::getValue('ANBLOG_CATEORY_MENU')) {
                $this->registerHook('displayLeftColumn');
            }
            Configuration::updateValue('ANBLOG_CATEORY_MENU', (int)Tools::getValue('ANBLOG_CATEORY_MENU'));
            Configuration::updateValue('ANBLOG_IMAGE_TYPE', Tools::getValue('ANBLOG_IMAGE_TYPE'));
        }
        //DONGND:: correct module
        if (Tools::getValue('correctmodule')) {
            $this->correctModule();
        }
        
        if (Tools::getValue('success')) {
            switch (Tools::getValue('success')) {
                case 'correct':
                    $this->_html .= $this->displayConfirmation($this->l('Correct Module is successful'));
                    break;
            }
        }
        $this->context->smarty->assign("adminLink", $this->context->link->getAdminLink('AdminModules'));
        $this->_html .= $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'anblog/views/templates/admin/anblog_blogs/helpers/form/prerender.tpl');
        return $this->_html.$this->renderForm();
    }

    /**
     * @return array
     */
    public static function getHooksList()
    {
        $filePath=_PS_MODULE_DIR_ . 'anblog/config_hooks.php';
        if (file_exists($filePath)) {
            return include $filePath;
        } else {
            return array();
        }
    }

    /**
     * @return array
     */
    public static function getHooksQuery()
    {
        $hooksQuery=array();

        foreach (self::getHooksList() as $hookname) {
            $hooksQuery[]=array('name' => $hookname , 'value' => $hookname);
        }

        return $hooksQuery;
    }

    public function getTreeForApPageBuilder($selected)
    {
        $cat = new Anblogcat();
        return $cat->getTreeForApPageBuilder($selected);
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Blog category tree'),
                        'name' => 'ANBLOG_CATEORY_MENU',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Image type'),
                    'name' => 'ANBLOG_IMAGE_TYPE',
                    'options' => array(
                        'query' => array(
                            array(
                                'id' => 'jpg',
                                'name' => $this->l('jpg')
                            ),
                            array(
                                'id' => 'png',
                                'name' => $this->l('png')
                            ),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                    'desc' => $this->l('For images png type. Keep png type or optimize to jpg type'),
                )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right')
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitBlockCategories';
        $helper->currentIndex = $this->context->link->getAdminLink(
            'AdminModules',
            false
        )
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        return array(
            'ANBLOG_CATEORY_MENU' => Tools::getValue(
                'ANBLOG_CATEORY_MENU',
                Configuration::get('ANBLOG_CATEORY_MENU')
            ),
            'ANBLOG_IMAGE_TYPE' => Tools::getValue(
                'ANBLOG_IMAGE_TYPE',
                Configuration::get('ANBLOG_IMAGE_TYPE')
            ),
        );
    }

    public function _prepareHook()
    {
        $helper = AnblogHelper::getInstance();

        $category = new Anblogcat(Tools::getValue('id_anblogcat'), $this->context->language->id);

        $tree = $category->getFrontEndTree((int)$category->id_anblogcat > 1 ? $category->id_anblogcat : 1, $helper);
        $this->smarty->assign('tree', $tree);
        if ($category->id_anblogcat) {
            // validate module
            $this->smarty->assign('currentCategory', $category);
        }

        return true;
    }

    public function hookDisplayHeader()
    {
        if (file_exists(_PS_THEME_DIR_.'/views/css/modules/anblog/assets/anblog.css')) {
            $this->context->controller->addCSS(($this->_path).'views/assets/anblog.css', 'all');
        } else {
            $this->context->controller->addCSS(($this->_path).'views/css/anblog.css', 'all');
        }


        //DONGND:: update language link
        if (Tools::getValue('module') == 'anblog') {
            $langs = Language::getLanguages(false);
            if (count($langs) > 1) {
                $config = AnblogConfig::getInstance();
                $array_list_rewrite = array();
                $array_category_rewrite = array();
                $array_config_category_rewrite = array();
                $array_blog_rewrite = array();
                $array_config_blog_rewrite = array();
                $config_url_use_id = $config->get('url_use_id');
                
                $page_name = Dispatcher::getInstance()->getController();
                
                if ($page_name == 'blog') {
                    if ($config_url_use_id == 0) {
                        $id_blog = Tools::getValue('id');
                    } else {
                        $id_shop = (int)Context::getContext()->shop->id;
                        $block_rewrite = pSQL(Tools::getValue('rewrite'));
                        $sql = 'SELECT bl.id_anblog_blog FROM '._DB_PREFIX_.'anblog_blog_lang bl INNER JOIN '._DB_PREFIX_.'anblog_blog_shop bs on bl.id_anblog_blog=bs.id_anblog_blog AND id_shop='.$id_shop.' AND link_rewrite = "'.$block_rewrite.'"';
                        if ($row = Db::getInstance()->getRow($sql)) {
                            $id_blog = $row['id_anblog_blog'];
                        }
                    }
                    $blog_obj = new Anblogblog($id_blog);
                }
                
                if ($page_name == 'category') {
                    if ($config_url_use_id == 0) {
                        $id_category = Tools::getValue('id');
                    } else {
                        $id_shop = (int)Context::getContext()->shop->id;
                        $category_rewrite = pSQL(Tools::getValue('rewrite'));
                        $sql = 'SELECT cl.id_anblogcat FROM '._DB_PREFIX_.'anblogcat_lang cl INNER JOIN '._DB_PREFIX_.'anblogcat_shop cs  on cl.id_anblogcat=cs.id_anblogcat AND id_shop='.$id_shop. ' INNER JOIN '._DB_PREFIX_.'anblogcat cc  on cl.id_anblogcat=cc.id_anblogcat AND cl.id_anblogcat != cc.id_parent AND link_rewrite = "'.$category_rewrite.'"';
                        if ($row = Db::getInstance()->getRow($sql)) {
                            $id_category = $row['id_anblogcat'];
                        }
                    }
                    $blog_category_obj = new Anblogcat($id_category);
                }
                
                foreach ($langs as $lang) {
                    $array_list_rewrite[$lang['iso_code']] = $config->get('link_rewrite_'.$lang['id_lang'], 'blog');
                    
                    if (isset($id_blog)) {
                        $array_blog_rewrite[$lang['iso_code']] = $blog_obj->link_rewrite[$lang['id_lang']];
                        if ($config_url_use_id == 1) {
                            $array_config_blog_rewrite[$lang['iso_code']] = $config->get('detail_rewrite_'.$lang['id_lang'], 'detail');
                        }
                    }
                    
                    if (isset($id_category)) {
                        $array_category_rewrite[$lang['iso_code']] = $blog_category_obj->link_rewrite[$lang['id_lang']];
                        if ($config_url_use_id == 1) {
                            $array_config_category_rewrite[$lang['iso_code']] = $config->get('category_rewrite_'.$lang['id_lang'], 'category');
                        }
                    }
                };
                
                Media::addJsDef(
                    array(
                    'array_list_rewrite' => $array_list_rewrite,
                    'array_category_rewrite' => $array_category_rewrite,
                    'array_blog_rewrite' => $array_blog_rewrite,
                    'array_config_category_rewrite' => $array_config_category_rewrite,
                    'array_config_blog_rewrite' => $array_config_blog_rewrite,
                    'config_url_use_id' => $config_url_use_id
                    )
                );
            }
        }
    }

    public function hookdisplayLeftColumn()
    {
        $html = '';
        $html .= $this->leftCategoryBlog();
        $html .= $this->leftPopularBlog();
        $html .= $this->leftRecentBlog();
        $html .= $this->lefTagBlog();
        
        return $html;
    }
    
    public function leftCategoryBlog()
    {
        $html = '';


        if (Configuration::get('ANBLOG_CATEORY_MENU') && $this->_prepareHook()) {
            $html .= $this->display(__FILE__, 'views/templates/hook/categories_menu.tpl');
        }
        return $html;
    }
    
    public function leftPopularBlog()
    {
        $html = '';
        
        $config = AnblogConfig::getInstance();
        if ($config->get('show_popular_blog', 0)) {
            $limit = (int)$config->get('limit_popular_blog', 5);
            $helper = AnblogHelper::getInstance();
            $image_w = (int)$config->get('listing_leading_img_width', 690);
            $image_h = (int)$config->get('listing_leading_img_height', 300);
            $authors = array();

            $leading_blogs = array();
            if ($limit > 0) {
                $leading_blogs = AnblogBlog::getListBlogs(
                    null,
                    $this->context->language->id,
                    1,
                    $limit,
                    'hits',
                    'DESC',
                    array(),
                    true
                );
            }
            foreach ($leading_blogs as $key => $blog) {
                $blog = AnblogHelper::buildBlog($helper, $blog, $image_w, $image_h, $config, true);
                if ($blog['id_employee']) {
                    if (!isset($authors[$blog['id_employee']])) {
                        // validate module
                        $authors[$blog['id_employee']] = new Employee($blog['id_employee']);
                    }

                    if ($blog['author_name'] != '') {
                        $blog['author'] = $blog['author_name'];
                        $blog['author_link'] = $helper->getBlogAuthorLink($blog['author_name']);
                    } else {
                        $blog['author'] = $authors[$blog['id_employee']]->firstname.' '.$authors[$blog['id_employee']]->lastname;
                        $blog['author_link'] = $helper->getBlogAuthorLink($authors[$blog['id_employee']]->id);
                    }
                } else {
                    $blog['author'] = '';
                    $blog['author_link'] = '';
                }

                $leading_blogs[$key] = $blog;
            }

            $this->smarty->assign('leading_blogs', $leading_blogs);
            $html .= $this->display(__FILE__, 'views/templates/hook/left_popular.tpl');
        }
        
        return $html;
    }
    
    public function leftRecentBlog()
    {
        $html = '';
        
        $config = AnblogConfig::getInstance();
        if ($config->get('show_recent_blog', 0)) {
            $limit = (int)$config->get('limit_recent_blog', 5);
            $config = AnblogConfig::getInstance();
            $helper = AnblogHelper::getInstance();
            $image_w = (int)$config->get('listing_leading_img_width', 690);
            $image_h = (int)$config->get('listing_leading_img_height', 300);
            $authors = array();

            $leading_blogs = array();
            if ($limit > 0) {
                $leading_blogs = AnblogBlog::getListBlogs(
                    null,
                    $this->context->language->id,
                    1,
                    $limit,
                    'date_add',
                    'DESC',
                    array(),
                    true
                );
            }
            foreach ($leading_blogs as $key => $blog) {
                $blog = AnblogHelper::buildBlog($helper, $blog, $image_w, $image_h, $config, true);
                if ($blog['id_employee']) {
                    if (!isset($authors[$blog['id_employee']])) {
                        // validate module
                        $authors[$blog['id_employee']] = new Employee($blog['id_employee']);
                    }

                    if ($blog['author_name'] != '') {
                            $blog['author'] = $blog['author_name'];
                            $blog['author_link'] = $helper->getBlogAuthorLink($blog['author_name']);
                    } else {
                            $blog['author'] = $authors[$blog['id_employee']]->firstname.' '.$authors[$blog['id_employee']]->lastname;
                            $blog['author_link'] = $helper->getBlogAuthorLink($authors[$blog['id_employee']]->id);
                    }
                } else {
                    $blog['author'] = '';
                    $blog['author_link'] = '';
                }

                $leading_blogs[$key] = $blog;
            }

            $this->smarty->assign('leading_blogs', $leading_blogs);
            $html .= $this->display(__FILE__, 'views/templates/hook/left_recent.tpl');
        }
        
        return $html;
    }

    public function universalBlog($postCount)
    {

        $config = AnblogConfig::getInstance();
        $helper = AnblogHelper::getInstance();
        $image_w = (int)$config->get('listing_leading_img_width', 690);
        $image_h = (int)$config->get('listing_leading_img_height', 300);
        $authors = array();

        $articles = array();
        if ($postCount > 0) {
            $articles = AnblogBlog::getListBlogs(
                null,
                $this->context->language->id,
                1,
                $postCount,
                'date_add',
                'DESC',
                array(),
                true
            );
        }
        foreach ($articles as $key => $article) {
            $article = AnblogHelper::buildBlog($helper, $article, $image_w, $image_h, $config, true);
            if ($article['id_employee']) {
                if (!isset($authors[$article['id_employee']])) {
                    // validate module
                    $authors[$article['id_employee']] = new Employee($article['id_employee']);
                }

                if ($article['author_name'] != '') {
                    $article['author'] = $article['author_name'];
                    $article['author_link'] = $helper->getBlogAuthorLink($article['author_name']);
                } else {
                    $article['author'] = $authors[$article['id_employee']]->firstname.' '.$authors[$article['id_employee']]->lastname;
                    $article['author_link'] = $helper->getBlogAuthorLink($authors[$article['id_employee']]->id);
                }
            } else {
                $article['author'] = '';
                $article['author_link'] = '';
            }

            $articles[$key] = $article;
        }
        $this->smarty->assign(
            array(
            'articles' => $articles,
            'config' => $config,
            'title'  => $config->get('hook_header_' . $this->context->language->id, ''),
            'columnCount' => $config->get('hook_column', 3)
            )
        );
        if ($this->new174) {
            return $this->display(__FILE__, 'views/templates/hook/universal174.tpl');
        } else {
            return $this->display(__FILE__, 'views/templates/hook/universal.tpl');
        }
    }

    public function lefTagBlog()
    {
        
        $html = '';
        $helper = AnblogHelper::getInstance();
        
        $config = AnblogConfig::getInstance();
        if ($config->get('show_all_tags', 0)) {
            $leading_blogs = AnblogBlog::getListBlogs(
                null,
                $this->context->language->id,
                1,
                100000,
                'date_add',
                'DESC',
                array(),
                true
            );

            $tags_temp = array();
            foreach ($leading_blogs as $value) {
                $tags_temp = array_merge($tags_temp, explode(",", $value['tags']));
            }

            $tags_temp = array_unique($tags_temp);
            $tags = array();
            foreach ($tags_temp as $tag_temp) {
                $tags[] = array(
                    'name' => $tag_temp,
                    'link' => $helper->getBlogTagLink($tag_temp)
                );
            }
            
            $this->smarty->assign('anblogtags', $tags);
            $html .= $this->display(__FILE__, 'views/templates/hook/left_anblogtags.tpl');
        }
        
        return $html;
    }


    protected function getCacheId($name = null)
    {
        $name = ($name ? $name.'|' : '').implode('-', Customer::getGroupsStatic($this->context->customer->id));
        return parent::getCacheId($name);
    }

    public function hookdisplayRightcolumn($params)
    {
        return $this->hookdisplayLeftColumn($params);
    }

    /**
     * @see Module::uninstall()
     */
    public function uninstall()
    {
        if (parent::uninstall()) {
            $res = true;

            $this->uninstallModuleTab('management');
            $this->uninstallModuleTab('dashboard');
            $this->uninstallModuleTab('categories');
            $this->uninstallModuleTab('blogs');
            $this->uninstallModuleTab('comments');
            $this->uninstallModuleTab('module');
            
            $res &= $this->deleteTables();
            $this->deleteConfiguration();

            return (bool)$res;
        }
        return false;
    }

    public function deleteTables()
    {
        return Db::getInstance()->execute(
            '
            DROP TABLE IF EXISTS
            `'._DB_PREFIX_.'anblogcat`,
            `'._DB_PREFIX_.'anblogcat_lang`,
            `'._DB_PREFIX_.'anblogcat_shop`,
            `'._DB_PREFIX_.'anblog_comment`,
            `'._DB_PREFIX_.'anblog_blog`,
            `'._DB_PREFIX_.'anblog_blog_lang`,
            `'._DB_PREFIX_.'anblog_hooks`,
            `'._DB_PREFIX_.'anblog_blog_shop`'
        );
    }

    public function deleteConfiguration()
    {
        Configuration::deleteByName('ANBLOG_CATEORY_MENU');
        Configuration::deleteByName('ANBLOG_IMAGE_TYPE');
        
        Configuration::deleteByName('ANBLOG_DASHBOARD_DEFAULTTAB');
        Configuration::deleteByName('ANBLOG_CFG_GLOBAL');
        return true;
    }

    /**
     * Creates tables
     */
    protected function createTables()
    {
        if ($this->_installDataSample()) {
            return true;
        }
        $res = 1;
        include_once dirname(__FILE__).'/install/install.php';
        return $res;
    }

    private function _installDataSample()
    {
        if (!file_exists(_PS_MODULE_DIR_.'appagebuilder/libs/ANDataSample.php')) {
            return false;
        }
        include_once _PS_MODULE_DIR_.'appagebuilder/libs/ANDataSample.php';

        $sample = new Datasample(1);
        return $sample->processImport($this->name);
    }

    protected function installSample()
    {
        $res = 1;
        include_once dirname(__FILE__).'/install/sample.php';
        return $res;
    }

    protected function installConfig()
    {
        $res = 1;
        include_once dirname(__FILE__).'/install/config.php';
        return $res;
    }


    /**
     * Show correct re_write url on BlockLanguage module
     * http://ps_1609_test/vn/index.php?controller=blog?id=9&fc=module&module=anblog
     *     $default_rewrite = array(
      '1' => 'http://ps_1609_test/en/blog/lang-en-b9.html',
      '2' => 'http://ps_1609_test/vn/blog/lang-vn-b9.html',
      '3' => 'http://ps_1609_test/cb/blog/lang-cb-b9.html',
      );
     */
    public function hookDisplayBanner()
    {
        if (Module::isEnabled('blocklanguages')) {
            $default_rewrite = array();
            $module = Validate::isModuleName(Tools::getValue('module')) ? Tools::getValue('module') : '';
            $controller = Tools::getValue('controller');
            if ($module == 'anblog' && $controller == 'blog' && ($id_blog = (int)Tools::getValue('id'))) {
                $languages = Language::getLanguages(true, $this->context->shop->id);
                if (!count($languages)) {
                    return false;
                }
                $link = new Link();

                foreach ($languages as $lang) {
                    $config = AnblogConfig::getInstance();
                    $config->cur_id_lang = $lang['id_lang'];

                    $cur_key = 'link_rewrite'.'_'.Context::getContext()->language->id;
                    $cur_prefix = '/'.$config->cur_prefix_rewrite = $config->get($cur_key, 'blog').'/';

                    $other_key = 'link_rewrite'.'_'.$lang['id_lang'];
                    $other_prefix = '/'.$config->cur_prefix_rewrite = $config->get($other_key, 'blog').'/';

                    $blog = new AnblogBlog($id_blog, $lang['id_lang']);
                    $temp_link = $link->getModuleLink(
                        $module,
                        $controller,
                        array('id' => $id_blog, 'rewrite' => $blog->link_rewrite),
                        null,
                        $lang['id_lang']
                    );
                    $default_rewrite[$lang['id_lang']] = str_replace($cur_prefix, $other_prefix, $temp_link);
                }
            } elseif ($module == 'anblog' && $controller == 'category' && ($id_blog = (int)Tools::getValue('id'))) {
                $languages = Language::getLanguages(true, $this->context->shop->id);
                if (!count($languages)) {
                    return false;
                }
                $link = new Link();

                foreach ($languages as $lang) {
                    $config = AnblogConfig::getInstance();
                    $config->cur_id_lang = $lang['id_lang'];

                    $cur_key = 'link_rewrite'.'_'.Context::getContext()->language->id;
                    $cur_prefix = '/'.$config->cur_prefix_rewrite = $config->get($cur_key, 'blog').'/';

                    $other_key = 'link_rewrite'.'_'.$lang['id_lang'];
                    $other_prefix = '/'.$config->cur_prefix_rewrite = $config->get($other_key, 'blog').'/';

                    $blog = new Anblogcat($id_blog, $lang['id_lang']);
                    $temp_link = $link->getModuleLink(
                        $module,
                        $controller,
                        array('id' => $id_blog, 'rewrite' => $blog->link_rewrite),
                        null,
                        $lang['id_lang']
                    );
                    $default_rewrite[$lang['id_lang']] = str_replace($cur_prefix, $other_prefix, $temp_link);
                }
            } elseif ($module == 'anblog' && $controller == 'list') {
                $languages = Language::getLanguages(true, $this->context->shop->id);
                if (!count($languages)) {
                    return false;
                }
                $link = new Link();

                foreach ($languages as $lang) {
                    $config = AnblogConfig::getInstance();
                    $config->cur_id_lang = $lang['id_lang'];

                    $cur_key = 'link_rewrite'.'_'.Context::getContext()->language->id;
                    $cur_prefix = '/'.$config->cur_prefix_rewrite = $config->get($cur_key, 'blog').'';

                    $other_key = 'link_rewrite'.'_'.$lang['id_lang'];
                    $other_prefix = '/'.$config->cur_prefix_rewrite = $config->get($other_key, 'blog').'';

                    $temp_link = $link->getModuleLink($module, $controller, array(), null, $lang['id_lang']);
                    $default_rewrite[$lang['id_lang']] = str_replace($cur_prefix, $other_prefix, $temp_link);
                }
            }

            $this->context->smarty->assign('lang_an_rewrite_urls', $default_rewrite);
        }
    }


    /**
     * Hook ModuleRoutes
     */
    public function hookModuleRoutes($route = '', $detail = array())
    {
        $config = AnblogConfig::getInstance();
        $routes = array();

        $routes['module-anblog-list'] = array(
            'controller' => 'list',
            'rule' => _AN_BLOG_REWRITE_ROUTE_.'.html',
            'keywords' => array(
            ),
            'params' => array(
                'fc' => 'module',
                'module' => 'anblog'
            )
        );
        
        if (!$config->get('url_use_id', 1)) {
            // URL HAVE ID
            $routes['module-anblog-blog'] = array(
                'controller' => 'blog',
                'rule' => _AN_BLOG_REWRITE_ROUTE_.'/{rewrite}-b{id}.html',
                'keywords' => array(
                    'id' => array('regexp' => '[0-9]+', 'param' => 'id'),
                    'rewrite' => array('regexp' => '[_a-zA-Z0-9-\pL]*', 'param' => 'rewrite'),
                ),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'anblog',
                    
                )
            );

            $routes['module-anblog-category'] = array(
                'controller' => 'category',
                'rule' => _AN_BLOG_REWRITE_ROUTE_.'/{rewrite}-c{id}.html',
                'keywords' => array(
                    'id' => array('regexp' => '[0-9]+', 'param' => 'id'),
                    'rewrite' => array('regexp' => '[_a-zA-Z0-9-\pL]*', 'param' => 'rewrite'),
                ),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'anblog',
                            
                )
            );
        } else {
            // REMOVE ID FROM URL
            $category_rewrite = 'category_rewrite'.'_'.Context::getContext()->language->id;
            $category_rewrite = $config->get($category_rewrite, 'category');
            $detail_rewrite = 'detail_rewrite'.'_'.Context::getContext()->language->id;
            $detail_rewrite = $config->get($detail_rewrite, 'detail');

            $routes['module-anblog-blog'] = array(
                'controller' => 'blog',
                'rule' => _AN_BLOG_REWRITE_ROUTE_.'/'.$detail_rewrite.'/{rewrite}.html',
                'keywords' => array(
                    'id' => array('regexp' => '[0-9]+', 'param' => 'id'),
                    'rewrite' => array('regexp' => '[_a-zA-Z0-9-\pL]*', 'param' => 'rewrite'),
                ),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'anblog',
                )
            );

            $routes['module-anblog-category'] = array(
                'controller' => 'category',
                'rule' => _AN_BLOG_REWRITE_ROUTE_.'/'.$category_rewrite.'/{rewrite}.html',
                'keywords' => array(
                    'id' => array('regexp' => '[0-9]+', 'param' => 'id'),
                    'rewrite' => array('regexp' => '[_a-zA-Z0-9-\pL]*', 'param' => 'rewrite'),
                ),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'anblog',
                )
            );
        }
        return $routes;
    }

    /**
     * Get lastest blog for ApPageBuilder module
     *
     * @param  type $params
     * @return type
     */
    public function getBlogsFont($params)
    {
        $config = AnblogConfig::getInstance();
        $id_categories = '';
        if (isset($params['chk_cat'])) {
            // validate module
            $id_categories = $params['chk_cat'];
        }
        $order_by = isset($params['order_by']) ? $params['order_by'] : 'id_anblog_blog';
        $order_way = isset($params['order_way']) ? $params['order_way'] : 'DESC';
        $helper = AnblogHelper::getInstance();
        $limit = (int)$params['nb_blogs'];
        $blogs = AnblogBlog::getListBlogsForApPageBuilder(
            $id_categories,
            $this->context->language->id,
            $limit,
            $order_by,
            $order_way,
            array(),
            true
        );
        $authors = array();
        $image_w = (int)$config->get('listing_leading_img_width', 690);
        $image_h = (int)$config->get('listing_leading_img_height', 300);
        foreach ($blogs as $key => &$blog) {
            $blog = AnblogHelper::buildBlog($helper, $blog, $image_w, $image_h, $config, true);
            if ($blog['id_employee']) {
                if (!isset($authors[$blog['id_employee']])) {
                    $authors[$blog['id_employee']] = new Employee($blog['id_employee']);
                }
                $blog['author'] = $authors[$blog['id_employee']]->firstname.' '.$authors[$blog['id_employee']]->lastname;
                $blog['author_link'] = $helper->getBlogAuthorLink($authors[$blog['id_employee']]->id);
            } else {
                $blog['author'] = '';
                $blog['author_link'] = '';
            }
            unset($key); // validate module
        }
        return $blogs;
    }
    
    /**
     * Run only one when install/change Theme_of_AN
     */
    public function hookActionAdminBefore($params)
    {
        $this->unregisterHook('actionAdminBefore');
        if (isset($params) && isset($params['controller']) && isset($params['controller']->theme_manager)) {
            // Validate : call hook from theme_manager
        } else {
            // Other module call this hook -> duplicate data
            return;
        }
        
        
        // FIX : update Prestashop by 1-Click module -> NOT NEED RESTORE DATABASE
        $ap_version = Configuration::get('AP_CURRENT_VERSION');
        if ($ap_version != false) {
            $ps_version = Configuration::get('PS_VERSION_DB');
            $versionCompare =  version_compare($ap_version, $ps_version);
            if ($versionCompare != 0) {
                // Just update Prestashop
                Configuration::updateValue('AP_CURRENT_VERSION', $ps_version);
                return;
            }
        }
        
        
        // WHENE INSTALL THEME, INSERT HOOK FROM DATASAMPLE IN THEME
        $hook_from_theme = false;
        if (file_exists(_PS_MODULE_DIR_.'appagebuilder/libs/ANDataSample.php')) {
            include_once _PS_MODULE_DIR_.'appagebuilder/libs/ANDataSample.php';
            $sample = new Datasample();
            if ($sample->processHook($this->name)) {
                $hook_from_theme = true;
            };
        }

        // INSERT HOOK FROM MODULE_DATASAMPLE
        if ($hook_from_theme == false) {
            $this->registerANHook();
        }
        
        // WHEN INSTALL MODULE, NOT NEED RESTORE DATABASE IN THEME
        $install_module = (int)Configuration::get('AP_INSTALLED_ANBLOG', 0);
        if ($install_module) {
            Configuration::updateValue('AP_INSTALLED_ANBLOG', '0');    // next : allow restore sample
            return;
        }
        
        // INSERT DATABASE FROM THEME_DATASAMPLE
        if (file_exists(_PS_MODULE_DIR_.'appagebuilder/libs/ANDataSample.php')) {
            include_once _PS_MODULE_DIR_.'appagebuilder/libs/ANDataSample.php';
            $sample = new Datasample();
            $sample->processImport($this->name);
        }
    }

    /**
     * Common method
     * Resgister all hook for module
     */
    public function registerANHook()
    {
        $res = true;
        $res &= $this->registerHook('header');
        $res &= $this->registerHook('moduleRoutes');
        $res &= $this->registerHook('displayBackOfficeHeader');
        // Multishop create new shop
        $res &= $this->registerHook('actionAdminShopControllerSaveAfter');

        return $res;
    }
    
    public function correctModule()
    {
        //DONGND:: check thumb column, if not exist auto add
        if (Db::getInstance()->executeS('SHOW TABLES LIKE \'%anblog_blog%\'')
            && count(
                Db::getInstance()->executes(
                    'SELECT "thumb" FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = "'._DB_NAME_.'"
                    AND TABLE_NAME = "'._DB_PREFIX_.'anblog_blog" AND COLUMN_NAME = "thumb"'
                )
            )<1
        ) {
            Db::getInstance()->execute(
                'ALTER TABLE `'._DB_PREFIX_.'anblog_blog` ADD `thumb` varchar(255) DEFAULT NULL'
            );
        }
        
        
        //DONGND:: check author name column, if not exist auto add
        if (Db::getInstance()->executeS('SHOW TABLES LIKE \'%anblog_blog%\'')
            && count(
                Db::getInstance()->executes(
                    'SELECT "author_name" FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = "'._DB_NAME_.'"
                     AND TABLE_NAME = "'._DB_PREFIX_.'anblog_blog" AND COLUMN_NAME = "author_name"'
                )
            )<1
        ) {
            Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'anblog_blog` ADD `author_name` varchar(255) DEFAULT NULL');
        }
        
        if (!is_dir(_PS_THEME_DIR_.'assets/img/modules/anblog')) {
            $this->moveImageFolder();
        }
    }
    
    //DONGND:: move image folder from module to theme
    public function moveImageFolder()
    {
        //DONGND:: copy image from module to theme
        if (!file_exists(_PS_THEME_DIR_.'assets/img/index.php')) {
            @copy(_ANBLOG_BLOG_IMG_DIR_.'index.php', _PS_THEME_DIR_.'assets/img/index.php');
        }
        
        if (!is_dir(_PS_THEME_DIR_.'assets/img/modules')) {
            mkdir(_PS_THEME_DIR_.'assets/img/modules', 0744, true);
        }
        
        if (!file_exists(_PS_THEME_DIR_.'assets/img/modules/index.php')) {
            @copy(_ANBLOG_BLOG_IMG_DIR_.'index.php', _PS_THEME_DIR_.'assets/img/modules/index.php');
        }
        
        if (!is_dir(_PS_THEME_DIR_.'assets/img/modules/anblog')) {
            mkdir(_PS_THEME_DIR_.'assets/img/modules/anblog', 0744, true);
        }
        
        if (!file_exists(_ANBLOG_BLOG_IMG_DIR_.'index.php')) {
            @copy(_ANBLOG_BLOG_IMG_DIR_.'index.php', _ANBLOG_BLOG_IMG_DIR_.'index.php');
        }
        
        if (!is_dir(_ANBLOG_BLOG_IMG_DIR_.'sample')) {
            mkdir(_ANBLOG_BLOG_IMG_DIR_.'sample', 0744, true);
            
            mkdir(_ANBLOG_BLOG_IMG_DIR_.'sample/b', 0744, true);
            mkdir(_ANBLOG_BLOG_IMG_DIR_.'sample/c', 0744, true);
            
            if (is_dir(_ANBLOG_BLOG_IMG_DIR_.'b') && is_dir(_ANBLOG_BLOG_IMG_DIR_.'sample/b')) {
                $objects_b = scandir(_ANBLOG_BLOG_IMG_DIR_.'b');
                $objects_theme_b = scandir(_ANBLOG_BLOG_IMG_DIR_.'sample/b');
                if (count($objects_b) > 2 && count($objects_theme_b) <= 2) {
                    foreach ($objects_b as $objects_b_val) {
                        if ($objects_b_val != '.' && $objects_b_val != '..') {
                            if (filetype(_ANBLOG_BLOG_IMG_DIR_.'b'.'/'.$objects_b_val) == 'file') {
                                @copy(_ANBLOG_BLOG_IMG_DIR_.'b'.'/'.$objects_b_val, _ANBLOG_BLOG_IMG_DIR_.'sample/b/'.$objects_b_val);
                            }
                        }
                    }
                }
            }
            
            if (is_dir(_ANBLOG_BLOG_IMG_DIR_.'c') && is_dir(_ANBLOG_BLOG_IMG_DIR_.'sample/c')) {
                $objects_c = scandir(_ANBLOG_BLOG_IMG_DIR_.'c');
                $objects_theme_c = scandir(_ANBLOG_BLOG_IMG_DIR_.'sample/c');
                if (count($objects_c) > 2 && count($objects_theme_c) <= 2) {
                    foreach ($objects_c as $objects_c_val) {
                        if ($objects_c_val != '.' && $objects_c_val != '..') {
                            if (filetype(_ANBLOG_BLOG_IMG_DIR_.'c'.'/'.$objects_c_val) == 'file') {
                                @copy(_ANBLOG_BLOG_IMG_DIR_.'c'.'/'.$objects_c_val, _ANBLOG_BLOG_IMG_DIR_.'sample/c/'.$objects_c_val);
                            }
                        }
                    }
                }
            }
        }
        
        if (!file_exists(_ANBLOG_BLOG_IMG_DIR_.'sample/index.php')) {
            @copy(_ANBLOG_BLOG_IMG_DIR_.'index.php', _ANBLOG_BLOG_IMG_DIR_.'sample/index.php');
        }

        
        //DONGND:: get list id_shop from database of blog
        $list_id_shop = Db::getInstance()->executes('SELECT `id_shop` FROM `'._DB_PREFIX_.'anblog_blog_shop` GROUP BY `id_shop`');
            
        if (count($list_id_shop) > 0) {
            foreach ($list_id_shop as $list_id_shop_val) {
                if (!is_dir(_ANBLOG_BLOG_IMG_DIR_.$list_id_shop_val['id_shop'])) {
                    mkdir(_ANBLOG_BLOG_IMG_DIR_.$list_id_shop_val['id_shop'], 0744, true);
                    
                    @copy(_ANBLOG_BLOG_IMG_DIR_.'index.php', _ANBLOG_BLOG_IMG_DIR_.$list_id_shop_val['id_shop'].'/index.php');
                    
                    mkdir(_ANBLOG_BLOG_IMG_DIR_.$list_id_shop_val['id_shop'].'/b', 0744, true);
                    
                    mkdir(_ANBLOG_BLOG_IMG_DIR_.$list_id_shop_val['id_shop'].'/c', 0744, true);
                    
                    if (is_dir(_ANBLOG_BLOG_IMG_DIR_.'b') && is_dir(_ANBLOG_BLOG_IMG_DIR_.$list_id_shop_val['id_shop'].'/b')) {
                        $objects_b = scandir(_ANBLOG_BLOG_IMG_DIR_.'b');
                        $objects_theme_b = scandir(_ANBLOG_BLOG_IMG_DIR_.$list_id_shop_val['id_shop'].'/b');
                        if (count($objects_b) > 2 && count($objects_theme_b) <= 2) {
                            foreach ($objects_b as $objects_b_val) {
                                if ($objects_b_val != '.' && $objects_b_val != '..') {
                                    if (filetype(_ANBLOG_BLOG_IMG_DIR_.'b'.'/'.$objects_b_val) == 'file') {
                                        @copy(_ANBLOG_BLOG_IMG_DIR_.'b'.'/'.$objects_b_val, _ANBLOG_BLOG_IMG_DIR_.$list_id_shop_val['id_shop'].'/b/'.$objects_b_val);
                                    }
                                }
                            }
                        }
                    }
                    
                    if (is_dir(_ANBLOG_BLOG_IMG_DIR_.'c') && is_dir(_ANBLOG_BLOG_IMG_DIR_.$list_id_shop_val['id_shop'].'/c')) {
                        $objects_c = scandir(_ANBLOG_BLOG_IMG_DIR_.'c');
                        $objects_theme_c = scandir(_ANBLOG_BLOG_IMG_DIR_.$list_id_shop_val['id_shop'].'/c');
                        if (count($objects_c) > 2 && count($objects_theme_c) <= 2) {
                            foreach ($objects_c as $objects_c_val) {
                                if ($objects_c_val != '.' && $objects_c_val != '..') {
                                    if (filetype(_ANBLOG_BLOG_IMG_DIR_.'c'.'/'.$objects_c_val) == 'file') {
                                        @copy(_ANBLOG_BLOG_IMG_DIR_.'c'.'/'.$objects_c_val, _ANBLOG_BLOG_IMG_DIR_.$list_id_shop_val['id_shop'].'/c/'.$objects_c_val);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    /**
     * @Action Create new shop, choose theme then auto restore datasample.
     */
    public function hookActionAdminShopControllerSaveAfter($param)
    {
        if (Tools::getIsset('controller') !== false && Tools::getValue('controller') == 'AdminShop'
            && Tools::getIsset('submitAddshop') !== false && Tools::getValue('submitAddshop')
            && Tools::getIsset('theme_name') !== false && Tools::getValue('theme_name')
        ) {
            $shop = $param['return'];
            
            if (file_exists(_PS_MODULE_DIR_.'appagebuilder/libs/ANDataSample.php')) {
                include_once _PS_MODULE_DIR_.'appagebuilder/libs/ANDataSample.php';
                $sample = new Datasample();
                AnblogHelper::$id_shop = $shop->id;
                $sample->_id_shop = $shop->id;
                $sample->processImport('anblog');
            }
        }
    }

    /**
     * @param $function
     * @param $args
     * @return bool|string
     */
    public function __call($function, $args)
    {
        $hookName = str_replace('hook', '', $function);
        $_hooks = AnblogConfig::getHooksValue($this->context->shop->getContextShopID());
        if (in_array($hookName, array_column($_hooks, 'name')) && in_array($this->context->shop->getContextShopID(), array_column($_hooks, 'id_shop'))) {
            return $this->universalBlog($_hooks[array_search($hookName, array_column($_hooks, 'name'))]['post_count']);
        }
    }
}
