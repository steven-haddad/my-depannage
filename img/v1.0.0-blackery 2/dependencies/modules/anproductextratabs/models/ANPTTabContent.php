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

class ANPTTabContent extends ObjectModel
{
    protected $id_anproducttabs = 0;
    protected $id_product = 0;
    protected $title = '';
    protected $content = '';
    protected $active = 0;

    public static $definition = array(
        'table' => 'anproducttabs_content',
        'primary' => 'id_anproducttabs_content',
        'multilang' => true,
        'fields' => array(
            'id_anproducttabs' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'required' => true, 'validate' => 'isGenericName', 'size' => 255),
            'content' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString', 'size' => 65535),
            'active' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt')
        ),
        'associations' => array(
            'ANPTTab' => array('object' => 'ANPTTab', 'field' => 'id_anproducttabs', 'foreign_field' => 'id_anproducttabs')
        )
    );

    public function setId($id)
    {
        $this->id = (int)$id;

        return $this;
    }

    public function setIdAnproducttabs($id)
    {
        $this->id_anproducttabs = (int)$id;

        return $this;
    }

    public function setIdProduct($id)
    {
        $this->id_product = (int)$id;

        return $this;
    }

    public function setIdLang($id)
    {
        $this->id_lang = (int)$id;

        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function setActive($status)
    {
        $this->active = (int)$status;

        return $this;
    }
    
    public function __get($field)
    {
        return property_exists($this, $field) ? $this->{$field} : null;
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
    
    public function hydrate(array $data, $id_lang = null)
    {
        $data['id'] = $data[$this->def['primary']];

        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
    }
}
