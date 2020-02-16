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

class ANPTTab extends ObjectModel
{

    public static $values = array(
        'content' => 'Content',
        'contact' => 'Contact form',
        'products' => 'Products combinations'
    );

    protected $name = '';
    protected $type = '';
    protected $position = 0;

    protected $default_content = null;
    protected $content = null;

    public static $definition = array(
        'table' => 'anproducttabs',
        'primary' => 'id_anproducttabs',
        'multishop' => true,
        'fields' => array(
            'name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 255, 'required' => true),
            'type' => array('type' => self::TYPE_STRING, 'required' => true),
            'position' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt')
        ),
    );

    protected $webserviceParameters = array(
        'associations' => array(
            'default_content' => array('type' => self::HAS_MANY, 'object' => 'ANPTTabDefaultContent', 'field' => 'id_anproducttabs', 'foreign_field' => 'id_anproducttabs'),
            'content' => array('type' => self::HAS_MANY, 'object' => 'ANPTTabContent', 'field' => 'id_anproducttabs', 'foreign_field' => 'id_anproducttabs')
        ),
    );

    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        $default_content_collection = new ANPTTabDefaultContentCollection();
        $content_collection = new ANPTTabContentCollection();
        foreach (Language::getLanguages(1, 0, 1) as $id_lang) {
            $default_content_collection->attach(new ANPTTabDefaultContent());
        }

        $this->setDefaultContent($default_content_collection)
            ->setContent($content_collection->hydrationHack());

        Shop::addTableAssociation(self::$definition['table'], array('type' => 'shop'));
        return parent::__construct($id, $id_lang, $id_shop);
    }

    public function setId($id)
    {
        $this->id = (int)$id;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function setPosition($order)
    {
        $this->position = (int)$order;
        return $this;
    }

    public function setDefaultContent(ANPTTabDefaultContentCollection $default_content)
    {
        $this->default_content = $default_content;
        return $this;
    }

    public function setContent(ANPTTabContentCollection $content)
    {
        $this->content = $content;
        return $this;
    }

    public static function getTypeFull($slug)
    {
        return self::$values[$slug];
    }

    public function save($null_values = false, $auto_date = true)
    {
        return ANPTTransaction::start() && parent::save($null_values, $auto_date) && $this->saveAssociatedDefaultContent() && $this->saveAssociatedContent() && ANPTTransaction::commit();
    }

    public function delete()
    {
        $content = new ANPTTabContentCollection();
        $content->byTab($this->id)->delete();

        $_content = new ANPTTabDefaultContentCollection();
        $_content->byTab($this->id)->delete();

        return parent::delete();
    }

    public function add($auto_date = true, $null_values = false)
    {
        $position = Db::getInstance()->ExecuteS('SELECT max(position)+1 as sort FROM `'._DB_PREFIX_.self::$definition['table'].'`');
        $this->setPosition(is_array($position) && isset($position[0]) && isset($position[0]['sort']) ? (int)$position[0]['sort'] : 0);

        return parent::add();
    }

    public static function getById($id)
    {
        $tab = new ANPTTab($id);
        $values = Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.self::$definition['table'].'` WHERE `' . self::$definition['primary'] .  '` = '.(int)$id);
        $tab->type = $values['type'];
        return $tab;
    }

    protected function saveAssociatedDefaultContent()
    {
        $id_content = null;

        foreach ($this->default_content as $_content) {
            if ($id_content !== null && $_content->id <= 0) {
                $_content->setId($id_content);
            }

            if ($_content->setIdAnproducttabs($this->id)->save() === false) {
                return ANPTTransaction::rollback();
            }

            $id_content = $_content->id;
        }

        return true;
    }

    protected function saveAssociatedContent()
    {
        foreach ($this->content as $_content) {
            if ($_content->setIdAnproducttabs($this->id)->save() === false) {
                return ANPTTransaction::rollback();
            }
        }

        return true;
    }

    public function __set($field, $value)
    {
        $method = 'set'.implode('', array_map(function ($entity) {
            return Tools::ucfirst($entity);
        }, explode("_", $field)));

        if (is_callable(array($this, $method))) {
            $this->{$method}($value);
        }
    }

    public function __get($field)
    {
        return property_exists($this, $field) ? $this->{$field} : null;
    }

    public function toArray()
    {
        $fields = array();
        
        foreach (array_merge(array('id' => null, 'id_shop' => null), self::$definition['fields']) as $field => $data) {
            if (!empty($this->{$field})) {
                $fields[] = $this->{$field};
            }
        }

        return $fields;
    }

    public function hydrate(array $data, $id_lang = null)
    {
        $data['id'] = $data[$this->def['primary']];

        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
    }
}
