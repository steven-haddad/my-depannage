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

define('_AN_BLOG_PREFIX_', 'ANBLOG_');
require_once _PS_MODULE_DIR_.'anblog/classes/config.php';

$config = AnblogConfig::getInstance();


define('_ANBLOG_BLOG_IMG_DIR_', _PS_MODULE_DIR_.'anblog/views/img/');
define('_ANBLOG_BLOG_IMG_URI_', __PS_BASE_URI__.'modules/anblog/views/img/');


define('_ANBLOG_CATEGORY_IMG_URI_', _PS_MODULE_DIR_.'anblog/views/img/');
define('_ANBLOG_CATEGORY_IMG_DIR_', __PS_BASE_URI__.'modules/anblog/views/img/');

define('_ANBLOG_CACHE_IMG_DIR_', _PS_IMG_DIR_.'anblog/');
define('_ANBLOG_CACHE_IMG_URI_', _PS_IMG_.'anblog/');

$link_rewrite = 'link_rewrite';
define('_AN_BLOG_REWRITE_ROUTE_', $config->get($link_rewrite, 'blog'));

if (!is_dir(_ANBLOG_BLOG_IMG_DIR_.'c')) {
    // validate module
    mkdir(_ANBLOG_BLOG_IMG_DIR_.'c', 0744, true);
}

if (!is_dir(_ANBLOG_BLOG_IMG_DIR_.'b')) {
    // validate module
    mkdir(_ANBLOG_BLOG_IMG_DIR_.'b', 0744, true);
}

if (!is_dir(_ANBLOG_CACHE_IMG_DIR_)) {
    // validate module
    mkdir(_ANBLOG_CACHE_IMG_DIR_, 0744, true);
}
if (!is_dir(_ANBLOG_CACHE_IMG_DIR_.'c')) {
    // validate module
    mkdir(_ANBLOG_CACHE_IMG_DIR_.'c', 0744, true);
}
if (!is_dir(_ANBLOG_CACHE_IMG_DIR_.'b')) {
    // validate module
    mkdir(_ANBLOG_CACHE_IMG_DIR_.'b', 0744, true);
}

require_once _PS_MODULE_DIR_.'anblog/libs/Helper.php';
require_once _PS_MODULE_DIR_.'anblog/classes/anblogcat.php';
require_once _PS_MODULE_DIR_.'anblog/classes/blog.php';
require_once _PS_MODULE_DIR_.'anblog/classes/link.php';
require_once _PS_MODULE_DIR_.'anblog/classes/comment.php';
require_once _PS_MODULE_DIR_.'anblog/classes/AnblogOwlCarousel.php';
