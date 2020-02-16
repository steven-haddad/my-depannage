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

spl_autoload_register(function ($class) {
    if (Tools::substr($class, 0, 10) !== 'ReCaptcha\\') {
        /* If the class does not lie under the "ReCaptcha" namespace,
         * then we can exit immediately.
         */
        return;
    }

    /* First, check under the current directory. It is important that
     * we look here first, so that we don't waste time searching for
     * test classes in the common case.
     */
    $path = dirname(__FILE__).'/'.$class.'.php';
    if (is_readable($path)) {
        require_once $path;
    }
});
