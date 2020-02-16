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

class ANPTTabContentCollection extends PrestaShopCollection
{
    public function __construct($id_lang = null)
    {
        return parent::__construct('ANPTTabContent', $id_lang);
    }

    public function update()
    {
        ANPTTransaction::start();

        for ($this->rewind(); $this->valid(); $this->next()) {
            if ($this->current()->update() === false) {
                return ANPTTransaction::rollback();
            }
        }

        return ANPTTransaction::commit();
    }

    public function delete()
    {
        for ($this->rewind(); $this->valid(); $this->next()) {
            $this->current()->delete();
        }
    }

    public function byTab($id)
    {
        if (is_array($id)) {
            return $this->where(ANPTTab::$definition['primary'], 'in', array_filter($id, function ($_id) {
                return is_integer($_id) && $_id > 0;
            }));
        } elseif (is_integer($id) && $id > 0) {
            return $this->where(ANPTTab::$definition['primary'], '=', $id);
        }
    }

    public function onlyActive()
    {
        return $this->where('active', '=', '1');
    }

    public function byProduct($id)
    {
        if (is_array($id)) {
            return $this->where('id_product', 'in', array_filter($id, function ($_id) {
                return is_integer($_id) && $_id > 0;
            }));
        } elseif (is_integer($id) && $id > 0) {
            return $this->where('id_product', '=', $id);
        }
    }

    public function orderByPosition()
    {
        return $this->join('ANPTTab')->orderBy('ANPTTab.position', 'ASC');//->orderBy('position');
    }

    public function attach(ANPTTabContent $tab)
    {
        $this->results[] = $tab;

        return $this->hydrationHack();
    }

    public function clear()
    {
        $this->results = array();
        return $this;
    }

    public function hydrationHack()
    {
        $this->is_hydrated = true;
        return $this;
    }
}
