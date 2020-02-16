<?php
/**
* 2007-2017 PrestaShop
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
*  @author    Apply Novation <applynovation@gmail.com>
*  @copyright 2016-2017 Apply Novation
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

require_once _PS_MODULE_DIR_.'anthemeblocks/classes/AnThemeBlockCollection.php';

class AdminThemeBlocksController extends ModuleAdminController
{
    private $views_dir = '';

    protected $_errors = array(); //non-critical errors

    protected $view_parent_id;
    protected $add_parent_id;

    protected $position_identifier = 'id_anthemeblock';

    public $fieldImageSettings = array(
        'name' => 'image',
        'dir' => ''
    );

    protected $_defaultOrderBy = 'position';
    protected $_defaultOrderWay = 'ASC';

    public function __construct()
    {
        $this->pagination = array(1000);
        $this->default_pagination = 1000;

        $this->views_dir = _PS_MODULE_DIR_.'anthemeblocks'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'front';
        $this->bootstrap = true;
        $this->table = 'anthemeblock';
        $this->identifier = 'id_anthemeblock';
        $this->className = 'AnThemeBlock';
        $this->lang = true;
        $this->view_parent_id = (int)Tools::getValue('id_anthemeblock');
        $this->add_parent_id = (int)Tools::getValue('id_parent');

        if (!$this->view_parent_id) {
            $this->addRowAction('view');
        }

        $this->addRowAction('edit');
        $this->addRowAction('delete');

        parent::__construct();

        $this->fields_list = array(
            'id_anthemeblock' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 30,
                'orderby' => false
            ),
            'title' => array(
                'title' => $this->l('Block Title'),
                'width' => 200,
                'orderby' => false
            ),
            'position' => array(
                'title' => $this->l('Position'),
                'width' => 30,
                // 'position' => true,
                'type' => 'position'
            ),
            'template' => array(
                'title' => $this->l('Template'),
                'width' => 30,
                'orderby' => false
            ),
            'image' => array(
                'title' => $this->l('Image'),
                'width' => 30,
                'type' => 'image',
                'orderby' => false
            ),
            'status' => array(
                'title' => $this->l('Status'),
                'width' => 40,
                'active' => 'update',
                'align' => 'center',
                'type' => 'bool',
                'orderby' => false
            )
        );

        if ($this->view_parent_id == 0) {
            $this->fields_list['hook_ids'] = array(
                'title' => $this->l('Hooks'),
                'width' => 150,
                'align' => 'right',
                'orderby' => false,
                'search' => false
            );

            $this->fields_list['block_identifier'] = array(
                'title' => $this->l('Identifier'),
                'width' => 100
            );
        }

        $this->fields_list['date_upd'] = array(
            'title' => $this->l('Last Modified'),
            'width' => 150,
            'type' => 'date',
            'align' => 'right',
            'orderby' => false
        );

        $this->_where .= ' AND a.id_parent = ' . $this->view_parent_id . ' ';

        if (Shop::isFeatureActive() && Shop::getContext() != Shop::CONTEXT_ALL) {
            $this->_where .= ' AND a.' . $this->identifier . ' IN (
                SELECT sa.' . $this->identifier . '
                FROM `' . _DB_PREFIX_ . $this->table . '_shop` sa
                WHERE sa.id_shop IN (' . implode(', ', Shop::getContextListShopID()) . ')
            )';
        }

        $this->identifiersDnd = array('id_anthemeblock' => 'id_sslide_to_move');
    }

    public function initToolbarTitle()
    {
        if ($this->view_parent_id && $this->display == 'view') {
            $obj = $this->loadObject(true);
            $title = $obj->title[$this->context->language->id];
            $this->toolbar_title[] = $this->l('View children of ', null, null, false) . $title;
            $this->addMetaTitle($this->l('View children of ', null, null, false)) . $title;
        } else {
            parent::initToolbarTitle();
        }
    }

    public function initToolbar()
    {
        parent::initToolbar();

        $this->toolbar_btn['new'] = array(
            'href' => self::$currentIndex.'&add'.$this->table.'&token='.$this->token.'&id_parent='.$this->view_parent_id,
            'desc' => $this->l('Add new')
        );
    }

    protected function getErrors()
    {
        $errors = Tools::jsonDecode(urldecode(Tools::getValue('errors', '')), true);

        return is_array($errors) ? '<div class="alert alert-danger">'.implode('<br>', $errors).'</div>' : '';
    }

    public function renderView()
    {
        return $this->renderList();
    }

    public function renderForm()
    {
        $this->display = 'edit';
        $this->initToolbar();

        if (!$obj = $this->loadObject(true)) {
            return;
        }

        if (!$obj->id) {
            $obj->id_parent = $this->add_parent_id;

            if ($obj->id_parent == 0) {
                if (Tools::getIsset('template')) {
                    $template = Tools::getValue('template');
                    $template = 'views/templates/front/'.$template.'/'.$template.'.tpl';

                    if (Tools::file_exists_no_cache(_PS_MODULE_DIR_.'anthemeblocks/'.$template)) {
                        $obj->template = $template;
                    }
                }
            }
        }

        $image = $obj->getImage();
        $image_url = false;
        $thumb_size = false;

        if (file_exists($image)) {
            $image_url = '<img src="../modules/anthemeblocks/images/' . $obj->img . '.jpg?rand='.rand(1, 1000).'" alt="" class="imgm img-thumbnail" />';
            $thumb_size = filesize($image) / 1000;
        }

        $ignore = Anthemeblocks::$ignore_form_hook;

        $hooks = array_filter(array_merge(
            array(
                array(
                    'name' => '',
                    'title' => ''
                )
            ),
            Anthemeblocks::getHooks()
        ), function ($hook) use ($ignore) {
            return !in_array($hook['name'], $ignore);
        });

        $parentBlocks = new Collection('AnThemeBlock', $this->context->language->id);
        $parentBlocks->where('id_parent', '=', 0);
        if ($obj->id_parent) {
            $parentBlocks->where('id_anthemeblock', '=', $obj->id_parent);
        } else if ($obj->id) {
            $parentBlocks->where('id_anthemeblock', '!=', $obj->id);
        }

        $parentBlocks = array_merge(
            array(
                array(
                    'id_anthemeblock' => '',
                    'title' => ''
                )
            ),
            $parentBlocks->getResults()
        );

        if ($obj->id_parent) {
            array_shift($parentBlocks);
        }

        $_child = false;

        if (isset($parentBlocks[0]) && $parentBlocks[0] instanceof AnThemeBlock && isset($parentBlocks[0]->template)) {
            $_tpl_part = explode('/', $parentBlocks[0]->template);
            $_child = $_tpl_part[count($_tpl_part)-1];
        }
    
        $templates = AnThemeBlock::getTemplates($_child !== false ? $_child : false, $this->object);
        $template_info = AnThemeBlock::getTemplateInfo(new SplFileInfo(_PS_MODULE_DIR_.'anthemeblocks/'.$obj->template), $_child !== false ? $_child : false, $this->object);
        $additional_fields = array();

        if ($obj->id_parent == 0) {
            if (isset($template_info['config']['fields'])) {
                $additional_fields = array_merge($additional_fields, $template_info['config']['fields']);
            }
        } else {
            foreach ($templates as $tpl) {
                if (isset($tpl['config']['fields'])) {
                    $additional_fields = array_merge($additional_fields, $tpl['config']['fields']);
                }
            }
        }

        $this->fields_form = array(
            'tinymce' => true,
            'legend' => array(
                'title' => $this->l('Static Block'),
                'image' => '../img/admin/add.gif'
            ),
            'input' => array_merge(array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Title:'),
                    'name' => 'title',
                    'id' => 'title',
                    'lang' => true,
                    'required' => true,
                    'size' => 50,
                    'maxlength' => 50,
                ),
                /*array(
                    'type' => 'text',
                    'label' => $this->l('Identifier:'),
                    'name' => 'block_identifier',
                    'id' => 'block_identifier',
                    'required' => true,
                    'hint' => $this->l('Allowed characters:') . ' a-z, A-Z, 0-9, _',
                    'size' => 50,
                    'maxlength' => 50,
                ),*/
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enabled:'),
                    'name' => 'status',
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(array(
                        'id' => 'is_enabled_on',
                        'value' => 1), array(
                        'id' => 'is_enabled_off',
                        'value' => 0)
                    )
                ),
                array(
                    'type' => 'hidden',
                    'label' => $this->l('Parent Block:'),
                    'name' => 'id_parent',
                    'index' => 'id_parent',
                    'style' => 'width:100px;',
                    'class' => 'fixed-width-xxl',
                    'options' => array(
                        'query' => $parentBlocks,
                        'id' => 'id_anthemeblocks',
                        'name' => 'title',
                    ),
                ),
                array(
                    'type' => 'hidden',
                    'label' => $this->l('Position:'),
                    'name' => 'position',
                    'id' => 'position',
                    'size' => 50,
                    'maxlength' => 10,
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('PrestaShop Hook:'),
                    'name' => 'hook_ids[]',
                    'index' => 'hook_ids[]',
                    'style' => 'width:100px;',
                    'class' => 'fixed-width-xxl',
                    'options' => array(
                        'query' => $hooks,
                        'id' => 'name',
                        'name' => 'name',
                    ),
                    'desc' => $this->l("Leave empty if you dont want to assign the block to a standard hook."),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Link:'),
                    'name' => 'link',
                    'id' => 'link',
                    'lang' => true,
                ),
                array(
                   'type' => 'file',
                   'label' => $this->l('Image'),
                   'name' => 'image',
                   'display_image' => true,
                   'image' => $image_url,
                   'size' => $thumb_size,
                   'format' => version_compare(_PS_VERSION_, '1.7.0.0', '<') ? ImageType::getFormatedName('medium') : ImageType::getFormattedName('medium'),
                   'delete_url' => self::$currentIndex.'&'.$this->identifier.'='.$obj->id.'&token='.$this->token.'&deleteImage=1',
                ),
                array(
                    'type' => empty($templates) || count($templates) == 1 ? 'hidden' : 'select',
                    'label' => $this->l('Template:'),
                    'name' => 'template',
                    'index' => 'template',
                    'style' => 'width:100px;',
                    'class' => 'fixed-width-xxl',
                    'options' => array(
                        'query' => $templates,
                        'id' => 'file',
                        'name' => 'name',
                    ),
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Content:'),
                    'name' => 'content',
                    'autoload_rte' => true,
                    'lang' => true,
                    'rows' => 5,
                    'cols' => 40,
                ),
            ), $additional_fields),
            'buttons' => array(
                array(
                    'type' => 'submit',
                    'title' => $this->l('Save'),
                    'icon' => 'process-icon-save',
                    'class' => 'pull-right',
                    'name' => 'submitAdd'.$this->table.'AndBackToParent'
                ),
                array(
                    'type' => 'submit',
                    'title' => $this->l('Save and stay'),
                    'icon' => 'process-icon-save',
                    'class' => 'pull-right',
                    'name' => 'submitAdd'.$this->table
                ),
            )
        );

        foreach ($this->fields_form['input'] as $key => $input) {
            $unset = false;
            if ($input['name'] == 'hook_ids[]' && $obj->id_parent) {
                $unset = true;
            }

            if ($input['name'] == 'id_parent' && !$obj->id_parent) {
                $unset = true;
            }

            /*if (!$obj->id && in_array($input['name'], array('hook_ids[]', 'template'))) {
                $unset = true;
            }*/

            if ($unset) {
                unset($this->fields_form['input'][$key]);
            }
        }

        $this->fields_value['hook_ids[]'] = $this->object->hook_ids;

        if ($obj->formdata instanceof AnThemeBlockData) {
            $data = $obj->formdata->getData();
            $id_lang = (int)Context::getContext()->language->id;
            
            if (isset($data[$id_lang])) {
                foreach ($data[$id_lang] as $key => $value) {
                    $this->fields_value[$key] = $value;
                }
            }
        }

        if (count($templates) == 1 && isset($templates[0], $templates[0]['file'])) {
            $this->fields_value['template'] = $templates[0]['file'];
        }

        if (Shop::isFeatureActive()) {
            $this->fields_form['input'][] = array(
                'type' => 'shop',
                'label' => $this->l('Shop association:'),
                'name' => 'checkBoxShopAsso',
            );
        }

        $this->tpl_form_vars = array(
            'status' => $this->object->status
        );

        $content = parent::renderForm();

        try {
            $this->context->smarty->assign(array(
                'id' => (int)$obj->id,
                'id_parent' => (int)$obj->id_parent,
                'templates' => $templates,
                'template' => ($template = array_filter($templates, function ($tpl) use ($obj) {
                    return $tpl['file'] == $obj->template;
                })) && !empty($template) ? array_shift($template) : false,
                'cancel_url' => $obj->id_parent ? $this->context->link->getAdminLink($this->controller_name).'&'.$this->identifier.'='.$obj->id_parent.'&viewanthemeblock&conf=4&token='.$this->token : $this->context->link->getAdminLink($this->controller_name).'&conf=4&token='.$this->token
            ));

            $_content = $this->context->smarty->createTemplate(_PS_MODULE_DIR_.'anthemeblocks/views/templates/admin/configure.tpl', null, null, $this->context->smarty)->fetch();

            if ((int)$obj->id_parent == 0 && Tools::getIsset('addanthemeblock') && !Tools::getIsset('template')) {
                $this->context->smarty->assign(array(
                    'template_select_url' => $this->context->link->getAdminLink($this->controller_name).'&addanthemeblock&id_parent=0&token='.$this->token.'&template='
                ));

                return $this->getErrors().$this->context->smarty->createTemplate(_PS_MODULE_DIR_.'anthemeblocks/views/templates/admin/step_one.tpl', null, null, $this->context->smarty)->fetch();
            }

            $content = $_content.$content;
        } catch (SmartyException $e) {
            // var_dump($e->getMessage());
        }
        
        return $this->getErrors().$content;
    }

    public function getList($id_lang, $order_by = null, $order_way = null, $start = 0, $limit = null, $id_lang_shop = false)
    {
        parent::getList($id_lang, $order_by, $order_way, $start, $limit, $id_lang_shop);
        
        foreach ($this->_list as &$list) {
            if (Tools::file_exists_no_cache(_PS_MODULE_DIR_.'anthemeblocks/images/'.$list['img'].'.jpg')) {
                $list['image'] = '<img style="max-width: 75px; max-height: 75px" src="../modules/anthemeblocks/images/'.$list['img'].'.jpg?rand='.rand(1, 1000).'" alt="" class="imgm img-thumbnail" />';
            } else {
                $list['image'] = $this->l('No image');
            }

            $list['disabled_actions'] = array();
            
            $_child = false;

            if ((int)$list['id_parent'] == 0) {
                if (isset($list['template'])) {
                    $_tpl_part = explode('/', $list['template']);
                    $_child = $_tpl_part[count($_tpl_part)-1];
                }

                $list['template'] = ($template = array_filter(AnThemeBlock::getTemplates(), function ($tpl) use ($list) {
                    return $list['template'] == $tpl['file'];
                })) && count($template) && ($template = array_shift($template)) ? $template['name'] : $this->l('No template');

                if (!count(iterator_to_array(AnThemeBlock::getTemplatesLow($_child)))) {
                    $list['disabled_actions'][] = 0; //disable view action
                }
            } else {
                if (isset($list['template'])) {
                    $_tpl_part = explode('/', $list['template']);
                    $_child = $_tpl_part[count($_tpl_part)-2];
                }

                $list['template'] = ($template = array_filter(AnThemeBlock::getTemplates($_child), function ($tpl) use ($list) {
                    return $list['template'] == $tpl['file'];
                })) && count($template) && ($template = array_shift($template)) ? $template['name'] : $this->l('No template');
            }
        }
    }

    protected function updateAssoShop($id_object)
    {
        if (!Shop::isFeatureActive()) {
            return;
        }

        $assos_data = $this->getSelectedAssoShop($this->table, $id_object);

        $exclude_ids = $assos_data;

        foreach (Db::getInstance()->executeS('SELECT id_shop FROM ' . _DB_PREFIX_ . 'shop') as $row) {
            if (!$this->context->employee->hasAuthOnShop($row['id_shop'])) {
                $exclude_ids[] = $row['id_shop'];
            }
        }

        Db::getInstance()->delete($this->table . '_shop', '`' . $this->identifier . '` = ' . (int) $id_object . ($exclude_ids ? ' AND id_shop NOT IN (' . implode(', ', $exclude_ids) . ')' : ''));

        $insert = array();

        foreach ($assos_data as $id_shop) {
            $insert[] = array(
                $this->identifier => $id_object,
                'id_shop' => (int) $id_shop,
            );
        }

        return Db::getInstance()->insert($this->table . '_shop', $insert, false, true, Db::INSERT_IGNORE);
    }

    protected function getSelectedAssoShop($table)
    {
        if (!Shop::isFeatureActive()) {
            return array();
        }

        $shops = Shop::getShops(true, null, true);

        if (count($shops) == 1 && isset($shops[0])) {
            return array($shops[0], 'shop');
        }

        $assos = array();

        if (Tools::isSubmit('checkBoxShopAsso_' . $table)) {
            foreach (Tools::getValue('checkBoxShopAsso_' . $table) as $id_shop => $value) {
                $assos[] = (int) $id_shop;
            }
        } else if (Shop::getTotalShops(false) == 1) {
            // if we do not have the checkBox multishop, we can have an admin with only one shop and being in multishop
            $assos[] = (int) Shop::getContextShopID();
        }

        return $assos;
    }

    protected function getValidationRules()
    {
        $definition = ObjectModel::getDefinition($this->className);

        if (isset(AnThemeBlock::$definition['fields']['content']['required']) && AnThemeBlock::$definition['fields']['content']['required'] === true) {
            $definition['fields']['content']['required'] = true;
        }

        return $definition;
    }

    public function processDeleteImage()
    {
        $object = parent::processDeleteImage();

        if (Validate::isLoadedObject($object)) {
            $this->redirect_after = self::$currentIndex.'&update'.$this->table.'&'.$this->identifier.'='.Tools::getValue($this->identifier).'&conf=7&token='.$this->token;
        }
    }

    public function processSave()
    {
        $id_parent = (int)Tools::getValue('id_parent');
        $data = array();
        $template = null;
        $do_save = true;

        if (Tools::getIsset('template')) {
            $template = _PS_MODULE_DIR_.'anthemeblocks/'.Tools::getValue('template');
            $template_info = AnThemeBlock::getTemplateInfo(new SplFileInfo($template), (bool)$id_parent);

            if (isset($template_info['config'])) {
                if ($template_info['config']['homeproducts']) {
                    $itemType = Tools::getValue('additional_field_item_type');
                    $selectedCategories = Tools::getValue('categoryBox');

                    if ($itemType == 'featured' && empty($selectedCategories)) {
                        $this->_errors[] = $this->l('Please select category');
                        $do_save = false;
                    }
                }

                if ($template_info['config']['enabled_text'] === true && $template_info['config']['required_text'] === true) {
                    AnThemeBlock::$definition['fields']['content']['required'] = true;
                }

                if (isset($template_info['config']['fields'])) {
                    foreach ($template_info['config']['fields'] as $key => $field) {
                        if (isset($field['ignore']) && $field['ignore'] == true) {
                            continue;
                        }

                        $value = Tools::getValue($field['name']);

                        if (isset($template_info['config']['fields'][$key]['validator'])) {
                            $validator = AnThemeBlockDataValidator::create($value, $template_info['config']['fields'][$key]['validator']);

                            if (!$validator->validate()) {
                                if (isset($template_info['config']['fields'][$key]['required']) && $template_info['config']['fields'][$key]['required'] === true) {
                                    $this->errors[] = sprintf($validator->getMessage(), $field['label']);
                                    $do_save = false;
                                } else {
                                    $this->_errors[] = sprintf($validator->getMessage(), $field['label']);
                                }

                                $data[$field['name']] = null;
                            } else {
                                $data[$field['name']] = $value;
                            }
                        } else {
                            $data[$field['name']] = $value;
                        }
                    }
                }
            }
        }
        
        $object = null;
        if ($this->module->new){
            if (isset($selectedCategories) && !empty($selectedCategories)){
                $data['additional_field_item_value'] = implode(',',$selectedCategories);
            }
        }
        try {
            if ($do_save) {
                $object = parent::processSave();
            } else {
                $object = $this->loadObject();
            }
        } catch (PrestaShopException $e) {
            $this->errors[] = $e->getMessage();
        }

        if (!Validate::isLoadedObject($object)) {
            $this->redirect_after = $this->context->link->getAdminLink($this->controller_name).'&id_parent='.$id_parent.'&addanthemeblock&token='.$this->token.'&back=1';

            if (!empty($template)) {
                $this->redirect_after .= '&template='.basename($template, '.tpl');
            }
        } else {
            $collection = new Collection('AnThemeBlockData');
            $formdata = $collection->where('id_anthemeblock', '=', $object->id)->getFirst();
                    
            if ($formdata === false) {
                $formdata = new AnThemeBlockData();
            }

            foreach ($data as $field_name => &$_data) {
                if ($_data === null) {
                    $_data = $formdata->{$field_name};
                }
            }

            $formdata->setIdBlock($object->id)->setData($data)->save();

            if (Tools::getIsset('submitAdd'.$this->table.'AndBackToParent')) {
                $this->redirect_after = $this->context->link->getAdminLink($this->controller_name).($id_parent > 0 ? '&'.$this->identifier.'='.$id_parent.'&viewanthemeblock' : '').'&token='.$this->token;
            } else {
                $this->redirect_after = $this->context->link->getAdminLink($this->controller_name).'&updateanthemeblock&token='.$this->token.'&back=1&'.$this->identifier.'='.$object->id;
            }
        }

        if (count($this->_errors) || count($this->errors)) {
            $this->redirect_after .= '&errors='.urlencode(Tools::jsonEncode(array_merge($this->_errors, (array)$this->errors)));
        } else {
            $this->redirect_after .= '&conf=4';
            $this->doExportObjects();
        }

        return $object;
    }
    
    protected function deleteLinks($content)
    {
        
        $hrefs = array();
        preg_match_all('/href="[^"]*"/i', $content, $hrefs);
        foreach ($hrefs[0] as $href) {
            $content = str_replace($href, 'href="#"', $content);
        }
        return $content;
    }

    public function doExportObjects()
    {
        foreach ($this->exportObjects() as $_object) {
            $_object['link'] = '#';
            $_object['content'] = $this->deleteLinks($_object['content']);
            
            
            foreach ($_object['children'] as $key => $item) {
                $_object['children'][$key]['link'] = '#';
                $_object['children'][$key]['content'] = $this->deleteLinks($_object['children'][$key]['content']);
            }
            
            @file_put_contents($this->module->blocks_dir.$_object['block_identifier'].'.json', Tools::jsonEncode($_object));
        }
    }

    protected function afterUpdate($object)
    {
        $this->object = $object;
        return true;
    }

    public function exportObjects($id_parent = 0)
    {
        $_this = $this;
        $collection = new Collection($this->className);
        return array_map(function ($object) use ($_this) {
            return array_merge($object->loadFormdata()->export(), array('children' => $_this->exportObjects($object->id)));
        }, iterator_to_array($collection->where('id_parent', '=', (int)$id_parent)));
    }

    protected function copyFromPost(&$object, $table)
    {
        parent::copyFromPost($object, $table);
        $object->useDataAsArray('hook_ids', Tools::getValue('hook_ids', array()));
    }

    public function ajaxProcessUpdatePositions()
    {
        $status = false;
        $position = 1;
        $positions = array_map('intval', (array)Tools::getValue('positions'));
        $blocks = new AnThemeBlockCollection($this->className);

        $status = !count(array_filter(array_map(function ($block) use (&$position) {
            return !$block->setPosition($position++)->update();
        }, iterator_to_array($blocks->where('id_anthemeblock', 'in', $positions)->customOrder('FIELD(a0.`id_anthemeblock`, '.implode(',', $positions).')')))));

        $this->doExportObjects();

        return $this->setJsonResponse(array(
            'success' => $status,
            'message' => $this->l($status ? 'Blocks reordered successfully' : 'An error occurred')
        ));
    }

    protected function setJsonResponse($response)
    {
        header('Content-Type: application/json; charset=utf8');
        print(Tools::jsonEncode($response));
        exit;
    }

    protected function uploadImage($id, $name, $dir, $ext = false, $width = null, $height = null)
    {
        $uniqName = uniqid();
        $object = $this->loadObject();

        if (!Validate::isLoadedObject($object)) {
            return false;
        }

        if (isset($_FILES[$name]['tmp_name']) && !empty($_FILES[$name]['tmp_name'])) {
            $object->deleteImage();

            // Check image validity
            $max_size = isset($this->max_image_size) ? $this->max_image_size : 0;

            if ($error = ImageManager::validateUpload($_FILES[$name], Tools::getMaxUploadSize($max_size))) {
                $this->errors[] = $error;
            }

            $tmp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');

            if (!$tmp_name) {
                return false;
            }

            if (!move_uploaded_file($_FILES[$name]['tmp_name'], $tmp_name)) {
                return false;
            }

            // Evaluate the memory required to resize the image: if it's too much, you can't resize it.
            if (!ImageManager::checkImageMemoryLimit($tmp_name)) {
                $this->errors[] = Tools::displayError('Due to memory limit restrictions, this image cannot be loaded. Please increase your memory_limit value via your server\'s configuration settings. ');
            }

            // Copy new image
            if (empty($this->errors) && !ImageManager::resize($tmp_name, AnThemeBlock::getImagesPath().$uniqName.'.'.$this->imageType, (int)$width, (int)$height, ($ext ? $ext : $this->imageType))) {
                $this->errors[] = Tools::displayError('An error occurred while uploading the image.');
            }

            if (!count($this->errors)) {
                if ($this->afterImageUpload()) {
                    $object->img = $uniqName;
                    $object->save();
                    unlink($tmp_name);
                    return true;
                }
            }

            return false;
        }

        return true;
    }
}
