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

class AnblogHelper
{
    public $bloglink = null;
    public $ssl;

    public static function getInstance()
    {
        static $instance = null;
        if (!$instance) {
            // validate module
            $instance = new AnblogHelper();
        }

        return $instance;
    }

    public function __construct()
    {
        if (Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE')) {
            $this->ssl = true;
        }

        $protocol_link = (Configuration::get('PS_SSL_ENABLED') || Tools::usingSecureMode()) ? 'https://' : 'http://';
        $use_ssl = ((isset($this->ssl) && $this->ssl && Configuration::get('PS_SSL_ENABLED')) || Tools::usingSecureMode()) ? true : false;
        $protocol_content = ($use_ssl) ? 'https://' : 'http://';
        $this->bloglink = new AnblogLink($protocol_link, $protocol_content);
    }

    public static function loadMedia($context, $obj)
    {
        if (file_exists(_PS_THEME_DIR_.'css/modules/anblog/views/assets/anblog.css')) {
            $context->controller->addCss($obj->module->getPathUri().'views/assets/anblog.css');
        } else {
            $context->controller->addCss($obj->module->getPathUri().'views/css/anblog.css');
        }

        if (file_exists(_PS_THEME_DIR_.'js/modules/anblog/views/assets/anblog.js')) {
            $context->controller->addJs($obj->module->getPathUri().'views/assets/anblog.js');
        } else {
            $context->controller->addJs($obj->module->getPathUri() . 'views/js/anblog.js');
        }
        $anblogConfig = AnblogConfig::getInstance();
        if ($anblogConfig->params['item_comment_engine'] == 'local' && $anblogConfig->params['google_captcha_site_key'] && $anblogConfig->params['google_captcha_secret_key'] && $anblogConfig->params['google_captcha_status']) {
            $context->controller->registerJavascript('recaptcha', 'https://www.google.com/recaptcha/api.js', array('server' => 'remote', 'position' => 'bottom', 'priority' => 20));
        }
    }

    public function getLinkObject()
    {
        return $this->bloglink;
    }

    public function getModuleLink($route_id, $controller, array $params = array(), $ssl = null, $id_lang = null, $id_shop = null)
    {
        return $this->getLinkObject()->getLink($route_id, $controller, $params, $ssl, $id_lang, $id_shop);
    }

    public function getFontBlogLink()
    {
        return $this->getModuleLink('module-anblog-list', 'list', array());
    }

    public function getPaginationLink($route_id, $controller, array $params = array(), $nb = false, $sort = false, $pagination = false, $array = true)
    {
        return $this->getLinkObject()->getANPaginationLink('anblog', $route_id, $controller, $params, $nb, $sort, $pagination, $array);
    }

    public function getBlogLink($blog, $params1 = array())
    {
        $params = array(
            'id' => $blog['id_anblog_blog'],
            'rewrite' => $blog['link_rewrite'],
        );

        $params = array_merge($params, $params1);
        return $this->getModuleLink('module-anblog-blog', 'blog', $params);
    }

    public function getTagLink($tag)
    {
        $params = array(
            'tag' => $tag,
        );

        return $this->getModuleLink('blog_user_filter_rule', 'blog', $params);
    }

    public function getBlogCatLink($cparams)
    {
        $params = array(
            'id' => '',
            'rewrite' => ''
        );
        $params = array_merge($params, $cparams);
        return $this->getModuleLink('module-anblog-category', 'category', $params);
    }

    public function getBlogTagLink($tag, $cparams = array())
    {
        $params = array(
            'tag' => urlencode($tag),
        );
        $params = array_merge($params, $cparams);
        return $this->getModuleLink('module-anblog-list', 'list', $params);
    }

    public function getBlogAuthorLink($author, $cparams = array())
    {
        $params = array(
            'author' => $author,
        );
        $params = array_merge($params, $cparams);
        return $this->getModuleLink('module-anblog-list', 'list', $params);
    }

    public static function getTemplates()
    {
        $theme = _THEME_NAME_;
        $path = _PS_MODULE_DIR_.'anblog';
        $tpath = _PS_ALL_THEMES_DIR_.$theme.'modules/anblog/front';

        $output = array();

        $templates = glob($path.'/views/templates/front/*', GLOB_ONLYDIR);

        $ttemplates = glob($tpath, GLOB_ONLYDIR);
        if ($templates) {
            foreach ($templates as $t) {
                // validate module
                $output[basename($t)] = array('type' => 'module', 'template' => basename($t));
            }
        }
        if ($ttemplates) {
            foreach ($ttemplates as $t) {
                // validate module
                $output[basename($t)] = array('type' => 'module', 'template' => basename($t));
            }
        }

        return $output;
    }

    public static function buildBlog($helper, $blog, $image_w, $image_h, $config, $check_thumb = false)
    {
        // module validation
        !is_null($image_w) ? true : $image_w = 0;
        !is_null($image_h) ? true : $image_h = 0;

        $url = _PS_BASE_URL_;
        if (Tools::usingSecureMode()) {
            // validate module
            $url = _PS_BASE_URL_SSL_;
        }

        $id_shop = (int)Context::getContext()->shop->id;
        $blog['preview_url'] = '';
        $blog['image_url'] = '';
        
        $blog['preview_thumb_url'] = '';
        $blog['thumb_url'] = '';
        //DONGND:: check callback for Appagebuilder, only create thumb image if exists
        if ($check_thumb && isset($blog['thumb']) && $blog['thumb'] != '') {
            if (isset($blog['thumb']) && $blog['thumb'] != '') {
                $blog['thumb_url'] = $url._ANBLOG_BLOG_IMG_URI_.$id_shop.'/b/'.$blog['thumb'];
                if (!file_exists(_ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop.'/'.$blog['id_anblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['thumb'])) {
                    @mkdir(_ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop, 0744);
                    @mkdir(_ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop.'/'.$blog['id_anblog_blog'], 0744);
                    @mkdir(_ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop.'/'.$blog['id_anblog_blog'].'/'.$image_w.'_'.$image_h, 0744);
                    if (ImageManager::resize(_ANBLOG_BLOG_IMG_DIR_.$id_shop.'/b/'.$blog['thumb'], _ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop.'/'.$blog['id_anblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['thumb'], $image_w, $image_h)) {
                        // validate module
                        $blog['preview_thumb_url'] = _ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop.'/'.$blog['id_anblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['thumb'];
                    }
                }
                $blog['thumb_url'] = $url._ANBLOG_BLOG_IMG_URI_.$id_shop.'/b/'.$blog['thumb'];
                $blog['preview_thumb_url'] = $url._ANBLOG_CACHE_IMG_URI_.'b/'.$id_shop.'/'.$blog['id_anblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['thumb'];
            }
        } else {
            if ($blog['image']) {
                $blog['image_url'] = $url._ANBLOG_BLOG_IMG_URI_.$id_shop.'/b/'.$blog['image'];
                if (!file_exists(_ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop.'/'.$blog['id_anblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['image'])) {
                    @mkdir(_ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop, 0744);
                    @mkdir(_ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop.'/'.$blog['id_anblog_blog'], 0744);
                    @mkdir(_ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop.'/'.$blog['id_anblog_blog'].'/'.$image_w.'_'.$image_h, 0744);
                    if (ImageManager::resize(_ANBLOG_BLOG_IMG_DIR_.$id_shop.'/b/'.$blog['image'], _ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop.'/'.$blog['id_anblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['image'], $image_w, $image_h)) {
                        // validate module
                        $blog['preview_url'] = _ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop.'/'.$blog['id_anblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['image'];
                    }
                }
                $blog['image_url'] = $url._ANBLOG_BLOG_IMG_URI_.$id_shop.'/b/'.$blog['image'];
                $blog['preview_url'] = $url._ANBLOG_CACHE_IMG_URI_.'b/'.$id_shop.'/'.$blog['id_anblog_blog'].'/'.$image_w.'_'.$image_h.'/'.$blog['image'];
            }
        }
        
        $params = array(
            'rewrite' => $blog['category_link_rewrite'],
            'id' => $blog['id_anblogcat']
        );
        if ($config->get('item_comment_engine', 'local') == 'local') {
            // validate module
            $blog['comment_count'] = AnblogComment::countComments($blog['id_anblog_blog'], true, true);
        }
        $blog['category_link'] = $helper->getBlogCatLink($params);
        $blog['link'] = $helper->getBlogLink($blog);
        return $blog;
    }

    public static function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (filetype($dir.'/'.$object) == 'dir') {
                        self::rrmdir($dir.'/'.$object);
                    } else {
                        unlink($dir.'/'.$object);
                    }
                }
            }
            $objects = scandir($dir);
            reset($objects);
            rmdir($dir);
        }
    }

    public static function getConfigKey($multi_lang = false)
    {
        if ($multi_lang == false) {
            return array(
                'saveConfiguration',
                'template',
                'indexation',
                'rss_limit_item',
                'rss_title_item',
                'listing_show_categoryinfo',
                'listing_show_subcategories',
                'listing_leading_column',
                'listing_leading_limit_items',
                'listing_leading_img_width',
                'listing_leading_img_height',
                'listing_secondary_column',
                'hook_column',
                'listing_secondary_limit_items',
                'listing_secondary_img_width',
                'listing_secondary_img_height',
                'listing_show_title',
                'listing_show_description',
                'listing_show_readmore',
                'listing_show_image',
                'listing_show_author',
                'listing_show_category',
                'listing_show_created',
                'listing_show_hit',
                'listing_show_counter',
                'item_img_width',
                'item_img_height',
                'item_show_description',
                'item_show_image',
                'item_show_author',
                'item_show_category',
                'item_show_created',
                'item_show_hit',
                'item_show_counter',
                'social_code',
                'google_captcha_status',
                'google_captcha_site_key',
                'google_captcha_secret_key',
                'item_show_listcomment',
                'item_show_formcomment',
                'item_comment_engine',
                'item_limit_comments',
                'item_diquis_account',
                'item_facebook_appid',
                'item_facebook_width',
                'url_use_id',
                'show_popular_blog',
                'limit_popular_blog',
                'show_recent_blog',
                'limit_recent_blog',
                'show_all_tags',
                'link_rewrite',
            );
        } else {
            return array(
                'blog_link_title',
                'category_rewrite',
                'detail_rewrite',
                'meta_title',
                'hook_header',
                'meta_description',
                'meta_keywords',
            );
        }
    }

    /**
     * @return day in month
     * 1st, 2nd, 3rd, 4th, ...
     */
    public function ordinal($number)
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number.'th';
        } else {
            return $number.$ends[$number % 10];
        }
    }

    /**
     * @return day in month
     * st, nd, rd, th, ...
     */
    public function string_ordinal($number)
    {
        $number = (int) $number;
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return 'th';
        } else {
            return $ends[$number % 10];
        }
    }
    
    public static function genKey()
    {
        return md5(time().rand());
    }
    
    //DONGND:: create folder image in theme if not exists
    public static function buildFolder($id_shop)
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
        
        if (!is_dir(_ANBLOG_BLOG_IMG_DIR_.$id_shop)) {
            mkdir(_ANBLOG_BLOG_IMG_DIR_.$id_shop, 0744, true);
        }
        if (!file_exists(_ANBLOG_BLOG_IMG_DIR_.'index.php')) {
            @copy(_ANBLOG_BLOG_IMG_DIR_.'index.php', _ANBLOG_BLOG_IMG_DIR_.$id_shop.'/index.php');
        }
        
        if (!is_dir(_ANBLOG_BLOG_IMG_DIR_.$id_shop.'/b')) {
            mkdir(_ANBLOG_BLOG_IMG_DIR_.$id_shop.'/b', 0744, true);
        }
        
        if (!file_exists(_ANBLOG_BLOG_IMG_DIR_.$id_shop.'/b/index.php')) {
            @copy(_ANBLOG_BLOG_IMG_DIR_.'index.php', _ANBLOG_BLOG_IMG_DIR_.$id_shop.'/b/index.php');
        }
        
        if (!is_dir(_ANBLOG_BLOG_IMG_DIR_.$id_shop.'/c')) {
            mkdir(_ANBLOG_BLOG_IMG_DIR_.$id_shop.'/c', 0744, true);
        }
        
        if (!file_exists(_ANBLOG_BLOG_IMG_DIR_.$id_shop.'/c/index.php')) {
            @copy(_ANBLOG_BLOG_IMG_DIR_.'index.php', _ANBLOG_BLOG_IMG_DIR_.$id_shop.'/c/index.php');
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
    }
    
    static $id_shop;
    /**
     * FIX Install multi theme
     * AnblogHelper::getIDShop();
     */
    public static function getIDShop()
    {
        if ((int)self::$id_shop) {
            $id_shop = (int)self::$id_shop;
        } else {
            $id_shop = (int)Context::getContext()->shop->id;
        }
        return $id_shop;
    }
}
