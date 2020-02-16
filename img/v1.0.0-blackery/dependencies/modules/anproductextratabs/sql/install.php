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

$sql = array(
    'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'anproducttabs` (
        `id_anproducttabs` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `type` varchar(255) NOT NULL,
        `position` mediumint(8) unsigned NOT NULL,
        KEY `active` (`position`) USING BTREE,
        CONSTRAINT `'._DB_PREFIX_.'anproducttabs_pk` PRIMARY KEY (`id_anproducttabs`)
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;',

    'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'anproducttabs_shop` (
        `id_anproducttabs` int(10) unsigned NOT NULL,
        `id_shop` int(11) unsigned NOT NULL,
        CONSTRAINT `'._DB_PREFIX_.'anproducttabs_shop_pk` PRIMARY KEY (`id_anproducttabs`, `id_shop`),
        CONSTRAINT `'._DB_PREFIX_.'anproducttabs_shop_ibfk_1` FOREIGN KEY (`id_anproducttabs`) REFERENCES `'._DB_PREFIX_.'anproducttabs` (`id_anproducttabs`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;',

    'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'anproducttabs_content` (
        `id_anproducttabs_content` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `id_anproducttabs` int(10) unsigned NOT NULL,
        `id_product` int(10) unsigned NOT NULL,
        `active` tinyint(1) NOT NULL,
        KEY `id_product` (`id_product`),
        KEY `id_anproducttabs_content` (`id_anproducttabs_content`),
        KEY `id_anproducttabs` (`id_anproducttabs`),
        KEY `active` (`active`),
        CONSTRAINT `'._DB_PREFIX_.'anproducttabs_content_pk` PRIMARY KEY (`id_anproducttabs_content`),
        CONSTRAINT `'._DB_PREFIX_.'anproducttabs_content_uq` UNIQUE (`id_product`, `id_anproducttabs`),
        CONSTRAINT `'._DB_PREFIX_.'anproducttabs_content_ibfk_1` FOREIGN KEY (`id_anproducttabs`) REFERENCES `'._DB_PREFIX_.'anproducttabs` (`id_anproducttabs`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;',

    'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'anproducttabs_content_lang` (
        `id_anproducttabs_content` int(10) unsigned NOT NULL,
        `id_lang` int(10) unsigned NOT NULL,
        `title` varchar(255) NOT NULL,
        `content` text NOT NULL,
        CONSTRAINT `'._DB_PREFIX_.'anproducttabs_content_lang_pk` PRIMARY KEY (`id_anproducttabs_content`,`id_lang`),
        CONSTRAINT `'._DB_PREFIX_.'anproducttabs_content_lang_ibfk_1` FOREIGN KEY (`id_anproducttabs_content`) REFERENCES `'._DB_PREFIX_.'anproducttabs_content` (`id_anproducttabs_content`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;',

    'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'anproducttabs_default_content` (
        `id_anproducttabs_default_content` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `id_anproducttabs` int(10) unsigned NOT NULL,
        KEY `id_anproducttabs` (`id_anproducttabs`),
        CONSTRAINT `'._DB_PREFIX_.'anproducttabs_default_content_pk` PRIMARY KEY (`id_anproducttabs_default_content`),
        CONSTRAINT `'._DB_PREFIX_.'anproducttabs_default_content_ibfk` FOREIGN KEY (`id_anproducttabs`) REFERENCES `'._DB_PREFIX_.'anproducttabs` (`id_anproducttabs`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;',

    'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'anproducttabs_default_content_lang` (
        `id_anproducttabs_default_content` int(10) unsigned NOT NULL,
        `id_lang` int(10) unsigned NOT NULL,
        `title` varchar(255) NOT NULL,
        `content` text NOT NULL,
        CONSTRAINT `'._DB_PREFIX_.'anproducttabs_default_content_lang_pk` PRIMARY KEY (`id_anproducttabs_default_content`, `id_lang`),
        CONSTRAINT `'._DB_PREFIX_.'anproducttabs_default_content_lang_ibfk_1` FOREIGN KEY (`id_anproducttabs_default_content`) REFERENCES `'._DB_PREFIX_.'anproducttabs_default_content` (`id_anproducttabs_default_content`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;'
);

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
