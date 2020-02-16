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

class an_wish extends ObjectModel
{
    /**
     * @var int
     */
    public $id_an_wishlist;
    /**
     * @var int
     */
    public $id;
    /**
     * @var int
     */
    public $id_shop = 1;

    public $id_product;
    public $id_customer;
	
    /** @var string Object creation date */
    public $date_add;

    /**
     * @var array
     */
    public static $definition = array(
        'table' => 'an_wishlist',
        'primary' => 'id_an_wishlist',
        'multilang' => false,
        'multilang_shop' => false,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_product' => array('type' =>self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true ),
            'id_customer' => array('type' =>self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true ),
			'date_add' => array('type' => self::TYPE_DATE),
        ),
    );

    /**
     * Formula constructor.
     *
     * @param null $id
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->id_shop) {
            $this->id_shop = Context::getContext()->shop->id;
        }
    }


	public function removeItem($productId, $id_customer){
		$sql = "DELETE FROM "._DB_PREFIX_."an_wishlist WHERE `id_product` = '".(int)$productId."' AND `id_customer` = '".(int)$id_customer."' AND `id_shop` = '".(int) Context::getContext()->shop->id."' ";
		if (Db::getInstance()->execute($sql)) {
			return true;
		} else {
			return false;
		}
	}

	public function issetItem($productId, $id_customer){
		
        if (!$id_customer) {
            return false;
        }		
		
        return (bool)Db::getInstance()->getValue('
			SELECT COUNT(*)
			FROM `' . _DB_PREFIX_ . 'an_wishlist`
			WHERE `id_customer` = ' . (int)$id_customer . '
			AND `id_product` = ' . (int)$productId . '
			AND `id_shop` = ' . (int) Context::getContext()->shop->id);
	}
	
	
	//	Сколько товаров в вишлисте у пользователя
	public function countProductsCustomer($id_customer){
        if (!$id_customer) {
            return 0;
        }		
		
        return Db::getInstance()->getValue('
			SELECT COUNT(*)
			FROM `' . _DB_PREFIX_ . 'an_wishlist`
			WHERE `id_customer` = ' . (int)$id_customer . '
			AND `id_shop` = ' . (int) Context::getContext()->shop->id);
	}
	
	//	у скольких пользователей товар анходится в вишлисте
	public function countWishlistsProduct($productId){
        if (!$productId) {
            return 0;
        }		
		
        return Db::getInstance()->getValue('
			SELECT COUNT(*)
			FROM `' . _DB_PREFIX_ . 'an_wishlist`
			WHERE `id_product` = ' . (int)$productId . '
			AND `id_shop` = ' . (int) Context::getContext()->shop->id);
	}
	
	
	//	
    public function getProductsWishlist($id_customer)
    {
		
        if (!$id_customer) {
            return array();
        }		       

		$context = Context::getContext();
        $id_lang = $context->language->id;


        $sql = 'SELECT DISTINCT p.*, product_shop.*, stock.out_of_stock, IFnull(stock.quantity, 0) AS quantity' . (Combination::isFeatureActive() ? ', IFnull(product_attribute_shop.id_product_attribute, 0) AS id_product_attribute,
                    product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity' : '') . ', pl.`description`, pl.`description_short`, pl.`available_now`,
                    pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, image_shop.`id_image` id_image,
                    il.`legend` as legend, m.`name` AS manufacturer_name, cl.`name` AS category_default,
            
			product_shop.price AS orderprice
        FROM `' . _DB_PREFIX_ . 'an_wishlist` awl, `' . _DB_PREFIX_ . 'category_product` cp
        LEFT JOIN `' . _DB_PREFIX_ . 'product` p
            ON p.`id_product` = cp.`id_product`
        ' . Shop::addSqlAssociation('product', 'p') .
        (Combination::isFeatureActive() ? ' LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_shop` product_attribute_shop
        ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop=' . (int) $context->shop->id . ')' : '') . '
        ' . Product::sqlStock('p', 0) . '
        LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl
            ON (product_shop.`id_category_default` = cl.`id_category`
            AND cl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('cl') . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl
            ON (p.`id_product` = pl.`id_product`
            AND pl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('pl') . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop
            ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int) $context->shop->id . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il
            ON (image_shop.`id_image` = il.`id_image`
            AND il.`id_lang` = ' . (int) $id_lang . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m
            ON m.`id_manufacturer` = p.`id_manufacturer`
        WHERE product_shop.`id_shop` = ' . (int) $context->shop->id . '
             AND product_shop.`active` = 1
		AND awl.`id_product` = p.`id_product` AND awl.`id_customer` = ' . (int)$id_customer . '
			
			';

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql, true, false);

        return Product::getProductsProperties($id_lang, $result);
    }	


    public function getTopProducts($limit = 10)
    {

        $context = Context::getContext();
        $id_lang = $context->language->id;

        $sql = '
        SELECT
            p.*, product_shop.*, stock.out_of_stock, IFnull(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`, pl.`available_now`, pl.`available_later`,
            IFnull(product_attribute_shop.id_product_attribute, 0) id_product_attribute,
            pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`,
            pl.`name`, image_shop.`id_image` id_image, il.`legend`, m.`name` AS manufacturer_name,
			
			(SELECT COUNT(*) FROM `' . _DB_PREFIX_ . 'an_wishlist` WHERE `' . _DB_PREFIX_ . 'an_wishlist`.`id_product` = p.`id_product`) AS count_wishlist

        FROM `' . _DB_PREFIX_ . 'an_wishlist` awl, `' . _DB_PREFIX_ . 'product` p
        ' . Shop::addSqlAssociation('product', 'p') . '
        LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_shop` product_attribute_shop
            ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop=' . (int) $context->shop->id . ')
        ' . Product::sqlStock('p', 0, false, $context->shop) . '
        LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (
            p.`id_product` = pl.`id_product`
            AND pl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('pl') . '
        )
        LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop
            ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int) $context->shop->id . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) $id_lang . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
        WHERE product_shop.`active` = 1
        AND product_shop.`show_price` = 1
		AND awl.`id_product` = p.`id_product`
		GROUP BY p.`id_product`
        ORDER BY count_wishlist DESC
		
        LIMIT 0, '.(int)$limit.'
		';

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if (!$result) {
            return array();
        }

        return Product::getProductsProperties($id_lang, $result);
    }
}
