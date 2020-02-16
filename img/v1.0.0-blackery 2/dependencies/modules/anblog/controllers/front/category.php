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

class AnblogcategoryModuleFrontController extends ModuleFrontController
{
    public $php_self;
    protected $template_path = '';

    public function __construct()
    {
        parent::__construct();
        $this->context = Context::getContext();
        $this->template_path = _PS_MODULE_DIR_.'anblog/views/templates/front/';
    }

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        $config = AnblogConfig::getInstance();

        /* Load Css and JS File */
        AnblogHelper::loadMedia($this->context, $this);

        $this->php_self = 'category';

        // $this->php_self = 'module-anblog-category';

        $id_category = (int)Tools::getValue('id');
        if (!$config->get('url_use_id', 1)) {
            // URL HAVE ID
            $category = new Anblogcat($id_category, $this->context->language->id);
        } else {
            // REMOVE ID FROM URL
            $url_rewrite = explode('/', $_SERVER['REQUEST_URI']);
            $url_last_item = count($url_rewrite) - 1;
            $url_rewrite = rtrim($url_rewrite[$url_last_item], 'html');
            $url_rewrite = rtrim($url_rewrite, '\.');    // result : product.html -> product.
            $category = Anblogcat::findByRewrite(array('link_rewrite'=>$url_rewrite));
        }
        if(
            $category->groups != null
            && $category->groups != ''
            && !in_array(Group::getCurrent()->id,explode(';', $category->groups))
        ) {
            Tools::redirect('index.php?controller=404');
        }

        parent::initContent();

        $helper = AnblogHelper::getInstance();

        $limit_leading_blogs = (int)$config->get('listing_leading_limit_items', 1);
        $limit_secondary_blogs = (int)$config->get('listing_secondary_limit_items', 6);

        $limit = (int)$limit_leading_blogs + (int)$limit_secondary_blogs;
        $n = $limit;
        $p = abs((int)(Tools::getValue('p', 1)));


        $template = isset($category->template) && $category->template ? $category->template : $config->get('template', 'default');

        if ($category->id_anblogcat && $category->active) {
            //            $_GET['rewrite'] = $category->link_rewrite;
            $this->template_path .= $template.'/';
            $id_shop = $this->context->shop->id;
            $url = _PS_BASE_URL_;
            if (Tools::usingSecureMode()) {
                // validate module
                $url = _PS_BASE_URL_SSL_;
            }
            if ($category->image) {
                // validate module
                $category->image = $url._ANBLOG_BLOG_IMG_URI_.$id_shop.'/c/'.$category->image;
            }

            $blogs = AnblogBlog::getListBlogs($category->id_anblogcat, $this->context->language->id, $p, $limit, 'id_anblog_blog', 'DESC', array(), true);
            $count = AnblogBlog::countBlogs($category->id_anblogcat, $this->context->language->id, true);
            $authors = array();

            $leading_blogs = array();
            $secondary_blogs = array();
            //            $links        =  array();

            if (count($blogs)) {
                $leading_blogs = array_slice($blogs, 0, $limit_leading_blogs);
                $secondary_blogs = array_splice($blogs, $limit_leading_blogs, count($blogs));
            }
            $image_w = (int)$config->get('listing_leading_img_width', 690);
            $image_h = (int)$config->get('listing_leading_img_height', 300);

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

            $image_w = (int)$config->get('listing_secondary_img_width', 390);
            $image_h = (int)$config->get('listing_secondary_img_height', 200);

            foreach ($secondary_blogs as $key => $blog) {
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

                $secondary_blogs[$key] = $blog;
            }

            $nb_blogs = $count;
            $range = 2; /* how many pages around page selected */
            if ($p > (($nb_blogs / $n) + 1)) {
                Tools::redirect(preg_replace('/[&?]p=\d+/', '', $_SERVER['REQUEST_URI']));
            }
            $pages_nb = ceil($nb_blogs / (int)($n));
            $start = (int)($p - $range);
            if ($start < 1) {
                $start = 1;
            }
            $stop = (int)($p + $range);
            if ($stop > $pages_nb) {
                $stop = (int)($pages_nb);
            }

            $params = array(
                'rewrite' => $category->link_rewrite,
                'id' => $category->id_anblogcat
            );

            /* breadcrumb */
            $r = $helper->getPaginationLink('module-anblog-category', 'category', $params, false, true);
            $all_cats = array();
            self::parentCategories($category, $all_cats);

            foreach ($all_cats as $key => $cat) {
                $params = array(
                    'rewrite' => $cat->link_rewrite,
                    'id' => $cat->id
                );
                $all_cats[$key]->category_link = $helper->getBlogCatLink($params);
            }
            $this->context->smarty->assign(
                array(
                    'getBlogLink'    => false,
                    'categories'     => $all_cats,
                    'blogLink'       => $helper->getFontBlogLink(),
                    'blogTitle'      => htmlentities($config->get('blog_link_title_'.$this->context->language->id, 'Blog'), ENT_NOQUOTES, 'UTF-8'),
                    'navigationPipe' => Configuration::get('PS_NAVIGATION_PIPE'),
                    'isNew'   => $this->module->new174,
                )
            );
            $path = $this->context->smarty->fetch('module:anblog/views/templates/front/'.$template.'/category_path.tpl');
            /* sub categories */
            $categories = $category->getChild($category->id_anblogcat, $this->context->language->id);

            $childrens = array();

            if ($categories) {
                foreach ($categories as $child) {
                    $params = array(
                        'rewrite' => $child['link_rewrite'],
                        'id' => $child['id_anblogcat']
                    );

                    $child['thumb'] = $url._ANBLOG_BLOG_IMG_URI_.$id_shop.'/c/'.$child['image'];

                    $child['category_link'] = $helper->getBlogCatLink($params);
                    $childrens[] = $child;
                }
            }

            $this->context->smarty->assign(
                array(
                    'leading_blogs' => $leading_blogs,
                    'secondary_blogs' => $secondary_blogs,
                    'listing_leading_column' => $config->get('listing_leading_column', 1),
                    'listing_secondary_column' => $config->get('listing_secondary_column', 3),
                    'module_tpl' => $this->template_path,
                    'config' => $config,
                    'range' => $range,
                    'category' => $category,
                    'start' => $start,
                    'childrens' => $childrens,
                    'stop' => $stop,
                    'path' => $path,
                    'pages_nb' => $pages_nb,
                    'nb_items' => $count,
                    'p' => (int)$p,
                    'n' => (int)$n,
                    'meta_title' => Tools::ucfirst($category->title).' - '.Configuration::get('PS_SHOP_NAME'),
                    'meta_keywords' => $category->meta_keywords,
                    'meta_description' => $category->meta_description,
                    'requestPage' => $r['requestUrl'],
                    'requestNb' => $r,
                    'isNew'   => $this->module->new174,
                    'category' => $category
                )
            );
        } else {
            $this->context->smarty->assign(
                array(
                    'getBlogLink'    => true,
                    'blogLink'       => $helper->getFontBlogLink(),
                    'blogTitle'      => htmlentities($config->get('blog_link_title_'.$this->context->language->id, 'Blog'), ENT_NOQUOTES, 'UTF-8'),
                    'navigationPipe' => Configuration::get('PS_NAVIGATION_PIPE')
                )
            );
            $path = $this->context->smarty->fetch('module:anblog/views/templates/front/'.$template.'/category_path.tpl');
            $this->context->smarty->assign(
                array(
                    'active' => '0',
                    'path' => $path,
                    'leading_blogs' => array(),
                    'secondary_blogs' => array(),
                    'controller' => 'category',
                    'isNew'   => $this->module->new174,
                    'category' => $category
                )
            );
        }


        $this->setTemplate('module:anblog/views/templates/front/'.$template.'/category.tpl');
    }

    public static function parentCategories($current, &$return)
    {
        if ($current->id_parent) {
            $obj = new Anblogcat($current->id_parent, Context::getContext()->language->id);
            self::parentCategories($obj, $return);
        }
        $return[] = $current;
    }

    //DONGND:: add meta
    public function getTemplateVarPage()
    {
        $page = parent::getTemplateVarPage();
        $config = AnblogConfig::getInstance();
        if (!$config->get('url_use_id', 1)) {
            // URL HAVE ID
            $category = new Anblogcat((int)Tools::getValue('id'), $this->context->language->id);
        } else {
            // REMOVE ID FROM URL
            $url_rewrite = explode('/', $_SERVER['REQUEST_URI']);
            $url_last_item = count($url_rewrite) - 1;
            $url_rewrite = rtrim($url_rewrite[$url_last_item], '.html');
            $category = Anblogcat::findByRewrite(array('link_rewrite'=>$url_rewrite));
        }
        $page['meta']['title'] = Tools::ucfirst($category->title).' - '.Configuration::get('PS_SHOP_NAME');
        $page['meta']['keywords'] = $category->meta_keywords;
        $page['meta']['description'] = $category->meta_description;

        return $page;
    }

    //DONGND:: add breadcrumb
    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();
        $helper = AnblogHelper::getInstance();
        $link = $helper->getFontBlogLink();
        $config = AnblogConfig::getInstance();
        $breadcrumb['links'][] = array(
            'title' => $config->get('blog_link_title_'.$this->context->language->id, $this->l('Blog', 'category')),
            'url' => $link,
        );

        if (!$config->get('url_use_id', 1)) {
            // URL HAVE ID
            $category = new Anblogcat((int)Tools::getValue('id'), $this->context->language->id);
        } else {
            // REMOVE ID FROM URL
            $url_rewrite = explode('/', $_SERVER['REQUEST_URI']);
            $url_last_item = count($url_rewrite) - 1;
            $url_rewrite = rtrim($url_rewrite[$url_last_item], '.html');
            $category = Anblogcat::findByRewrite(array('link_rewrite'=>$url_rewrite));
        }

        $params = array(
            'rewrite' => $category->link_rewrite,
            'id' => $category->id_anblogcat
        );

        $category_link = $helper->getBlogCatLink($params);

        $breadcrumb['links'][] = array(
            'title' => $category->title,
            'url' => $category_link,
        );

        return $breadcrumb;
    }

    //DONGND:: get layout
    public function getLayout()
    {
        $entity = 'module-anblog-'.$this->php_self;

        $layout = $this->context->shop->theme->getLayoutRelativePathForPage($entity);

        if ($overridden_layout = Hook::exec(
            'overrideLayoutTemplate',
            array(
                'default_layout' => $layout,
                'entity' => $entity,
                'locale' => $this->context->language->locale,
                'controller' => $this,
            )
        )
        ) {
            return $overridden_layout;
        }

        if ((int) Tools::getValue('content_only')) {
            $layout = 'layouts/layout-content-only.tpl';
        }

        return $layout;
    }
}
