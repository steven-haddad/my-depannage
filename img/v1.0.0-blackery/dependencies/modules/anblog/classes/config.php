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

class AnblogConfig
{
    public $params;
    public $cat_image_dir = '';
    /**
     * @var int id_lang current language in for, while
     */
    public $cur_id_lang = '';
    /**
     * @var int id_lang current language in for, while
     */
    public $cur_prefix_rewrite = '';
    const CACHE_HOOK_ID = 'anblogHooks';

    public static function getInstance()
    {
        static $instance;
        if (!$instance) {
            // validate module
            $instance = new AnblogConfig();
        }
        return $instance;
    }

    public function __construct()
    {
        $data = self::getConfigValue('cfg_global');

        if ($data && $tmp = unserialize($data)) {
            // validate module
            $this->params = $tmp;
        }
    }

    public function mergeParams($params)
    {
        // validate module
        unset($params);
    }

    public function setVar($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function get($name, $value = '')
    {
        if (isset($this->params[$name])) {
            // validate module
            return $this->params[$name];
        }
        return $value;
    }

    public static function getConfigName($name)
    {
        return Tools::strtoupper(_AN_BLOG_PREFIX_.$name);
    }

    public static function updateConfigValue($name, $value = '')
    {
        Configuration::updateValue(self::getConfigName($name), $value, true);
    }

    public static function getConfigValue($name)
    {
        return Configuration::get(self::getConfigName($name));
    }

    public static function getHooksValue($id_shop = null)
    {
        $cache_id = self::CACHE_HOOK_ID . '_' . $id_shop;
        if (!Cache::isStored($cache_id)) {
            Cache::store(
                $cache_id,
                serialize(
                    DB::getInstance(_PS_USE_SQL_SLAVE_)->
                        executeS(
                            'SELECT * FROM '._DB_PREFIX_.'anblog_hooks 
                                  LEFT JOIN '._DB_PREFIX_.'hook on 
                                  '._DB_PREFIX_.'anblog_hooks.id_hook = '._DB_PREFIX_.'hook.id_hook '
                                  .($id_shop ? 'WHERE `id_shop` = '.$id_shop : ''). ';'
                        )
                )
            );
        }
        return unserialize(Cache::retrieve($cache_id));
    }

    public static function updateHooksValues($hooksArray, $id_shop)
    {
        $sql = 'INSERT INTO '._DB_PREFIX_.'anblog_hooks (`id`, `id_hook`, `status`, `post_count`, `id_shop`)  VALUES ';
        $i = 0;
        foreach ($hooksArray as $key => $hook) {
            $postCount = $hook["postCount"] ? $hook["postCount"] : 3;
            $sql .=  ' ( CONCAT(
                            (SELECT  `id_hook` FROM `'._DB_PREFIX_.'hook` WHERE `name` = "'.$key.'" ),
                            "-'.$id_shop.'"
                         ) ,
                        (SELECT  `id_hook` FROM `'._DB_PREFIX_.'hook` WHERE `name` = "'.$key.'" ), 
                         '.$hook["status"].', 
                         '.$postCount.', 
                         '.$id_shop.')';
            if ($i != sizeof($hooksArray) - 1) {
                $sql .= ',';
            }
            $i++;
        }
        $sql .= ' ON DUPLICATE KEY UPDATE `status`= VALUES(status), `post_count`= VALUES(post_count);';
        Cache::clean(self::CACHE_HOOK_ID);
        return DB::getInstance(_PS_USE_SQL_SLAVE_)->execute($sql);
    }
}
