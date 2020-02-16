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

var Tab = function (id, id_shop, name, position) {
    var self = this;

    this.id = id;
    this.id_shop = id_shop;
    this.name = name;
    this.position = position;
    this.default_content = null;
    this.content = null;

    this.prev = null;
    this.next = null;

    this.clone = function () {
        return new Tab(self.id, self.id_shop, self.name, self.position);
    }

    this.update = function (callback) {
        jQuery.post(anproductvideos_controller_url, {
            action:         'update',
            id:             self.id,
            id_shop:        self.id_shop,
            name:           self.name,
            position:       self.position,
            default_content:self.default_content,
            content:        self.content,
        }).then(callback);

        return self;
    };

    this.delete = function (callback) {
        jQuery.post(anproductvideos_controller_url, {
            action:     'delete',
            id:         self.id
        }).then(callback);

        return self;
    };
}
