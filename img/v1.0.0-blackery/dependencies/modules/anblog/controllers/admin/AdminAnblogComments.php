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

class AdminAnblogCommentsController extends ModuleAdminController
{
    protected $max_image_size = 1048576;
    protected $position_identifier = 'id_anblog_blog';

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'anblog_comment';
        //        $this->list_id = 'id_comment';        // must be set same value $this->table to delete multi rows
        $this->identifier = 'id_comment';
        $this->className = 'AnblogComment';
        $this->lang = false;

        $this->addRowAction('edit');
        $this->addRowAction('delete');

        if (Tools::getValue('id_anblog_blog')) {
            // validate module
            $this->_where = ' AND id_anblog_blog='.(int)Tools::getValue('id_anblog_blog');
        }
        parent::__construct();
        
        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?'),
                'icon' => 'icon-trash'
            )
        );

        $this->fields_list = array(
            'id_comment' => array('title' => $this->l('ID'), 'align' => 'center', 'class' => 'fixed-width-xs'),
            'id_anblog_blog' => array(
                'title' => $this->l('Blog ID'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'user' => array('title' => $this->l('User')),
            'comment' => array('title' => $this->l('Comment')),
            'date_add' => array('title' => $this->l('Date Added'),'type' => 'datetime'),
            'active' => array(
                'title' => $this->l('Displayed'),
                'align' => 'center',
                'active' => 'status',
                'class' => 'fixed-width-sm',
                'type' => 'bool',
                'orderby' => false
            )
        );
    }

    public function initPageHeaderToolbar()
    {
        $link = $this->context->link;

        if (Tools::getValue('id_anblog_blog')) {
            $this->page_header_toolbar_btn['back-blog'] = array(
                'href' => $link->getAdminLink('AdminAnblogBlogs').'&updateanblog_blog&id_anblog_blog='.Tools::getValue('id_anblog_blog'),
                'desc' => $this->l('Back To The Blog'),
                'icon' => 'icon-blog icon-3x process-icon-blog'
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


        $blog = new AnblogBlog($this->object->id_anblog_blog, $this->context->language->id);

        $this->multiple_fieldsets = true;
        $this->object->blog_title = $blog->meta_title;

        $this->fields_form[0]['form'] = array(
            'tinymce' => true,
            'legend' => array(
                'title' => $this->l('Blog Form'),
                'icon' => 'icon-folder-close'
            ),
            'input' => array(
                array(
                    'type' => 'hidden',
                    'label' => $this->l('Comment ID'),
                    'name' => 'id_comment',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Blog Title'),
                    'name' => 'blog_title',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('User'),
                    'name' => 'user',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Email'),
                    'name' => 'email',
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Blog Content'),
                    'name' => 'comment',
                    'rows' => 5,
                    'cols' => 40,
                    'hint' => $this->l('Invalid characters:').' <>;=#{}'
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

    public function initToolbar()
    {
        parent::initToolbar();

        unset($this->toolbar_btn['new']);
    }

    public function renderList()
    {

        $config = new AnblogConfig();
        if ((!$config->get('google_captcha_site_key') || !$config->get('google_captcha_secret_key')) && $config->get('google_captcha_status')) {
            $this->context->controller->errors[] = 'Please fill reCAPTCHA site and secret keys in Dashboard -> Item Blog Settings to enable comments';
            return false;
        }
        $this->toolbar_title = $this->l('Comments Management');

        return parent::renderList();
    }


    
    //DONGND:: add save and stay
    public function postProcess()
    {
        if (Tools::isSubmit('saveandstay')) {
            parent::validateRules();

            if (count($this->errors)) {
                return false;
            }

            if ($id_comment = (int)Tools::getValue('id_comment')) {
                $comment = new AnblogComment($id_comment);
                $this->copyFromPost($comment, 'comment');

                if (!$comment->update()) {
                    $this->errors[] = $this->l('An error occurred while creating an object.').' <b>'.$this->table.' ('.Db::getInstance()->getMsgError().')</b>';
                } else {
                    Tools::redirectAdmin(self::$currentIndex.'&'.$this->identifier.'='.Tools::getValue('id_comment').'&conf=4&update'.$this->table.'&token='.Tools::getValue('token'));
                }
            } else {
                $this->errors[] = $this->l('An error occurred while creating an object.').' <b>'.$this->table.' ('.Db::getInstance()->getMsgError().')</b>';
            }
        } else {
                parent::postProcess();
        }
    }
}
