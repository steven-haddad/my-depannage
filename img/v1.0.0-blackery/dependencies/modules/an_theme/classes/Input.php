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

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once _PS_MODULE_DIR_.'an_theme/classes/Validation.php';

class AnThemeInput implements ArrayAccess
{
    protected $key = '';
    protected $data = array();
    protected $fields = array();
    protected $dataLoaded = false;
    public $errors = array();

    public function __construct($key, $fields)
    {
        $this->key = $key;
        $this->fields = $fields;
    }

    public function getData($key, $default = null)
    {
        $this->setupInputData();
        $entities = explode('/', $key);
        $data = $this->data;

        while ($entity = array_shift($entities)) {
            if (!is_array($data) || !array_key_exists($entity, $data)) {
                return $default;
            }

            $data = $data[$entity];
        }

        return $data;
    }

    public function __get($key)
    {
        $this->getData($key);
    }

    public function offsetExists($offset)
    {
        $this->setupInputData();
        $entities = explode('/', $offset);
        $data = $this->data;

        while ($entity = array_shift($entities)) {
            if (!array_key_exists($entity, $data)) {
                return false;
            }

            $data = $data[$entity];
        }
    }

    public function offsetGet($offset)
    {
        return $this->getData($offset);
    }
    
    public function offsetSet($offset, $value)
    {
        return false;
    }

    public function offsetUnset($offset)
    {
        return false;
    }

    protected function setupInputData()
    {
        if (!$this->dataLoaded) {
            $explodedKey = explode('_', $this->key);
            $keyFirstEntity = array_shift($explodedKey);
            $keyLastEntity = implode('_', $explodedKey);
			if (isset($this->fields[$keyFirstEntity]['options'][$keyLastEntity])){
                $input = $this->fields[$keyFirstEntity]['options'][$keyLastEntity];
			}

            if (isset($input) && is_array($input)) {
                $this->data = $input;
            }

            $this->dataLoaded = true;
        }

        return $this;
    }

    public function validateValue(&$value)
    {
        $result = true;
        $allowEmpty = $this->mayBeEmpty();
        $this->data['allow_empty'] = $allowEmpty;

        if (!$allowEmpty) {
            $response = AnThemeValidation::validateEmptyValue($value, $this);

            if ($response !== true) {
                $this->errors[] = $response;
                $result = false;
            }
        }

        $method = $this->getValidationMethodName();

        if ($value != '' && method_exists('AnThemeValidation', $method)) {
            $response = call_user_func_array('AnThemeValidation::'.$method, array($value, $this));

            if ($response !== true) {
                $this->errors[] = $response;
                $result = false;
            }
        }

        return $result;
    }

    protected function getValidationMethodName()
    {
        $source = trim($this->getData('source'));
        return 'validateType'.Tools::ucfirst($source);
    }

    protected function mayBeEmpty()
    {
        $source = $this->getData('source');
        $unallowed = array('switch', 'image');

        if (!in_array($source, $unallowed)) {
            return (bool)$this->getData('allow_empty', false);
        }

        return true;
    }
}