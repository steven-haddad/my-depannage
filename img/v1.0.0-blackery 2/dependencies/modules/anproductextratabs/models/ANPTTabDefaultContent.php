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

class ANPTTabDefaultContent extends ObjectModel
{
    protected $id_anproducttabs = 0;
    protected $title = '';
    protected $content = '';

    public static $definition = array(
        'table' => 'anproducttabs_default_content',
        'primary' => 'id_anproducttabs_default_content',
        'multilang' => true,
        'fields' => array(
            'id_anproducttabs' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
            'content' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString', 'size' => 65535),
        ),
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

    public function setIdLang($id)
    {
        $this->id_lang = (int)$id;

        return $this;
    }

    public function setTitle($title, $id_lang = 0)
    {
        if ($id_lang) {
            $this->title[$id_lang] = $title;
        } else {
            $this->title = $title;
        }

        return $this;
    }

    public function setContent($content, $id_lang = 0)
    {
        if ($id_lang) {
            $this->content[$id_lang] = $content;
        } else {
            $this->content = $content;
        }

        return $this;
    }

    public function __get($field)
    {
        return property_exists($this, $field) ? $this->{$field} : null;
    }

    public function __set($field, $value)
    {
        $method = $this->getSetter($field);

        if (is_callable(array($this, $method))) {
            $this->{$method}($value);
        }
    }

    public function getSetter($field)
    {
        return 'set'.implode('', array_map(function ($entity) {
            return Tools::ucfirst($entity);
        }, explode("_", $field)));
    }
    
    public function hydrate(array $data, $id_lang = null)
    {
        $data['id'] = $data[$this->def['primary']];

        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
    }
}
