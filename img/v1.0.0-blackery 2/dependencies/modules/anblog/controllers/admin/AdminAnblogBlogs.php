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

class AdminAnblogBlogsController extends ModuleAdminController
{

    protected $max_image_size;
    protected $position_identifier = 'id_anblog_blog';

    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->table = 'anblog_blog';
        //$this->list_id = 'id_anblog_blog';        // must be set same value $this->table to delete multi rows
        $this->identifier = 'id_anblog_blog';
        $this->className = 'AnblogBlog';
        $this->lang = true;
        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->bulk_actions = array(
            'delete' => array('text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?'),
                'icon' => 'icon-trash')
        );
        $this->fields_list = array(
            'id_anblog_blog' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'meta_title' => array('title' => $this->l('Blog Title'), 'filter_key' => 'b!meta_title'),
        'author_name' => array('title' => $this->l('Author Name'), 'filter_key' => 'a!author_name'),
            'title' => array('title' => $this->l('Category Title'), 'filter_key' => 'cl!title'),
        'hits' => array(
            'title' => $this->l('Views'),
            'filter_key' => 'a!hits'
        ),
        'active' => array(
            'title' => $this->l('Displayed'),
            'align' => 'center',
            'active' => 'status',
            'class' => 'fixed-width-sm',
            'type' => 'bool',
            'orderby' => true
        ),
        'date_add' => array(
            'title' => $this->l('Date Create'),
            'type' => 'date',
            'filter_key' => 'a!date_add'
        ),

        'date_upd' => array(
            'title' => $this->l('Date Update'),
            'type' => 'datetime',
            'filter_key' => 'a!date_upd'
        )
        );
        $this->max_image_size = Configuration::get('PS_PRODUCT_PICTURE_MAX_SIZE');
        $this->_select .= ' cl.title ';
        $this->_join .= ' LEFT JOIN '._DB_PREFIX_.'anblogcat c ON a.id_anblogcat = c.id_anblogcat
						  LEFT JOIN '._DB_PREFIX_.'anblogcat_lang cl ON cl.id_anblogcat=c.id_anblogcat
						  AND cl.id_lang=b.id_lang 
			    ';
        if (Shop::getContext() == Shop::CONTEXT_SHOP) {
            $this->_join .= ' INNER JOIN `'._DB_PREFIX_.'anblog_blog_shop` sh 
            ON (sh.`id_anblog_blog` = b.`id_anblog_blog` AND sh.id_shop = '.(int)Context::getContext()->shop->id.') ';
        }
        $this->_where = '';
        $this->_group = ' GROUP BY (a.id_anblog_blog) ';
        // $this->_orderBy = 'a.position';
        $this->_orderBy = 'a.id_anblog_blog';
        $this->_orderWay = 'DESC';
    }

    public function initPageHeaderToolbar()
    {
        $link = $this->context->link;
        if (Tools::getValue('id_anblog_blog')) {
            $helper = AnblogHelper::getInstance();
            $blog_obj = new AnblogBlog(Tools::getValue('id_anblog_blog'), $this->context->language->id);
            $this->page_header_toolbar_btn['view-blog-preview'] = array(
                'href' => $helper->getBlogLink(get_object_vars($blog_obj)),
                'desc' => $this->l('Preview Blog'),
                'icon' => 'icon-preview anblog-comment-link-icon icon-3x process-icon-preview',
            'target' => '_blank',
            );
            
            $this->page_header_toolbar_btn['view-blog-comment'] = array(
                'href' => $link->getAdminLink('AdminAnblogComments').'&id_anblog_blog='.Tools::getValue('id_anblog_blog'),
                'desc' => $this->l('Manage Comments'),
                'icon' => 'icon-comment anblog-comment-link-icon icon-3x process-icon-comment',
            'target' => '_blank',
            );
        }

        return parent::initPageHeaderToolbar();
    }
    
    public function renderForm()
    {
        if (!$this->loadObject(true)) {
            if (Validate::isLoadedObject($this->object)) {
                $this->display = 'edit';
            } else {
                $this->display = 'add';
            }
        }
        $this->initToolbar();
        $this->initPageHeaderToolbar();

        $id_anblogcat = (int)(Tools::getValue('id_anblogcat'));
        $obj = new anblogcat($id_anblogcat);
        $obj->getTree();
        $menus = $obj->getDropdown(null, $obj->id_parent, false);
        array_shift($menus);
        
        $id_shop = (int)Context::getContext()->shop->id;
        $url = _PS_BASE_URL_;
        if (Tools::usingSecureMode()) {
            // validate module
            $url = _PS_BASE_URL_SSL_;
        }
        if ($this->object->image) {
            $thumb = $url._ANBLOG_BLOG_IMG_URI_.$id_shop.'/b/'.$this->object->image;
        } else {
            $thumb = '';
        }
        
        //DONGND:: add default author name is name of current admin
        $default_author_name = '';
        
        if (isset($this->context->employee->firstname) && isset($this->context->employee->lastname)) {
            $default_author_name = $this->context->employee->firstname.' '.$this->context->employee->lastname;
        }
        
        if ($this->object->id == '') {
            $this->object->author_name = $default_author_name;
        }
        
        if ($this->object->thumb) {
            // validate module
            $thumb_img = $url._ANBLOG_BLOG_IMG_URI_.$id_shop.'/b/'.$this->object->thumb;
        } else {
            // validate module
            $thumb_img = '';
        }

        $this->multiple_fieldsets = true;
        
        $this->fields_form[0]['form'] = array(
            'tinymce' => true,
            'legend' => array(
                'title' => $this->l('Blog Form'),
                'icon' => 'icon-folder-close'
            ),
            'input' => array(
                // custom template

                array(
                    'type' => 'select',
                    'label' => $this->l('Category'),
                    'name' => 'id_anblogcat',
                    'options' => array('query' => $menus,
                        'id' => 'id',
                        'name' => 'title'),
                    'default' => $id_anblogcat,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Meta title'),
                    'name' => 'meta_title',
                    'id' => 'name', // for copyMeta2friendlyURL compatibility
                    'lang' => true,
                    'required' => true,
                    'class' => 'copyMeta2friendlyURL',
                    'hint' => $this->l('Invalid characters:').' &lt;&gt;;=#{}'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Friendly URL'),
                    'name' => 'link_rewrite',
                    'required' => true,
                    'lang' => true,
                    'hint' => $this->l('Only letters and the minus (-) character are allowed')
                ),
                array(
                    'type' => 'tags',
                    'label' => $this->l('Tags'),
                    'name' => 'tags',
                    'lang' => true,
                    'hint' => array(
                        $this->l('Invalid characters:').' &lt;&gt;;=#{}',
                        $this->l('To add "tags" click in the field, write something, and then press "Enter."')
                    )
                ),
            array(
                    'type' => 'hidden',
                    'label' => $this->l('Image Name'),
                    'name' => 'image',
                ),
                array(
                    'type' => 'file',
                    'label' => $this->l('Image'),
                    'name' => 'image_link',
                    'display_image' => true,
                    'default' => '',
                    'desc' => $this->l('Max file size is: ').($this->max_image_size/1024/1024). 'MB',
                    'thumb' => $thumb,
            'class' => 'anblog_image_upload',
                ),
            array(
                    'type' => 'hidden',
                    'label' => $this->l('Thumb Name'),
                    'name' => 'thumb',
                ),
            array(
                    'type' => 'file',
                    'label' => $this->l('Thumb image'),
                    'name' => 'thumb_link',
                    'display_image' => true,
                    'default' => '',
                    'desc' => $this->l('Max file size is: ').($this->max_image_size/1024/1024). 'MB',
                    'thumb' => $thumb_img,
            'class' => 'anblog_image_upload',
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Video Code'),
                    'name' => 'video_code',
                    'rows' => 5,
                    'cols' => 30,
                    'hint' => $this->l('Enter Video Code Copying From Youtube, Vimeo').' <>;=#{}'
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Blog description'),
                    'name' => 'description',
                    'autoload_rte' => true,
                    'lang' => true,
                    'rows' => 5,
                    'cols' => 30,
                    'hint' => $this->l('Invalid characters:').' <>;=#{}'
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Blog Content'),
                    'name' => 'content',
                    'autoload_rte' => true,
                    'lang' => true,
                    'rows' => 5,
                    'cols' => 40,
                    'hint' => $this->l('Invalid characters:').' <>;=#{}'
                ),
            array(
                    'type' => 'text',
                    'label' => $this->l('Author'),
                    'name' => 'author_name',
            'desc' => $this->l('Author is displayed in the front-end')
                ),
            array(
                    'type' => 'date_anblog',
                    'label' => $this->l('Date'),
                    'name' => 'date_add',
            'default' => date('Y-m-d'),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Indexation (by search engines):'),
                    'name' => 'indexation',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(
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
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Displayed:'),
                    'name' => 'active',
                    'required' => false,
                    'is_bool' => true,
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
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            ),
        'buttons' => array(
                'save_and_preview' => array(
                    'name' => 'saveandstay',
                    'type' => 'submit',
                    'title' => $this->l('Save and stay'),
                    'class' => 'btn btn-default pull-right',
                    'icon' => 'process-icon-save-and-stay'
                )
            )
            
            
        );

        $this->fields_form[1]['form'] = array(
            'tinymce' => true,
            'legend' => array(
                'title' => $this->l('SEO'),
                'icon' => 'icon-folder-close'
            ),
            'input' => array(
                // custom template
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Meta description'),
                    'name' => 'meta_description',
                    'lang' => true,
                    'cols' => 40,
                    'rows' => 10,
                    'hint' => $this->l('Invalid characters:').' &lt;&gt;;=#{}'
                ),
                array(
                    'type' => 'tags',
                    'label' => $this->l('Meta keywords'),
                    'name' => 'meta_keywords',
                    'lang' => true,
                    'hint' => $this->l('Invalid characters:') . ' &lt;&gt;;=#{}',
                    'desc' => array(
                        $this->l('To add a keyword, enter the keyword and then press "Enter"')
                    )
                ),
            )
        );

        $this->tpl_form_vars = array(
            'active' => $this->object->active,
            'PS_ALLOW_ACCENTED_CHARS_URL', (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL')
        );
        $this->context->smarty->assign(
            array(
            'PS_ALLOW_ACCENTED_CHARS_URL' => (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL'),
            'anblog_del_img_txt'         => $this->l('Delete'),
            'anblog_del_img_mess'        => $this->l('Are you sure delete this?'),
            )
        );
        $html = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'anblog/views/templates/admin/prerender/additionaljs.tpl');
        return $html.parent::renderForm();
    }

    public function renderList()
    {
        $this->toolbar_title = $this->l('Blogs Management');
        $this->toolbar_btn['new'] = array(
            // 'href' => self::$currentIndex.'&add'.$this->table.'&id_anblog_blog_category='.(int)'9'.'&token='.$this->token,
        'href' => self::$currentIndex.'&add'.$this->table.'&token='.$this->token,
            'desc' => $this->l('Add new')
        );

        return parent::renderList();
    }


    public function postProcess()
    {
        if (Tools::isSubmit('viewblog') && ($id_anblog_blog = (int)Tools::getValue('id_anblog_blog')) && ($blog = new AnblogBlog($id_anblog_blog, $this->context->language->id)) && Validate::isLoadedObject($blog)) {
            $this->redirect_after = $this->getPreviewUrl($blog);
        }
                
        if (Tools::isSubmit('submitAddanblog_blog') || Tools::isSubmit('submitAddanblog_blogAndPreview') || Tools::isSubmit('saveandstay')) {
            parent::validateRules();
            
            if (count($this->errors)) {
                return false;
            }
            $id_shop = (int)Context::getContext()->shop->id;
            if (!$id_anblog_blog = (int)Tools::getValue('id_anblog_blog')) {
                $blog = new AnblogBlog();
                $this->copyFromPost($blog, 'blog');

                if (isset($_FILES['image_link']) && isset($_FILES['image_link']['tmp_name']) && !empty($_FILES['image_link']['tmp_name'])) {
                    if (!$image = $this->_uploadImage($_FILES['image_link'], '', '')) {
                        return false;
                    }
                    $blog->image = $image;
                }
                
                if (isset($_FILES['thumb_link']) && isset($_FILES['thumb_link']['tmp_name']) && !empty($_FILES['thumb_link']['tmp_name'])) {
                    if (!$thumb = $this->_uploadImage($_FILES['thumb_link'], '', '', true)) {
                        return false;
                    }
                    $blog->thumb = $thumb;
                }
                $blog->id_employee = $this->context->employee->id;

                if (!$blog->add(false)) {
                    $this->errors[] = $this->l('An error occurred while creating an object.').' <b>'.$this->table.' ('.Db::getInstance()->getMsgError().')</b>';
                } else {
                    // validate module
                    $this->updateAssoShop($blog->id);
                }
            } else {
                $blog = new AnblogBlog($id_anblog_blog);
                $this->copyFromPost($blog, 'blog');

                if (isset($_FILES['image_link']) && isset($_FILES['image_link']['tmp_name']) && !empty($_FILES['image_link']['tmp_name'])) {
                    if (file_exists(_ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop.'/'.$id_anblog_blog)) {
                        AnblogHelper::rrmdir(_ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop.'/'.$id_anblog_blog);
                    }
                    if (!$image = $this->_uploadImage($_FILES['image_link'], '', '')) {
                        return false;
                    }
                    $blog->image = $image;
                }
                
                if (isset($_FILES['thumb_link']) && isset($_FILES['thumb_link']['tmp_name']) && !empty($_FILES['thumb_link']['tmp_name'])) {
                    if (file_exists(_ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop.'/'.$id_anblog_blog)) {
                        AnblogHelper::rrmdir(_ANBLOG_CACHE_IMG_DIR_.'b/'.$id_shop.'/'.$id_anblog_blog);
                    }
                    if (!$thumb = $this->_uploadImage($_FILES['thumb_link'], '', '', true)) {
                        return false;
                    }
                    $blog->thumb = $thumb;
                }
                
                if (!$blog->update()) {
                    $this->errors[] = $this->l('An error occurred while creating an object.').' <b>'.$this->table.' ('.Db::getInstance()->getMsgError().')</b>';
                } else {
                    // validate module
                    $this->updateAssoShop($blog->id);
                }
            }

            if (Tools::isSubmit('submitAddblogAndPreview')) {
                // validate module
                $this->redirect_after = $this->previewUrl($blog);
            } elseif (Tools::isSubmit('saveandstay')) {
                // validate module
                Tools::redirectAdmin(self::$currentIndex.'&'.$this->identifier.'='.$blog->id.'&conf=4&update'.$this->table.'&token='.Tools::getValue('token'));
            } else {
                // validate module
                Tools::redirectAdmin(self::$currentIndex.'&id_anblogcat='.$blog->id_anblogcat.'&conf=4&token='.Tools::getValue('token'));
            }
        } else {
            parent::postProcess(true);
        }
    }

    protected function _uploadImage($image, $image_w = null, $image_h = null, $thumb_image = false)
    {
        $res = false;
        $id_shop = (int)Context::getContext()->shop->id;
        AnblogHelper::buildFolder($id_shop);
        if (is_array($image) && (ImageManager::validateUpload($image, $this->max_image_size) === false) && ($tmp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS')) && move_uploaded_file($image['tmp_name'], $tmp_name)) {
            $type = Tools::strtolower(Tools::substr(strrchr($image['name'], '.'), 1));
            if ($thumb_image) {
                $img_name = 't-'.Tools::strtolower(str_replace('.'.$type, '', $image['name']).'.'.$type);
            } else {
                $img_name = 'b-'.Tools::strtolower(str_replace('.'.$type, '', $image['name']).'.'.$type);
            }
            
            if (file_exists(_ANBLOG_BLOG_IMG_DIR_.$id_shop.'/b/'.$img_name)) {
                @unlink(_ANBLOG_BLOG_IMG_DIR_.$id_shop.'/b/'.$img_name);
            }
            $image_type = 'jpg';
            if (Configuration::get('ANBLOG_IMAGE_TYPE') != null) {
                $image_type = Configuration::get('ANBLOG_IMAGE_TYPE');
            }
            // Configuration::set('PS_IMAGE_QUALITY', 'png_all');
            Configuration::set('PS_IMAGE_QUALITY', $image_type);
            if (ImageManager::resize(
                $tmp_name,
                _ANBLOG_BLOG_IMG_DIR_.$id_shop.'/b/'.$img_name,
                (int)$image_w,
                (int)$image_h
            )
            && chmod(_ANBLOG_BLOG_IMG_DIR_.$id_shop.'/b/'.$img_name, 0666)
            ) {

                $res = true;
            }
        }

        if (!$res) {
            // validate module
            return false;
        }

        return $img_name;
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme);
        $this->addJqueryUi('ui.widget');
        $this->addJqueryPlugin('tagify');
        if (file_exists(_PS_THEME_DIR_.'js/modules/anblog/views/assets/admin/form.js')) {
            $this->context->controller->addJS(__PS_BASE_URI__.'modules/anblog/assets/admin/form.js');
        } else {
            $this->context->controller->addJS(__PS_BASE_URI__.'modules/anblog/views/js/admin/form.js');
        }
        
        if (file_exists(_PS_THEME_DIR_.'css/modules/anblog/views/assets/admin/form.css')) {
            $this->context->controller->addCss(__PS_BASE_URI__.'modules/anblog/views/assets/admin/form.css');
        } else {
            $this->context->controller->addCss(__PS_BASE_URI__.'modules/anblog/views/css/admin/form.css');
        }
    }

    public function ajaxProcessUpdateblogPositions()
    {
        if ($this->tabAccess['edit'] === '1') {
            $id_anblog_blog = (int)Tools::getValue('id_anblog_blog');
            $id_category = (int)Tools::getValue('id_anblog_blog_category');
            $way = (int)Tools::getValue('way');
            $positions = Tools::getValue('blog');
            if (is_array($positions)) {
                foreach ($positions as $key => $value) {
                    $pos = explode('_', $value);
                    if ((isset($pos[1]) && isset($pos[2])) && ($pos[1] == $id_category && $pos[2] == $id_anblog_blog)) {
                        $position = $key;
                        break;
                    }
                }
            }
            $blog = new blog($id_anblog_blog);
            if (Validate::isLoadedObject($blog)) {
                if (isset($position) && $blog->updatePosition($way, $position)) {
                    die(true);
                } else {
                    die('{"hasError" : true, "errors" : "Can not update blog position"}');
                }
            } else {
                die('{"hasError" : true, "errors" : "This blog can not be loaded"}');
            }
        }
    }

    public function ajaxProcessUpdateblogCategoriesPositions()
    {
        if ($this->tabAccess['edit'] === '1') {
            $id_anblog_blog_category_to_move = (int)Tools::getValue('id_anblog_blog_category_to_move');
            $id_anblog_blog_category_parent = (int)Tools::getValue('id_anblog_blog_category_parent');
            $way = (int)Tools::getValue('way');
            $positions = Tools::getValue('blog_category');
            if (is_array($positions)) {
                foreach ($positions as $key => $value) {
                    $pos = explode('_', $value);
                    if ((isset($pos[1]) && isset($pos[2])) && ($pos[1] == $id_anblog_blog_category_parent && $pos[2] == $id_anblog_blog_category_to_move)) {
                        $position = $key;
                        break;
                    }
                }
            }
            $blog_category = new blogCategory($id_anblog_blog_category_to_move);
            if (Validate::isLoadedObject($blog_category)) {
                if (isset($position) && $blog_category->updatePosition($way, $position)) {
                    die(true);
                } else {
                    die('{"hasError" : true, "errors" : "Can not update blog categories position"}');
                }
            } else {
                die('{"hasError" : true, "errors" : "This blog category can not be loaded"}');
            }
        }
    }

    public function ajaxProcessPublishblog()
    {
        if ($this->tabAccess['edit'] === '1') {
            if ($id_anblog_blog = (int)Tools::getValue('id_anblog_blog')) {
                $bo_blog_url = dirname($_SERVER['PHP_SELF']).
                    '/index.php?tab=AdminblogContent&id_anblog_blog='.
                    (int)$id_anblog_blog.'&updateblog&token='.$this->token;

                if (Tools::getValue('redirect')) {
                    die($bo_blog_url);
                }

                $blog = new blog((int)(Tools::getValue('id_anblog_blog')));
                if (!Validate::isLoadedObject($blog)) {
                    die('error: invalid id');
                }

                $blog->active = 1;
                if ($blog->save()) {
                    die($bo_blog_url);
                } else {
                    die('error: saving');
                }
            } else {
                die('error: parameters');
            }
        }
    }
}
