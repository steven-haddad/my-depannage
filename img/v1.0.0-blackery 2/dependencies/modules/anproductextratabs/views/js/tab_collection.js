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

var TabCollection = function (controller) {
    var self = this;
    this.controller = controller;

    this._head = null;
    this._tail = null;
    this._length = 0;
    this.__iterator = null;

    this.update_order = function (callback) {
        var tab_order = {};
        
        self.each(function (tab) {
            tab_order[self.current().id] = self.current().position;
        });

        jQuery.post(self.controller, {
            action: 'updateOrder',
            order:  tab_order
        }).then(callback);

        return self;
    };

    this.reload = function (callback) {
        jQuery.post(self.controller, {
            action: 'get'
        }).then(function (response) {
            if (response instanceof Array) {
                self.clear();
                for (var i = 0; i < response.length; i++) {
                    self.push(new Tab(response[i][0], response[i][1], response[i][2], response[i][3]));
                }
            }
        });

        return (callback instanceof Function) ? callback() : self;
    };

    this.each = function (callback) {
        if (!(callback instanceof Function)) {
            return false;
        }

        for (self.rewind(); self.valid(); self.next()) {
            callback(self.current());
        }

        return self;
    };

    this.update = function (callback) {
        self.each(function (tab) {
            tab.update(callback);
        })

        return self;
    };

    this.change_sorting = function (old_index, new_index, callback) {
        if (self.to_index(old_index) && self.valid()) {
            self.remove(old_index);
            self.push_to_index(self.current().clone(), new_index - 1);
        }

        return (callback instanceof Function) ? callback() : self;
    };

    this.next = function () {
        if (self.__iterator) {
            self.__iterator = self.__iterator.next;
        }
        return self.__iterator;
    };

    this.prev = function () {
        if (self.__iterator) {
            self.__iterator = self.__iterator.prev;
        }
        return self.__iterator;
    };

    this.rewind = function () {
        self.__iterator = self._head;
        return self.__iterator;
    };

    this.prewind = function () {
        self.__iterator = self._tail;
        return self.__iterator;
    };

    this.valid = function () {
        return self.__iterator !== null && typeof self.__iterator == 'object';
    };

    this.to_index = function (index) {
        index = parseInt(index) || 0;

        if (index <= 0) {
            return self.rewind();
        } else if (index >= (self.count() - 1)) {
            return self.prewind();
        }

        self.rewind();
        var i = 0;
        while (i++ < index && self.next()) {
        }

        return self;
    };

    this.remove = function (index) {
        if (self.to_index(index) && self.valid() || (typeof index == 'undefined' && self.valid())) {
            if (index == 0) {
                self._head = self.current().next;
            }
            if (index == self.count() - 1) {
                self._tail = self.current().prev;
            }

            if (self.current().prev !== null) {
                self.current().prev.next = self.current().next;
            }
            if (self.current().next !== null) {
                self.current().next.prev = self.current().prev;
            }
            self._length--;
        }
        
        return self;
    };

    this.clear = function (callback) {
        while (self.rewind() !== null) {
            self.remove(0);
        }
        return (callback instanceof Function) ? callback() : self;
    };

    this.push = function (tab) {
        if (!(tab instanceof Tab)) {
            return false;
        }

        if (this.count() == 0) {
            this._head = tab;
            this._tail = tab;
        } else {
            this._tail.next = tab;
            tab.prev = this._tail;
            this._tail = tab;
        }

        this._length++;
    };

    this.push_to_index = function (tab, index) {
        if (!(tab instanceof Tab)) {
            return false;
        }
        
        if (index == -1) {
            this._head.prev = tab;
            tab.next = this._head;
            this._head = tab;
        } else if (index == self.count() - 1) {
            this._tail.next = tab;
            tab.prev = this._tail;
            this._tail = tab;
        } else if (self.to_index(index) && self.valid()) {
            tab.prev = self.current();
            tab.next = self.current().next;
            self.current().next.prev = tab;
            self.current().next = tab;
        }

        self._length++;
    };

    this.count = function () {
        return self._length;
    };

    this.current = function () {
        return self.__iterator;
    };
}
