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

require_once _PS_MODULE_DIR_.'anblog/loader.php';
require_once _PS_MODULE_DIR_.'anblog/classes/comment.php';

class AdminAnblogDashboardController extends ModuleAdminController
{

    public function __construct()
    {
        $this->bootstrap = true;
        $this->display = 'view';
        $this->addRowAction('view');
        parent::__construct();
    }

    public function initPageHeaderToolbar()
    {
        parent::initPageHeaderToolbar();

        $this->page_header_toolbar_title = $this->l('Dashboard');
        $this->page_header_toolbar_btn = array();
    }

    public function postProcess()
    {

        if (Tools::isSubmit('saveHooks')) {
            $anblog = new Anblog();
            $anHooks = $anblog->getHooksQuery();
            $hooksUpdate = array();
            foreach ($anHooks as $anHook) {
                if ($hookValue = Tools::getValue($anHook['value'])) {
                    if ($hookValue['status']) {
                        $anblog->registerHook($anHook['value']);
                    } else {
                        $anblog->unregisterHook($anHook['value']);
                    }
                    $hooksUpdate[$anHook['value']] = $hookValue;
                }
            }
            AnblogConfig::updateHooksValues($hooksUpdate, $this->context->shop->getContextShopID());
            $this->context->controller->confirmations[] = $this->l('Settings have been updated');
            Configuration::updateValue('ANBLOG_DASHBOARD_DEFAULTTAB', Tools::getValue('ANBLOG_DASHBOARD_DEFAULTTAB'));
        } elseif (Tools::isSubmit('saveConfiguration')) {
            $keys = AnblogHelper::getConfigKey(false);
            $post = array();
            foreach ($keys as $key) {
                $post[$key] = Tools::getValue($key);
            }
            $post['social_code'] = str_replace('"', "'", $post['social_code']);
            $multi_lang_keys = AnblogHelper::getConfigKey(true);
            foreach ($multi_lang_keys as $multi_lang_key) {
                foreach (Language::getIDs(false) as $id_lang) {
                    $post[$multi_lang_key . '_' . (int)$id_lang] = Tools::getValue($multi_lang_key . '_' . (int)$id_lang);
                }
            }
            if (!$this->validateDashboard($post)) {
                return false;
            }
            AnblogConfig::updateConfigValue('cfg_global', serialize($post));
            Configuration::updateValue('link_rewrite', $post['link_rewrite']);
            $this->context->controller->confirmations[] = $this->l('Settings have been updated');
            Configuration::updateValue('ANBLOG_DASHBOARD_DEFAULTTAB', Tools::getValue('ANBLOG_DASHBOARD_DEFAULTTAB'));
        }
    }

    public function validateDashboard($post)
    {
        foreach (Language::getIDs(false) as $id_lang) {
            if (strpbrk($post['meta_keywords_' . $id_lang], '<>;=#{}')) {
                $this->context->controller->errors[] = 'Field meta keywords contains invalid characters';
                return false;
            }
        }
        return true;
    }


    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme);
        $this->addJqueryUi('ui.widget');
        $this->addJqueryPlugin('tagify');
        if (file_exists(_PS_THEME_DIR_ . 'js/modules/anblog/views/assets/form.js')) {
            $this->context->controller->addJS(__PS_BASE_URI__ . 'modules/anblog/views/assets/admin/form.js');
        } else {
            $this->context->controller->addJS(__PS_BASE_URI__ . 'modules/anblog/views/js/admin/form.js');
        }
    }

    public function renderView()
    {
        $link = $this->context->link;

        $quicktools = array();
/*
        $quicktools[] = array(
            'title' => $this->l('Categories'),
            'href' => $link->getAdminLink('AdminAnblogCategories'),
            'target' => '',
            'icon' => 'icon-desktop',
            'class' => '',
        );

        $quicktools[] = array(
            'title' => $this->l('Add Category'),
            'href' => $link->getAdminLink('AdminAnblogCategories'),
            'target' => '',
            'icon' => 'icon-list',
            'class' => '',
        );

        $quicktools[] = array(
            'title' => $this->l('Posts'),
            'href' => $link->getAdminLink('AdminAnblogBlogs'),
            'target' => '',
            'icon' => 'icon-list',
            'class' => '',
        );

        $quicktools[] = array(
            'title' => $this->l('Add post'),
            'href' => $link->getAdminLink('AdminAnblogBlogs') . '&addanblog_blog',
            'target' => '',
            'icon' => 'icon-list',
            'class' => '',
        );

        $quicktools[] = array(
            'title' => $this->l('Comments'),
            'href' => $link->getAdminLink('AdminAnblogComments'),
            'target' => '',
            'icon' => 'icon-list',
            'class' => '',
        );*/
        $code = '';
        if (sizeof(Language::getLanguages(true, true)) > 1) {
            $code =$this->context->language->iso_code .  '/';
        }
        $preview = array(
            'title' => $this->l('Open the blog'),
            'href' => $this->context->shop->getBaseURL(true) . $code . Configuration::get('link_rewrite', 'blog') . '.html',
            'icon' => 'icon-eye',
            'target' => '_blank',
            'class' => '',
        );

        $onoff = array(
            array(
                'id' => 'indexation_on',
                'value' => 1,
                'label' => $this->l('Enabled')
            ),
            array(
                'id' => 'indexation_off',
                'value' => 0,
                'label' => $this->l('Disabled')
            )
        );


        $templates = AnblogHelper::getTemplates();
        $url_rss = Tools::htmlentitiesutf8('http://' . $_SERVER['HTTP_HOST'] . __PS_BASE_URI__) . 'modules/anblog/rss.php';
        $form = '';

        $this->fields_form[0]['form'] = array(
            'tinymce' => true,
            'input' => array(

                // custom template
                array(
                    'type' => 'hidden',
                    'name' => 'ANBLOG_DASHBOARD_DEFAULTTAB',
                    'default' => '#fieldset_0',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Theme - Template'),
                    'name' => 'template',
                    'options' => array('query' => $templates,
                        'id' => 'template',
                        'name' => 'template'),
                    'default' => 'default',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Root Link Title'),
                    'name' => 'blog_link_title',
                    'required' => true,
                    'lang' => true,
                    'default' => 'Blog',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Friendly URL'),
                    'desc' => $this->l('If Friendly URL is enabled, then IDs in URLs of categories and posts are replaced with user-friendly customizable words'),
                    'name' => 'url_use_id',
                    'required' => false,
                    'class' => 'form-action',
                    'is_bool' => true,
                    'default' => '1',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Category'),
                    'name' => 'category_rewrite',
                    'required' => true,
                    'lang' => true,
                    'default' => 'category',
                    'form_group_class' => 'url_use_id_sub url_use_id-0',
                    'desc' => 'Enter a hint word that is displayed in the URL of a category and makes the URL friendly',
                    'hint' => $this->l('Example http://domain/blog/category/name.html'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Post'),
                    'name' => 'detail_rewrite',
                    'required' => true,
                    'lang' => true,
                    'default' => 'detail',
                    'form_group_class' => 'url_use_id_sub url_use_id-0',
                    'desc' => 'Enter a hint word that is displayed in the URL of a post and makes the URL friendly',
                    'hint' => $this->l('Example http://domain/blog/post/name.html'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Root'),
                    'name' => 'link_rewrite',
                    'required' => true,
                    'desc' => $this->l('If necessary, change root of the blog'),
                    'default' => 'blog',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Meta Title'),
                    'name' => 'meta_title',
                    'lang' => true,
                    'cols' => 40,
                    'rows' => 10,
                    'default' => 'Blog',
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Meta description'),
                    'name' => 'meta_description',
                    'lang' => true,
                    'cols' => 40,
                    'rows' => 10,
                    'default' => '',
                    'desk' => $this->l('Display meta descrition on frontpage blog') . 'note: note &lt;&gt;;=#{}'
                ),
                array(
                    'type' => 'tags',
                    'label' => $this->l('Meta keywords'),
                    'name' => 'meta_keywords',
                    'default' => '',
                    'hint' => $this->l('Invalid characters:') . ' &lt;&gt;;=#{}',
                    'lang' => true,
                    'desc' => array(
                        $this->l('To add a keyword, enter the keyword and then press "Enter"')
                    )
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enable RSS'),
                    'name' => 'indexation',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '',
                    'values' => $onoff,
                    'desc' => $url_rss
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('RSS Limit Items'),
                    'name' => 'rss_limit_item',
                    'default' => '20',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('RSS Title'),
                    'name' => 'rss_title_item',
                    'default' => 'RSS FEED',
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),

                'class' => 'btn btn-default pull-right'
            )
        );

        $this->fields_form[1]['form'] = array(
            'tinymce' => true,
            'default' => '',
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Category description'),
                    'name' => 'listing_show_categoryinfo',
                    'required' => false,
                    'class' => 't',
                    'desc' => $this->l('Display description of the category in the list of categories'),
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Subcategories'),
                    'name' => 'listing_show_subcategories',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                    'desc' => $this->l('Display subcategories in the list of categories')
                ),
                array(
                    'type' => 'number',
                    'label' => $this->l('Leading columns'),
                    'name' => 'listing_leading_column',
                    'required' => false,
                    'class' => 't',
                    'default' => '1',
                ),
                array(
                    'type' => 'number',
                    'label' => $this->l('Leading items limit'),
                    'name' => 'listing_leading_limit_items',
                    'required' => false,
                    'class' => 't',
                    'default' => '2',
                ),
                array(
                    'type' => 'number',
                    'label' => $this->l('Leading images width'),
                    'name' => 'listing_leading_img_width',
                    'required' => false,
                    'class' => 't',
                    'default' => '690',
                ),
                array(
                    'type' => 'number',
                    'label' => $this->l('Leading images height'),
                    'name' => 'listing_leading_img_height',
                    'required' => false,
                    'class' => 't',
                    'default' => '300',
                ),
                array(
                    'type' => 'number',
                    'label' => $this->l('Secondary column'),
                    'name' => 'listing_secondary_column',
                    'required' => false,
                    'class' => 't',
                    'default' => '3',
                ),
                array(
                    'type' => 'number',
                    'label' => $this->l('Home page columns'),
                    'name' => 'hook_column',
                    'required' => false,
                    'class' => 't',
                    'default' => '3',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Home page header'),
                    'name' => 'hook_header',
                    'required' => false,
                    'lang' => true,
                    'class' => 't',
                    'default' => '',
                ),
                array(
                    'type' => 'number',
                    'label' => $this->l('Secondary items limit '),
                    'name' => 'listing_secondary_limit_items',
                    'required' => false,
                    'class' => 't',
                    'default' => '6',
                ),
                array(
                    'type' => 'number',
                    'label' => $this->l('Secondary images width'),
                    'name' => 'listing_secondary_img_width',
                    'required' => false,
                    'class' => 't',
                    'default' => '390',
                ),
                array(
                    'type' => 'number',
                    'label' => $this->l('Secondary images height'),
                    'name' => 'listing_secondary_img_height',
                    'required' => false,
                    'class' => 't',
                    'default' => '220',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Title'),
                    'name' => 'listing_show_title',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Description'),
                    'name' => 'listing_show_description',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('"Read more" button'),
                    'name' => 'listing_show_readmore',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Image'),
                    'name' => 'listing_show_image',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Author'),
                    'name' => 'listing_show_author',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '0',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Category'),
                    'name' => 'listing_show_category',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '0',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Date'),
                    'name' => 'listing_show_created',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Views'),
                    'name' => 'listing_show_hit',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '0',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Comments counter'),
                    'name' => 'listing_show_counter',
                    'required' => false,
                    'class' => 't',
                    'default' => '0',
                    'values' => $onoff,
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            )
        );

        $this->fields_form[2]['form'] = array(
            'tinymce' => true,
            'default' => '',
            'input' => array(
                array(
                    'type' => 'number',
                    'label' => $this->l('Image Width'),
                    'name' => 'item_img_width',
                    'required' => false,
                    'class' => 't',
                    'default' => '690',
                ),
                array(
                    'type' => 'number',
                    'label' => $this->l('Image Height'),
                    'name' => 'item_img_height',
                    'required' => false,
                    'class' => 't',
                    'default' => '350',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Description'),
                    'name' => 'item_show_description',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Image'),
                    'name' => 'item_show_image',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Author'),
                    'name' => 'item_show_author',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Category'),
                    'name' => 'item_show_category',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Date'),
                    'name' => 'item_show_created',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Views'),
                    'name' => 'item_show_hit',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Comments counter'),
                    'name' => 'item_show_counter',
                    'required' => false,
                    'class' => 't',
                    'default' => '1',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Social Sharing CODE'),
                    'name' => 'social_code',
                    'required' => false,
                    'default' => '',
                    'desc' => 'If you want to replace default social sharing buttons, configure them on https://www.sharethis.com/ and paste their code into the field above'
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Comments list'),
                    'name' => 'item_show_listcomment',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                    'desc' => $this->l('Show/Hide the comments list'),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Comment form'),
                    'name' => 'item_show_formcomment',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'default' => '1',
                    'values' => $onoff,
                    'desc' => $this->l('This option is compatible only with local comments engine'),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Comments Engine'),
                    'name' => 'item_comment_engine',
                    'id' => 'item_comment_engine',
                    'class' => 'engine_select',
                    'options' => array('query' => array(
                        array('id' => 'local', 'name' => $this->l('Local')),
                        array('id' => 'facebook', 'name' => $this->l('Facebook')),
                        array('id' => 'diquis', 'name' => $this->l('Disqus')),
                    ),
                        'id' => 'id',
                        'name' => 'name'),
                    'default' => 'local'
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enable reCAPTCHA  '),
                    'name' => 'google_captcha_status',
                    'required' => false,
                    'is_bool' => true,
                    'class' => 't local comment_item',
                    'default' => '1',
                    'values' => $onoff,
                    'desc' => html_entity_decode('&lt;a target=&#x22;_blank&#x22;  href=&quot;https://www.google.com/recaptcha/admin&quot;&gt;Register google reCAPTCHA &lt;/a&gt;')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('reCAPTCHA site key'),
                    'name' => 'google_captcha_site_key',
                    'required' => false,
                    'class' => 't local comment_item',
                    'default' => '',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('reCAPTCHA secret key'),
                    'name' => 'google_captcha_secret_key',
                    'required' => false,
                    'default' => '',
                    'class' => 't local comment_item',
                ),
                array(
                    'type' => 'number',
                    'label' => $this->l('Comments limit'),
                    'name' => 'item_limit_comments',
                    'required' => false,
                    'class' => 't local comment_item',
                    'default' => '10',
                    'desc' => $this->l('This option is compatible only with local comments engine'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Disqus Account'),
                    'name' => 'item_diquis_account',
                    'required' => false,
                    'class' => 't diquis comment_item',
                    'default' => 'demo4antheme',
                    'desc' => html_entity_decode('Enter the name of your Disqus account (for example anvanto-com). You can copy the name from the address page in your account: for example, the URL is anvanto-com.disqus.com/admin, then copy the text before the first dot. If you have no Disqus account, &lt;a target=&quot;_blank&quot; href=&quot;https://disqus.com/admin/signup/&quot;&gt;sign up here&lt;/a&gt;')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Facebook Application ID'),
                    'name' => 'item_facebook_appid',
                    'required' => false,
                    'class' => 't facebook comment_item',
                    'default' => '100858303516',
                    'desc' => html_entity_decode('&#x3C;a target=&#x22;_blank&#x22; href=&#x22;http://developers.facebook.com/docs/reference/plugins/comments/&#x22;&#x3E;' . $this->l('Register a comment box') . '&#x3C;/a&#x3E;' .  ' then enter your site URL into the Comments Plugin Code Generator and then press the "Get code" button. Copy the appId from the code and paste it into the field above.')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Facebook Width'),
                    'name' => 'item_facebook_width',
                    'required' => false,
                    'class' => 't facebook comment_item',
                    'default' => '600'
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            )
        );
        $this->fields_form[3]['form'] = array(
            'tinymce' => true,
            'default' => '',
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Popular posts'),
                    'name' => 'show_popular_blog',
                    'is_bool' => true,
                    'default' => '0',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'number',
                    'label' => $this->l('Popular posts limit'),
                    'name' => 'limit_popular_blog',
                    'default' => '5',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Recent posts'),
                    'name' => 'show_recent_blog',
                    'is_bool' => true,
                    'default' => '0',
                    'values' => $onoff,
                ),
                array(
                    'type' => 'number',
                    'label' => $this->l('Recent posts limit'),
                    'name' => 'limit_recent_blog',
                    'default' => '5',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Tags'),
                    'name' => 'show_all_tags',
                    'is_bool' => true,
                    'default' => '0',
                    'values' => $onoff,
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            )
        );
        $hooksFormFields = array();
        $hooksFormFields[1]['form'] = array(
            'tinymce' => false,
            'default' => '',
            'input' => array(
                array(
                    'type' => 'hidden',
                    'name' => 'ANBLOG_DASHBOARD_DEFAULTTAB',
                    'value' => '',
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'name' => 'saveHooks',
                'class' => 'btn btn-default pull-right',
            )
        );
        $anHooks = Anblog::getHooksQuery();
        foreach ($anHooks as $_hook) {
            $hooksFormFields[1]['form']['input'][] = array(
                'type' => 'switch',
                'label' => $this->l($_hook['name']),
                'name' => $_hook['value'] . '[status]',
                'is_bool' => true,
                'default' => '0',
                'values' => $onoff,
            );
            $hooksFormFields[1]['form']['input'][] = array(
                'type' => 'number',
                'label' => $this->l('Articles count'),
                'name' => $_hook['value'] . '[postCount]',
                'value' => '3',
            );
        }


        $data = AnblogConfig::getConfigValue('cfg_global');

        $obj = new stdClass();

        if ($data && $tmp = unserialize($data)) {
            foreach ($tmp as $key => $value) {
                // validate module
                $obj->{$key} = $value;
            }
        }

        $fields_value = $this->getConfigFieldsValues($obj);
        $helper = new HelperForm($this);
        $dataHooks = AnblogConfig::getHooksValue($this->context->shop->getContextShopID());
        foreach ($anHooks as $anHook) {
            if (array_search($anHook['value'], array_column($dataHooks, 'name')) !== false) {
                $fields_value[$anHook['value'] . '[status]'] = $dataHooks[array_search($anHook['value'], array_column($dataHooks, 'name'))]['status'];
                $fields_value[$anHook['value'] . '[postCount]'] = $dataHooks[array_search($anHook['value'], array_column($dataHooks, 'name'))]['post_count'];
            } else {
                $fields_value[$anHook['value'] . '[status]'] = '0';
                $fields_value[$anHook['value'] . '[postCount]'] = '0';
            }
        }


        $this->setHelperDisplay($helper);
        $helper->fields_value = $fields_value;
        $helper->tpl_vars = $this->tpl_form_vars;
        !is_null($this->base_tpl_form) ? $helper->base_tpl = $this->base_tpl_form : '';
        if ($this->tabAccess['view']) {
            $helper->tpl_vars['show_toolbar'] = false;
            $helper->tpl_vars['submit_action'] = 'saveConfiguration';
            if (Tools::getValue('back')) {
                $helper->tpl_vars['back'] = '';
            } else {
                $helper->tpl_vars['back'] = '';
            }
        }
        $form = $helper->generateForm($this->fields_form);
        $hooksForm = $helper->generateForm($hooksFormFields);
        $template = $this->createTemplate('panel.tpl');

        $comments = AnblogComment::getComments(null, 10, $this->context->language->id);
        $blogs = AnblogBlog::getListBlogs(null, $this->context->language->id, 0, 10, 'hits', 'DESC');
        $template->assign(
            array(
                'preview' => $preview,
                'showed' => 1,
                'comment_link' => $link->getAdminLink('AdminAnblogComments'),
                'blog_link' => $link->getAdminLink('AdminAnblogBlogs'),
                'blogs' => $blogs,
                'count_blogs' => AnblogBlog::countBlogs(null, $this->context->language->id),
                'count_cats' => Anblogcat::countCats(),
                'count_comments' => AnblogComment::countComments(),
                'latest_comments' => $comments,
                'globalform' => $form,
                'hooksForm' => $hooksForm,
                'default_tab' => Configuration::get('ANBLOG_DASHBOARD_DEFAULTTAB')
            )
        );
        return $template->fetch();
    }

    /**
     * Asign value for each input of Data form
     */
    public function getConfigFieldsValues($obj)
    {
        $languages = Language::getLanguages(false);
        $fields_values = array();

        foreach ($this->fields_form as $k => $f) {
            foreach ($f['form']['input'] as $j => $input) {
                if (isset($input['lang'])) {
                    foreach ($languages as $lang) {
                        if (isset($obj->{trim($input['name']) . '_' . $lang['id_lang']})) {
                            $data = $obj->{trim($input['name']) . '_' . $lang['id_lang']};
                            $fields_values[$input['name']][$lang['id_lang']] = $data;
                        } else {
                            $fields_values[$input['name']][$lang['id_lang']] = Tools::getValue($input['name'] . '_' . $lang['id_lang'], $input['default']);
                        }
                    }
                } else {
                    if (isset($obj->{trim($input['name'])})) {
                        $data = $obj->{trim($input['name'])};

                        if ($input['name'] == 'image' && $data) {
                            $thumb = __PS_BASE_URI__ . 'modules/' . $this->name . '/views/img/' . $data;
                            $this->fields_form[$k]['form']['input'][$j]['thumb'] = $thumb;
                        }
                        if ($input['name'] == 'social_code') {
                            $fields_values[$input['name']] = html_entity_decode($data);
                        } else {
                            $fields_values[$input['name']] = $data;
                        }
                    } else {
                        // validate module
                        $fields_values[$input['name']] = Tools::getValue($input['name'], $input['default']);
                    }
                }
            }
        }

        $fields_values['ANBLOG_DASHBOARD_DEFAULTTAB'] = Tools::getValue('ANBLOG_DASHBOARD_DEFAULTTAB', Configuration::get('ANBLOG_DASHBOARD_DEFAULTTAB'));
        return $fields_values;
    }
}
