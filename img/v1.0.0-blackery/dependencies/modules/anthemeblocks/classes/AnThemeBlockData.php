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

class AnThemeBlockData extends ObjectModel
{
    public $id;
    public $id_anthemeblock_data;
    public $id_anthemeblock;

    public $data;

    protected $_data = array();

    public static $definition = array(
        'table' => 'anthemeblock_data',
        'primary' => 'id_anthemeblock_data',
        'multilang' => true,
        'fields' => array(
            'id_anthemeblock' => array('type' => self::TYPE_INT),
            'data' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isString', 'size' => 65535),
        ),
    );

    public function setIdBlock($id)
    {
        $this->id_anthemeblock = (int)$id;
        return $this;
    }

    public function setData($data)
    {
        $this->data = array_map(function ($_d) use ($data) {
            return Tools::jsonEncode((array)$data);
        }, array_flip(Language::getLanguages(0, 0, 1)));

        return $this;
    }

    public function export()
    {
        $data = $this->getData();
        
        return array(
            'id_anthemeblock' => $this->id_anthemeblock,
            'id_anthemeblock_data' => $this->id_anthemeblock_data,
            'data' => $data[Context::getContext()->language->id]
        );
    }

    public function import(array $data)
    {
        $this->id_anthemeblock = isset($data['id_anthemeblock']) ? $data['id_anthemeblock'] : $this->id_anthemeblock;
        $this->id_anthemeblock_data = isset($data['id_anthemeblock_data']) ? $data['id_anthemeblock_data'] : $this->id_anthemeblock_data;
        $this->data = isset($data['data']) ? $data['data'] : $this->data;

        return $this;
    }

    public function __set($field, $value)
    {
        $this->_data[$field] = $value;
        return $this;
    }

    public function __get($field)
    {
        if(isset($this->_data)){
            return array_key_exists($field, $this->_data) ? $this->_data[$field] : null;
        }else{
            return null;
        }
    }

    public function hydrate(array $data, $id_lang = null)
    {
        parent::hydrate($data, $id_lang);
        return $this->prepare();
    }

    public function prepare()
    {
        if ($this->data !== null) {
            $data = $this->data;
			if (is_array($data)) {
				$data = $data[Context::getContext()->language->id];
			}
			$data = (array)$data;
            $this->_data = Tools::jsonDecode(array_shift($data), true);
        }
        return $this;
    }

    public function getData()
    {
        return array_map(function ($data) {
            return Tools::jsonDecode($data, true);
        }, (array)$this->data);
    }
}
