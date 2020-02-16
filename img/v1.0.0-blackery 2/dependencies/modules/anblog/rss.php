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

require dirname(__FILE__).'/../../config/config.inc.php';
require_once dirname(__FILE__).'/../../init.php';
require_once dirname(__FILE__).'/anblog.php';
$anblog = new anblog();
if (file_exists(_PS_MODULE_DIR_.'anblog/classes/config.php')) {
    $anblog->isInstalled = true;
    include_once _PS_MODULE_DIR_.'anblog/loader.php';
    if (!Module::getInstanceByName('anblog')->active) {
        exit;
    }

    // Get data
    $authors = array();
    $config = AnblogConfig::getInstance();
    $enbrss = (int)$config->get('indexation', 0);
    if ($enbrss != 1) {
        exit;
    }
    $config->setVar('blockanblogs_height', Configuration::get('BANBLOGS_HEIGHT'));
    $config->setVar('blockanblogs_width', Configuration::get('BANBLOGS_WIDTH'));
    $config->setVar('blockanblogs_limit', Configuration::get('BANBLOGS_NBR'));
    $limit = (int)$config->get('rss_limit_item', 4);
    $helper = AnblogHelper::getInstance();
    $image_w = (int)$config->get('blockanblogs_width', 690);
    $image_h = (int)$config->get('blockanblogs_height', 300);
    $blogs = AnblogBlog::getListBlogs(
        null,
        Context::getContext()->language->id,
        0,
        $limit,
        'id_anblog_blog',
        'DESC',
        array(),
        true
    );
    foreach ($blogs as $key => $blog) {
        $blog = AnblogHelper::buildBlog($helper, $blog, $image_w, $image_h, $config, true);
        if ($blog['id_employee']) {
            if (!isset($authors[$blog['id_employee']])) {
                // validate module
                $authors[$blog['id_employee']] = new Employee($blog['id_employee']);
            }

            $blog['author'] = $authors[$blog['id_employee']]->firstname.' '.$authors[$blog['id_employee']]->lastname;
            $blog['author_link'] = $helper->getBlogAuthorLink($authors[$blog['id_employee']]->id);
        } else {
            $blog['author'] = '';
            $blog['author_link'] = '';
        }

        $blogs[$key] = $blog;
    }
    // Send feed
    header('Content-Type:text/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
    ?>
    <rss version="2.0">
        <channel>
            <title><![CDATA[<?php echo Configuration::get('PS_SHOP_NAME') ?>]]></title>
            <link><?php echo _PS_BASE_URL_.__PS_BASE_URI__; ?></link>
            <webMaster><?php echo Configuration::get('PS_SHOP_EMAIL') ?></webMaster>
            <generator>PrestaShop</generator>
            <language><?php echo Context::getContext()->language->iso_code; ?></language>
            <image>
            <title><![CDATA[<?php echo Configuration::get('PS_SHOP_NAME') ?>]]></title>
            <url><?php echo _PS_BASE_URL_.__PS_BASE_URI__.'img/logo.jpg'; ?></url>
            <link><?php echo _PS_BASE_URL_.__PS_BASE_URI__; ?></link>
            </image>
            <?php
            foreach ($blogs as $blog) {
                echo "\t\t<item>\n";
                echo "\t\t\t<title><![CDATA[".$blog['title']."]]></title>\n";
                echo "\t\t\t<description>";
                $cdata = true;
                if (!empty($blog['image'])) {
                    echo "<![CDATA[<img src='".$blog['preview_url']."' title='".
                        str_replace(
                            '&',
                            '',
                            $blog['title']
                        )
                        ."' alt='thumb' class='img-fluid'/>";
                    $cdata = false;
                }
                if ($cdata) {
                    echo '<![CDATA[';
                }
                echo $blog['description']."]]></description>\n";

                echo "\t\t\t<link><![CDATA[".$blog['link']."]]></link>\n";
                echo "\t\t</item>\n";
            }
            ?>
        </channel>
    </rss>
    <?php
}
