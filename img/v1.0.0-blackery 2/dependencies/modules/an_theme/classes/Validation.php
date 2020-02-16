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

class AnThemeValidation
{
    const ERROR_EMPTY_VALUE = 0;
    const ERROR_INVALID_NUMBER = 1;
    const ERROR_INVALID_COLOR = 2;
	const ERROR_INVALID_FLOAT = 3;

    //refactoring: unexpected behavior with $value reference
    static public function validateEmptyValue(&$value, $input)
    {
        $result = false;

        if (is_scalar($value)) {
            $result = !empty($value);
        } else if (is_array($value)) {
            $result = self::validateEmptyValueLang($value);
        }

        if ($result === false) {
            $errorMessage = Module::getInstanceByName('an_theme')->getValidationErrorByCode(self::ERROR_EMPTY_VALUE);
            return sprintf($errorMessage, $input['title']);
        }

        return $result;
    }

    static protected function validateEmptyValueLang(&$value)
    {
        $result = false;
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        if ($default_lang && isset($value[$default_lang])) {
              $result = true;
            $default_value = $value[$default_lang];
            // unset($value[$default_lang]);

            if (empty($default_value)) {
                $result = false;
            } else {
                foreach ($value as &$_value) {
                    if (is_scalar($_value) && empty($_value)) {
                        $_value = $default_value;
                    }
                }
            }
        }

        return $result;
    }

    static public function validateTypeNumber($value, $input)
    {
        $_value = (int)$value;
		$min = 0;
		$max = PHP_INT_MAX;

		if (isset($input['min'])) {
			$min = (int)$input['min'];
		}

		if (isset($input['max'])) {
			$max = (int)$input['max'];
		}

		if ($_value < $min || $_value > $max) {
            $errorMessage = Module::getInstanceByName('an_theme')->getValidationErrorByCode(self::ERROR_INVALID_NUMBER);
            return sprintf($errorMessage, $input['title']);
        }

        return true;
    }
	
    static public function validateTypeFloat($value, $input)
    {
        $_value = (float)$value;
		$min = -INF;
		$max = INF;

		if (is_numeric($input['min'])) {
			$min = (float)$input['min'];
		}

		if (is_numeric($input['max'])) {
			$max = (float)$input['max'];
		}

        if ($_value <= $min || $_value >= $max) {
            $errorMessage = Module::getInstanceByName('an_theme')->getValidationErrorByCode(self::ERROR_INVALID_FLOAT);
            return sprintf($errorMessage, $input['title']);
        }

        return true;
    }

    static public function validateTypePicker($value, $input)
    {
        $matched = preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $value);

        if (!$matched) {
            $errorMessage = Module::getInstanceByName('an_theme')->getValidationErrorByCode(self::ERROR_INVALID_COLOR);
            return sprintf($errorMessage, $input['title']);
        }

        return true;
    }
}