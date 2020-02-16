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

class AnThemeBlock extends ObjectModel
{
    public $id;

    /** @var integer block ID */
    public $id_anthemeblock;

    public $id_parent;

    /** @var string Title */
    public $title;

    /** @var string Identifier */
    public $block_identifier;

    /** @var boolean Status for display */
    public $status = 1;

    public $hook_ids;
    
    public $position;

    /** @var string Content */
    public $content;

    /** @var string Object creation date */
    public $date_add;

    /** @var string Object last modification date */
    public $date_upd;

    public $link;

    public $image;

    public $template;

    public $img;

    protected $config;

    public $products = array();

    public $formdata = array();

    public $page_number = 0;
    public $nb_products = 5;
    public $limit = 5;

    public static $definition = array(
        'table' => 'anthemeblock',
        'primary' => 'id_anthemeblock',
        'multilang' => true,
        'fields' => array(
            'block_identifier' => array('type' => self::TYPE_STRING, 'size' => 50),
            'id_parent' => array('type' => self::TYPE_INT),
            'status' => array('type' => self::TYPE_INT),
            'position' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'date_add' => array('type' => self::TYPE_DATE),
            'date_upd' => array('type' => self::TYPE_DATE),
            'hook_ids' => array('type' => self::TYPE_STRING),
            'template' => array('type' => self::TYPE_STRING),
            
            'img' => array('type' => self::TYPE_STRING),

            // Lang fields
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isString', 'required' => true, 'size' => 128),
            'content' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString', 'size' => 3999999999999),
            'image' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isString', 'size' => 3999999999999),
            'link' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isString', 'size' => 3999999999999),
        ),
        'associations' => array(
            'AnThemeBlockData' => array('object' => 'AnThemeBlockData', 'field' => 'id_anthemeblock', 'foreign_field' => 'id_anthemeblock')
        )
    );

    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);
        return $this->loadFormdata();
    }

    public function add($auto_date = true, $null_values = false)
    {
        if (empty($this->block_identifier)) {
            $this->block_identifier = uniqid();
        }
    
        return parent::add($auto_date, $null_values);
    }

    public function setFormdata($data)
    {
        $this->formdata = $data;
        return $this;
    }

    public function getFormdata()
    {
        return $this->formdata;
    }

    public static function getViewsDir()
    {
        return _PS_MODULE_DIR_.'anthemeblocks/views/templates/front';
    }

    public function getField($field, $default_value = false)
    {
        return !array_key_exists($field, $this->formdata) ? $default_value : $this->formdata[$field];
    }
    
    public static function getTemplates($child = false, $object = null)
    {
        try {
            return array_map(function ($file) use ($child, $object) {
                return AnThemeBlock::getTemplateInfo($file, $child, $object);
            }, iterator_to_array(self::getTemplatesLow($child)), array()); //fix keys
        } catch (Exception $e) {
            return array();
        }
    }

    public static function getTemplateInfo($file, $child = false, $object = null, $load_form = true)
    {
        $views_dir = self::getViewsDir();
        $basename = $file->getBasename('.tpl');
        $config = self::getDefaultConfig();
        $config['basename'] = $basename;
        $path = $file->getPath();

        if (!is_dir($path)) {
            $path = _PS_MODULE_DIR_.'anthemeblocks/'.$path;
        }

        $config = $child === false ?
            array_merge($config, (array)Spyc::YAMLLoad(Tools::file_get_contents($path.'/config.yml'))) :
            array_merge($config, (array)Spyc::YAMLLoad(Tools::file_get_contents($path.'/'.$basename.'.yml')));

        if ($load_form === true) {
            if (isset($config['homeproducts']) && $config['homeproducts'] === true) {
                $config['fields'] = isset($config['fields']) ? array_merge($config['fields'], Module::getInstanceByName('anthemeblocks')->renderHomeproductsForm($object)) : Module::getInstanceByName('anthemeblocks')->renderHomeproductsForm($object);
            }

            if (isset($config['fields'])) {
                $config['fields'] = array_map(function ($field) use ($file) {
                    $basename = $file->getBasename('.tpl');

                    $field['ignore'] = isset($field['ignore']) ? (bool)$field['ignore'] : false;
                    $field['name'] = 'additional_field_'.$basename.'_'.$field['name'];

                    if (isset($field['default_value'])) {
                        $field['default_value'] = str_replace('#tpl#', $basename, $field['default_value']);
                    }

                    return $field;
                }, $config['fields']);
            }
        }

        return array(
            'file' => 'views/templates/front/'.basename($file->getPath()).'/'.$file->getBasename(),
            'name' =>  isset($config['name']) ? $config['name'] : $file->getBasename('.tpl'),
            'basename' => $basename,
            'config' => $config,
                // 'formdata' => Tools::file_exists_no_cache(_PS_MODULE_DIR_.'anthemeblocks/formdata/'.$file->getBasename('.tpl').'.json') ? Tools::jsonDecode(Tools::file_get_contents(_PS_MODULE_DIR_.'anthemeblocks/formdata/'.$file->getBasename('.tpl').'.json')) : array(),
            'preview' => Tools::file_exists_no_cache($file->getPath().'/preview.png') ? true : false
        );
    }

    public static function getDefaultConfig()
    {
        return array(
            'enabled_text' => true,
            'enabled_link' => true,
            'enabled_image' => true,
            'required_text' => false,
            // 'name' => '',
            'description' => '',
            'homeproducts' => false,
            'js' => array(),
            'css' => array()
        );
    }

    public static function getTemplatesLow($child)
    {
        $finder = new Finder(new GlobIterator($child === false ? self::getViewsDir().'/*/*.tpl' : self::getViewsDir().'/'.basename($child, '.tpl').'/*.tpl', FilesystemIterator::CURRENT_AS_FILEINFO|FilesystemIterator::SKIP_DOTS));
        return $finder->setChild($child);
    }

    public function loadFormdata($id_lang = null)
    {
        if ($this->id > 0) {
            $collection = new Collection('AnThemeBlockData', $id_lang);
            $this->formdata = $collection->where('id_anthemeblock', '=', $this->id)->getFirst();
        }

        return $this;
    }

    public function export()
    {
        $formdata = !($this->formdata instanceof AnThemeBlockData) ? false : $this->formdata->export();

        if (is_array($formdata)) {
            $basename = basename($this->template, '.tpl');
            $prefix = 'additional_field_'.$basename;
            
            if (isset($formdata[$prefix.'_type']) && in_array($formdata[$prefix.'_type'], array('category', 'ids'))) {
                $formdata[$prefix.'_type'] = 'new';
                $formdata[$prefix.'_value'] = '';
            }
        }

        return array(
            'id_anthemeblock' => $this->id_anthemeblock,
            'block_identifier' => $this->block_identifier,
            'id_parent' => $this->id_parent,
            'status' => $this->status,
            'position' => $this->position,
            'date_add' => $this->date_add,
            'date_upd' => $this->date_upd,
            'hook_ids' => $this->hook_ids,
            'template' => $this->template,
            'img' => $this->img,

            // Lang fields
            'title' => is_array($this->title) ? current($this->title) : '',
            'content' => is_array($this->content) ? current($this->content) : '',
            'image' => is_array($this->image) ? current($this->image) : '',
            'link' => is_array($this->link) ? current($this->link) : '',
            'formdata' => $formdata
        );
    }

    public function import(array $data)
    {
        $this->id_anthemeblock = isset($data['id_anthemeblock']) ? $data['id_anthemeblock'] : $this->id_anthemeblock;
        $this->block_identifier = isset($data['block_identifier']) ? $data['block_identifier'] : $this->block_identifier;
        $this->id_parent = isset($data['id_parent']) ? $data['id_parent'] : $this->id_parent;
        $this->status = isset($data['status']) ? $data['status'] : $this->status;
        $this->position = isset($data['position']) ? $data['position'] : $this->position;
        $this->date_add = isset($data['date_add']) ? $data['date_add'] : $this->date_add;
        $this->date_upd = isset($data['date_upd']) ? $data['date_upd'] : $this->date_upd;
        $this->hook_ids = isset($data['hook_ids']) ? $data['hook_ids'] : $this->hook_ids;
        $this->template = isset($data['template']) ? $data['template'] : $this->template;
        $this->img = isset($data['img']) ? $data['img'] : $this->img;
        
        $languages = array_flip(Language::getLanguages(1, 0, 1));

        if (isset($data['title']) && is_string($data['title'])) {
            $this->title = array_map(function () use ($data) {
                return $data['title'];
            }, $languages);
        }
        
        if (isset($data['content']) && is_string($data['content'])) {
            $this->content = array_map(function () use ($data) {
                return $data['content'];
            }, $languages);
        }
        
        if (isset($data['image']) && is_string($data['image'])) {
            $this->image = array_map(function () use ($data) {
                return $data['image'];
            }, $languages);
        }

        if (isset($data['link']) && is_string($data['link'])) {
            $this->link = array_map(function () use ($data) {
                return $data['link'];
            }, $languages);
        }

        if (isset($data['formdata']) && $data['formdata']) {
            $formdata = new AnThemeBlockData();
            $this->formdata = $formdata->import($data['formdata']);
        }

        return $this;
    }

    public function setPosition($position)
    {
        $this->position = (int)$position;
        return $this;
    }

    public function getConfigJS()
    {
        return isset($this->prepareConfig()->config['js']) ? $this->config['js'] : array();
    }

    public function getConfigCSS()
    {
        return isset($this->prepareConfig()->config['css']) ? $this->config['css'] : array();
    }

    public function getConfig()
    {
        return $this->prepareConfig()->config;
    }

    protected function prepareConfig()
    {
        if ($this->config === null && isset($this->template)) {
            $_part = explode('/', $this->template);
            $config_file = _PS_MODULE_DIR_.'anthemeblocks/views/templates/front/'.basename($_part[count($_part)-1], '.tpl').'/config.yml';
            $this->config = Tools::file_exists_no_cache($config_file) ? (array)Spyc::YAMLLoad(Tools::file_get_contents($config_file)) : array();
        }

        return $this;
    }

    public function hydrate(array $data, $id_lang = null)
    {
        parent::hydrate($data, $id_lang);
        return $this->loadFormdata($id_lang);
    }

    public function generateIdentifier()
    {
        if (!$this->block_identifier) {
            $title = $this->title;
            if (is_array($title)) {
                $title = current($title);
            }
            $title = preg_replace("/[^a-zA-Z0-9]+/", "_", $title);
            $this->block_identifier = (int)$this->id_parent . '_' . $title . '_' . time();
        }
    }

    public function useDataAsArray($field, array $data = array())
    {
        if (empty($data)) {
            return explode(',', $this->$field);
        }

        $this->$field = implode(',', $data);
    }

    public static function getBlockByIdentifier($block_identifier)
    {
        $sql = '
        SELECT `id_anthemeblocks`
        FROM `' . _DB_PREFIX_ . 'anthemeblocks`
        WHERE `block_identifier` = "' . pSQL($block_identifier) . '";';

        $block_id = (int)Db::getInstance()->getValue($sql);
        $_block = new self((int)$block_id);

        if ($_block->id) {
            return $_block;
        }
        
        return false;
    }
 
    public static function getEnabledBlockByIdentifier($block_identifier)
    {
        $sql = '
        SELECT `id_anthemeblocks`
        FROM `' . _DB_PREFIX_ . 'anthemeblocks`
        WHERE `status`=1 AND `block_identifier` = "' . pSQL($block_identifier) . '";';

        $block_id = (int)Db::getInstance()->getValue($sql);
        $_block = new self((int)$block_id);
        
        if ($_block->id) {
            return $_block;
        } else {
            return false;
        }
    }

    public static function getActive()
    {
        $hooks = new Collection(__CLASS__, Context::getContext()->language->id);
        $hooks->where('status', '=', 1);
        $hooks->where('id_parent', '=', 0);

        $hooks->orderBy('position');

        return $hooks;
    }

    public static function getBlocksByHookName($hookName)
    {
        $hooks = array();
        if ($hookName) {
            $hooks = new Collection(__CLASS__, Context::getContext()->language->id);
            $hooks = iterator_to_array($hooks->where('status', '=', 1)
                ->where('id_parent', '=', 0)
                ->where('hook_ids', 'like', '%' . pSQL($hookName) . '')
                ->orderBy('position'));
        }
/* 
        foreach ($hooks as &$h) {
            $collection = new Collection('AnThemeBlockData');
            $h->formdata = $collection->where('id_anthemeblock', '=', $h->id)->getFirst();
        }
 */
        return $hooks;
    }

    public static function getBlockObject($block_identifier)
    {
        if (Module::isEnabled('anthemeblocks')) {
            $sql = '
            SELECT `id_anthemeblocks`
            FROM `' . _DB_PREFIX_ . 'anthemeblocks`
            WHERE `block_identifier` = "' . pSQL($block_identifier) . '" AND `status` = "1"';
    
            if (Shop::isFeatureActive()) {
                $sql .= ' AND `id_anthemeblocks` IN (
                    SELECT sa.`id_anthemeblocks`
                    FROM `' . _DB_PREFIX_ . 'anthemeblocks_shop` sa
                    WHERE sa.id_shop IN (' . implode(', ', Shop::getContextListShopID()) . ')
                )';
            }
    
            $block_id = (int)Db::getInstance()->getValue($sql);
    
            if ($block_id) {
                $block = new self($block_id, Context::getContext()->cookie->id_lang);
                return $block;
            }
        }

        return new self;
    }

    public static function getImagesPath()
    {
        return _PS_MODULE_DIR_ . 'anthemeblocks/images/';
    }

    public function getImage()
    {
        return self::getImagesPath().$this->img.'.jpg';
    }

    public function getImageLink()
    {
        if (file_exists($this->getImage())) {
            return __PS_BASE_URI__.'modules/anthemeblocks/images/'.$this->img.'.jpg';
        }

        return false;
    }

    public function delete()
    {
        $block_identifier = $this->block_identifier;
        
        if (parent::delete() !== false) {
            if (Tools::file_exists_no_cache(_PS_MODULE_DIR_.'anthemeblocks/blocks/'.$block_identifier.'.json')) {
                @unlink(_PS_MODULE_DIR_.'anthemeblocks/blocks/'.$block_identifier.'.json');
            }

            return !count(array_filter(array_map(function ($block) {
                return !$block->delete();
            }, iterator_to_array($this->getChildrenBlocks()))))
            && $this->deleteImage();
        }

        return false;
    }

    public function deleteImage($force_delete = false)
    {
        $this->image_dir = AnThemeBlock::getImagesPath();
        $this->image_format = 'jpg';

        if (!isset($this->img)) {
            return false;
        }

        if (file_exists($this->image_dir.$this->img.'.'.$this->image_format)
            && !unlink($this->image_dir.$this->img.'.'.$this->image_format)) {
            return false;
        }
    
        if (file_exists(_PS_TMP_IMG_DIR_.$this->def['table'].'_'.$this->img.'.'.$this->image_format)
            && !unlink(_PS_TMP_IMG_DIR_.$this->def['table'].'_'.$this->img.'.'.$this->image_format)) {
            return false;
        }
        
        if (file_exists(_PS_TMP_IMG_DIR_.$this->def['table'].'_mini_'.$this->img.'.'.$this->image_format)
            && !unlink(_PS_TMP_IMG_DIR_.$this->def['table'].'_mini_'.$this->img.'.'.$this->image_format)) {
            return false;
        }

        $types = ImageType::getImagesTypes();
        
        foreach ($types as $image_type) {
            if (file_exists($this->image_dir.$this->img.'-'.Tools::stripslashes($image_type['name']).'.'.$this->image_format)
            && !unlink($this->image_dir.$this->img.'-'.Tools::stripslashes($image_type['name']).'.'.$this->image_format)) {
                return false;
            }
        }

        $this->img = '';

        return $this->save();
    }

    public function getChildrenBlocks()
    {
        if (!$this->id) {
            return array();
        }

        $childrenBlocks = new Collection(__CLASS__, Context::getContext()->language->id);
        return $childrenBlocks->where('id_parent', '=', $this->id)->orderBy('position')->where('status', '=', 1);
    }

    public function getContent($param = array())
    {
        if (!$this->template) {
            return $this->content;
        }

        if (Validate::isLoadedObject($this->formdata)) {
            $config = self::getTemplateInfo(new SplFileInfo($this->template), (bool)(int)$this->id_parent, $this, false);

            if (isset($config['config']['homeproducts'])) {
                $this->products = $this->getProducts();
            }
        }

        $this->param = $param;

        $imgplaceholder = '';
        if (isset($config['config']['placeholder']) || !empty($config['config']['placeholder'])) {
            $imgplaceholder = __PS_BASE_URI__ . 'modules/anthemeblocks/' . $config['config']['placeholder'];
        }

        Context::getContext()->smarty->assign(array(
            'an_staticblock'=> $this,
            'an_placeholder' => $imgplaceholder
        ));
        return Module::getInstanceByName('anthemeblocks')->display('anthemeblocks', $this->template);
    }

    public function getPrefix()
    {
        return 'additional_field_'.basename($this->template, '.tpl').'_';
    }

    //TODO: refactor all calls
    public function getAdditionalData($key)
    {
        return $this->formdata->__get($this->getPrefix().$key);
    }

    public function getProducts()
    {
        $context = Context::getContext();
        $prefix = $this->getPrefix();
        $page_number = (int) $this->page_number;
        $nb_products = (int) $this->nb_products;
        $products_count = (int) $this->formdata->__get($prefix.'products_count');
        $factor = $page_number * $nb_products;

        if ($nb_products + $factor > $products_count) {
            $this->limit = $products_count - $factor;
        }

        $values = explode(',', $this->formdata->__get($prefix.'value'));
        $values = array_map('trim', $values);
        $values = array_map('intval', $values);

        $method = 'getBy' . $this->formdata->__get($prefix.'type');

        if (method_exists($this, $method)) {
            $products = $this->$method($values);

            if (is_array($products)) {
                if (version_compare(_PS_VERSION_, '1.7.0.0', '<')) {
                    return $products;
                } else {
                    include_once _PS_MODULE_DIR_ . 'anthemeblocks/classes/AnThemeBlocksListing.php';
                    $listing = new AnThemeBlocksListing();
                    return $listing->prepare($products);
                }
            }
        }

        return array();
    }

    public function getByFeatured($categoryIds)
    {
        $categoryId = array_shift($categoryIds);
        $productsCount = (int)$this->getAdditionalData('products_count');
        $currentLanguageId = (int)Context::getContext()->language->id;
        $category = new Category($categoryId, $currentLanguageId);
//        $featuredRandomly = $this->getAdditionalData('featured_randomly');

        if (Validate::isLoadedObject($category)) {
//            if ($featuredRandomly) {
//                return $category->getProducts($currentLanguageId, 1, $productsCount, null, null, false, true, true);
//            }

            return $category->getProducts($currentLanguageId, 1, $productsCount, 'position');
        }
    }

    public function getByCategory(array $category_id)
    {
        if (!count($category_id)) {
            return array();
        }

        $page_number = $this->page_number;
        $limit = $this->limit;

        $context = Context::getContext();
        $products = array();

        foreach ($category_id as $id_category) {
            $category = new Category((int) $id_category);
            $_products = $category->getProducts($context->language->id, $page_number, $limit);
            
            if ($_products) {
                $products = array_merge($products, $_products);
            }
        }

        return $products;
    }

    protected function getByIds($ids)
    {
        if (!count($ids)) {
            return array();
        }

        $context = Context::getContext();
        $id_lang = $context->language->id;
        $nb_days_new_product = Configuration::get('PS_NB_DAYS_NEW_PRODUCT');
        if (!Validate::isUnsignedInt($nb_days_new_product)) {
            $nb_days_new_product = 20;
        }

        $sql = 'SELECT DISTINCT p.*, product_shop.*, stock.out_of_stock, IFnull(stock.quantity, 0) AS quantity' . (Combination::isFeatureActive() ? ', IFnull(product_attribute_shop.id_product_attribute, 0) AS id_product_attribute,
                    product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity' : '') . ', pl.`description`, pl.`description_short`, pl.`available_now`,
                    pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, image_shop.`id_image` id_image,
                    il.`legend` as legend, m.`name` AS manufacturer_name, cl.`name` AS category_default,
            DATEDIFF(product_shop.`date_add`, DATE_SUB("' . date('Y-m-d') . ' 00:00:00",
            INTERVAL ' . (int) $nb_days_new_product . ' DAY)) > 0 AS new, product_shop.price AS orderprice
        FROM `' . _DB_PREFIX_ . 'category_product` cp
        LEFT JOIN `' . _DB_PREFIX_ . 'product` p
            ON p.`id_product` = cp.`id_product`
        ' . Shop::addSqlAssociation('product', 'p') .
        (Combination::isFeatureActive() ? ' LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_shop` product_attribute_shop
        ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop=' . (int) $context->shop->id . ')' : '') . '
        ' . Product::sqlStock('p', 0) . '
        LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl
            ON (product_shop.`id_category_default` = cl.`id_category`
            AND cl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('cl') . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl
            ON (p.`id_product` = pl.`id_product`
            AND pl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('pl') . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop
            ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int) $context->shop->id . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il
            ON (image_shop.`id_image` = il.`id_image`
            AND il.`id_lang` = ' . (int) $id_lang . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m
            ON m.`id_manufacturer` = p.`id_manufacturer`
        WHERE product_shop.`id_shop` = ' . (int) $context->shop->id . '
            AND p.`id_product` IN (' . implode(', ', $ids) . ')'
            . ' AND product_shop.`active` = 1';

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql, true, false);

        return Product::getProductsProperties($id_lang, $result);
    }

    public function getByNew()
    {
        $page_number = $this->page_number;
        $nb_products = $this->nb_products;
        $count = false;
        $order_by = null;
        $order_way = null;

        $context = Context::getContext();
        $id_lang = $context->language->id;

        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
            $front = false;
        }

        if ($page_number < 0) {
            $page_number = $this->page_number;
        }
        if ($nb_products < 1) {
            $nb_products = 10;
        }
        if (empty($order_by) || $order_by == 'position') {
            $order_by = 'date_add';
        }
        if (empty($order_way)) {
            $order_way = 'DESC';
        }
        if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add' || $order_by == 'date_upd') {
            $order_by_prefix = 'product_shop';
        } elseif ($order_by == 'name') {
            $order_by_prefix = 'pl';
        }
        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
            die(Tools::displayError());
        }

        $sql_groups = '';
        if (Group::isFeatureActive()) {
            $groups = FrontController::getCurrentCustomerGroups();
            $sql_groups = ' AND EXISTS(SELECT 1 FROM `' . _DB_PREFIX_ . 'category_product` cp
                JOIN `' . _DB_PREFIX_ . 'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_group` ' . (count($groups) ? 'IN (' . implode(',', $groups) . ')' : '= 1') . ')
                WHERE cp.`id_product` = p.`id_product`)';
        }

        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by_prefix = $order_by[0];
            $order_by = $order_by[1];
        }

        if ($count) {
            $sql = 'SELECT COUNT(p.`id_product`) AS nb
                    FROM `' . _DB_PREFIX_ . 'product` p
                    ' . Shop::addSqlAssociation('product', 'p') . '
                    WHERE product_shop.`active` = 1
                    AND product_shop.`date_add` > "' . date('Y-m-d', strtotime('-' . (Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int) Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . ' DAY')) . '"
                    ' . ($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '') . '
                    ' . $sql_groups;
            return (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
        }

        $sql = new DbQuery();
        $sql->select(
            'p.*, product_shop.*, stock.out_of_stock, IFnull(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`, pl.`link_rewrite`, pl.`meta_description`,
            pl.`meta_keywords`, pl.`meta_title`, pl.`name`, pl.`available_now`, pl.`available_later`, image_shop.`id_image` id_image, il.`legend`, m.`name` AS manufacturer_name,
            product_shop.`date_add` > "' . date('Y-m-d', strtotime('-' . (Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int) Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . ' DAY')) . '" as new'
        );

        $sql->from('product', 'p');
        $sql->join(Shop::addSqlAssociation('product', 'p'));
        $sql->leftJoin('product_lang', 'pl', 'p.`id_product` = pl.`id_product` AND pl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('pl'));
        $sql->leftJoin('image_shop', 'image_shop', 'image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int) $context->shop->id);
        $sql->leftJoin('image_lang', 'il', 'image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) $id_lang);
        $sql->leftJoin('manufacturer', 'm', 'm.`id_manufacturer` = p.`id_manufacturer`');

        $sql->where('product_shop.`active` = 1');
        if ($front) {
            $sql->where('product_shop.`visibility` IN ("both", "catalog")');
        }
        $sql->where('product_shop.`date_add` > "' . date('Y-m-d', strtotime('-' . (Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int) Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . ' DAY')) . '"');

        //$sql->where('EXISTS(SELECT 1 FROM `'._DB_PREFIX_.'category_product` cp
        //    JOIN `'._DB_PREFIX_.'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_category` = ' . (int)$id_category . ')
        //    WHERE cp.`id_product` = p.`id_product`)');

        $sql->orderBy((isset($order_by_prefix) ? pSQL($order_by_prefix) . '.' : '') . '`' . pSQL($order_by) . '` ' . pSQL($order_way));
        $sql->limit((int)$this->getAdditionalData('products_count'), $page_number * $nb_products);

        if (Combination::isFeatureActive()) {
            $sql->select('product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, IFnull(product_attribute_shop.id_product_attribute,0) id_product_attribute');
            $sql->leftJoin('product_attribute_shop', 'product_attribute_shop', 'p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop=' . (int) $context->shop->id);
        }
        $sql->join(Product::sqlStock('p', 0));

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if (!$result) {
            return false;
        }

        if ($order_by == 'price') {
            Tools::orderbyPrice($result, $order_way);
        }

        $products_ids = array();
        foreach ($result as $row) {
            $products_ids[] = $row['id_product'];
        }
        // Thus you can avoid one query per product, because there will be only one query for all the products of the cart
        Product::cacheFrontFeatures($products_ids, $id_lang);
        return Product::getProductsProperties((int) $id_lang, $result);
    }

    public function getByBestsellers()
    {
        $page_number = $this->page_number;
        $nb_products = $this->nb_products;
        $order_by = null;
        $order_way = null;
		
		$productsCount = (int)$this->getAdditionalData('products_count');

        $context = Context::getContext();
        $id_lang = $context->language->id;

        if ($page_number < 0) {
            $page_number = $this->page_number;
        }
        if ($nb_products < 1) {
            $nb_products = 10;
        }
        $final_order_by = $order_by;
        $order_table = '';

        if (is_null($order_by)) {
            $order_by = 'quantity';
            $order_table = 'ps';
        }

        if ($order_by == 'date_add' || $order_by == 'date_upd') {
            $order_table = 'product_shop';
        }

        if (is_null($order_way) || $order_by == 'sales') {
            $order_way = 'DESC';
        }

        $interval = Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20;

        // no group by needed : there's only one attribute with default_on=1 for a given id_product + shop
        // same for image with cover=1
        $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFnull(stock.quantity, 0) as quantity,
                    ' . (Combination::isFeatureActive() ? 'product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity,IFnull(product_attribute_shop.id_product_attribute,0) id_product_attribute,' : '') . '
                    pl.`description`, pl.`description_short`, pl.`link_rewrite`, pl.`meta_description`,
                    pl.`meta_keywords`, pl.`meta_title`, pl.`name`, pl.`available_now`, pl.`available_later`,
                    m.`name` AS manufacturer_name, p.`id_manufacturer` as id_manufacturer,
                    image_shop.`id_image` id_image, il.`legend`,
                    ps.`quantity` AS sales, t.`rate`, pl.`meta_keywords`, pl.`meta_title`, pl.`meta_description`,
                    DATEDIFF(p.`date_add`, DATE_SUB("' . date('Y-m-d') . ' 00:00:00",
                    INTERVAL ' . (int) $interval . ' DAY)) > 0 AS new'
        . ' FROM `' . _DB_PREFIX_ . 'product_sale` ps
                LEFT JOIN `' . _DB_PREFIX_ . 'product` p ON ps.`id_product` = p.`id_product`
                ' . Shop::addSqlAssociation('product', 'p', false);
        if (Combination::isFeatureActive()) {
            $sql .= ' LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_shop` product_attribute_shop
                            ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop=' . (int) $context->shop->id . ')';
        }

        $sql .= ' LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl
                    ON p.`id_product` = pl.`id_product`
                    AND pl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('pl') . '
                LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop
                    ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int) $context->shop->id . ')
                LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) $id_lang . ')
                LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
                LEFT JOIN `' . _DB_PREFIX_ . 'tax_rule` tr ON (product_shop.`id_tax_rules_group` = tr.`id_tax_rules_group`)
                    AND tr.`id_country` = ' . (int) $context->country->id . '
                    AND tr.`id_state` = 0
                LEFT JOIN `' . _DB_PREFIX_ . 'tax` t ON (t.`id_tax` = tr.`id_tax`)
                ' . Product::sqlStock('p', 0);

        $sql .= '
                WHERE product_shop.`active` = 1
                    AND p.`visibility` != \'none\'';

        //$sql .= ' AND EXISTS(SELECT 1 FROM `'._DB_PREFIX_.'category_product` cp
        //        JOIN `'._DB_PREFIX_.'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_category` = ' . (int)$id_category . ')
        //        WHERE cp.`id_product` = p.`id_product`)';

        if ($final_order_by != 'price') {
            $sql .= '
                    ORDER BY ' . (!empty($order_table) ? '`' . pSQL($order_table) . '`.' : '') . '`' . pSQL($order_by) . '` ' . pSQL($order_way) . '
                    LIMIT ' . (int) ($page_number * $nb_products) . ', ' . (int) $productsCount;
        }

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if ($final_order_by == 'price') {
            Tools::orderbyPrice($result, $order_way);
        }
        if (!$result) {
            return false;
        }
        return Product::getProductsProperties($id_lang, $result);
    }

    public function getBySale()
    {
        $page_number = $this->page_number;
        $nb_products = $this->nb_products;
        $count = false;
        $order_by = null;
        $order_way = null;
        $beginning = false;
        $ending = false;

        if (!Validate::isBool($count)) {
            die(Tools::displayError());
        }

        $context = Context::getContext();
        $id_lang = $context->language->id;

        if ($page_number < 0) {
            $page_number = $this->page_number;
        }
        if ($nb_products < 1) {
            $nb_products = 10;
        }
        if (empty($order_by) || $order_by == 'position') {
            $order_by = 'price';
        }
        if (empty($order_way)) {
            $order_way = 'DESC';
        }
        if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add' || $order_by == 'date_upd') {
            $order_by_prefix = 'product_shop';
        } elseif ($order_by == 'name') {
            $order_by_prefix = 'pl';
        }
        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
            die(Tools::displayError());
        }
        $current_date = date('Y-m-d H:i:00');
        $ids_product = $this->_getProductIdByDate((!$beginning ? $current_date : $beginning), (!$ending ? $current_date : $ending), $context);

        $tab_id_product = array();
        foreach ($ids_product as $product) {
            if (is_array($product)) {
                $tab_id_product[] = (int) $product['id_product'];
            } else {
                $tab_id_product[] = (int) $product;
            }
        }

        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
            $front = false;
        }

        $sql_groups = '';
        //$groups = FrontController::getCurrentCustomerGroups();
        //$sql_groups = ' AND EXISTS(SELECT 1 FROM `'._DB_PREFIX_.'category_product` cp
        //    JOIN `'._DB_PREFIX_.'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_category` = ' . (int)$id_category . ')
        //    WHERE cp.`id_product` = p.`id_product`)';

        if ($count) {
            return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
            SELECT COUNT(DISTINCT p.`id_product`)
            FROM `' . _DB_PREFIX_ . 'product` p
            ' . Shop::addSqlAssociation('product', 'p') . '
            WHERE product_shop.`active` = 1
            AND product_shop.`show_price` = 1
            ' . ($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '') . '
            ' . ((!$beginning && !$ending) ? 'AND p.`id_product` IN(' . ((is_array($tab_id_product) && count($tab_id_product)) ? implode(', ', $tab_id_product) : 0) . ')' : '') . '
            ' . $sql_groups);
        }

        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by = pSQL($order_by[0]) . '.`' . pSQL($order_by[1]) . '`';
        }

        $sql = '
        SELECT
            p.*, product_shop.*, stock.out_of_stock, IFnull(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`, pl.`available_now`, pl.`available_later`,
            IFnull(product_attribute_shop.id_product_attribute, 0) id_product_attribute,
            pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`,
            pl.`name`, image_shop.`id_image` id_image, il.`legend`, m.`name` AS manufacturer_name,
            DATEDIFF(
                p.`date_add`,
                DATE_SUB(
                    "' . date('Y-m-d') . ' 00:00:00",
                    INTERVAL ' . (Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . ' DAY
                )
            ) > 0 AS new
        FROM `' . _DB_PREFIX_ . 'product` p
        ' . Shop::addSqlAssociation('product', 'p') . '
        LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_shop` product_attribute_shop
            ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop=' . (int) $context->shop->id . ')
        ' . Product::sqlStock('p', 0, false, $context->shop) . '
        LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (
            p.`id_product` = pl.`id_product`
            AND pl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('pl') . '
        )
        LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop
            ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int) $context->shop->id . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) $id_lang . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
        WHERE product_shop.`active` = 1
        AND product_shop.`show_price` = 1
        ' . ($front ? ' AND p.`visibility` IN ("both", "catalog")' : '') . '
        ' . ((!$beginning && !$ending) ? ' AND p.`id_product` IN (' . ((is_array($tab_id_product) && count($tab_id_product)) ? implode(', ', $tab_id_product) : 0) . ')' : '') . '
        ' . $sql_groups . '
        ORDER BY ' . (isset($order_by_prefix) ? pSQL($order_by_prefix) . '.' : '') . pSQL($order_by) . ' ' . pSQL($order_way) . '
        LIMIT ' . (int) ($page_number * $nb_products) . ', ' . (int)$this->getAdditionalData('products_count');

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if (!$result) {
            return false;
        }

        if ($order_by == 'price') {
            Tools::orderbyPrice($result, $order_way);
        }

        return Product::getProductsProperties($id_lang, $result);
    }

    protected function _getProductIdByDate($beginning, $ending, Context $context = null, $with_combination = false)
    {
        if (!$context) {
            $context = Context::getContext();
        }

        $id_address = $context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
        $ids = Address::getCountryAndState($id_address);
        $id_country = $ids['id_country'] ? (int) $ids['id_country'] : (int) Configuration::get('PS_COUNTRY_DEFAULT');

        return SpecificPrice::getProductIdByDate(
            $context->shop->id,
            $context->currency->id,
            $id_country,
            $context->customer->id_default_group,
            $beginning,
            $ending,
            0,
            $with_combination
        );
    }
}
