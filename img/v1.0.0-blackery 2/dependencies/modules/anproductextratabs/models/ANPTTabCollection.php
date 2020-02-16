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

class ANPTTabCollection extends PrestaShopCollection
{
    public function __construct($id_lang = null)
    {
        parent::__construct('ANPTTab', $id_lang);
        $this->orderBy('position', 'ASC');
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

    public function loadContent($id_product = null, $do_load_default_content = false)
    {
        for ($this->rewind(); $this->valid(); $this->next()) {
            $content = new ANPTTabContentCollection();

            if ($content->byTab($this->current()->id)->byProduct($id_product)->count() == 0) {
                if ($do_load_default_content) {
                    $this->loadDefaultContentCurrent();
                }
            } else {
                $this->current()->content = $content;
            }
        }

        return $this;
    }

    public function loadDefaultContent()
    {
        for ($this->rewind(); $this->valid(); $this->next()) {
            $this->loadDefaultContentCurrent();
        }

        return $this;
    }

    protected function loadDefaultContentCurrent()
    {
        $content = new ANPTTabDefaultContentCollection();

        if ($content->byTab($this->current()->id)->count() != 0) {
            $this->current()->default_content = $content;
        }

        return $this;
    }

    public function byId($id)
    {
        if (is_array($id)) {
            $this->where(ANPTTab::$definition['primary'], 'in', array_filter($id, function ($_id) {
                return is_integer($_id) && $_id > 0;
            }));
        } elseif (is_integer($id) && $id > 0) {
            $this->where(ANPTTab::$definition['primary'], '=', $id);
        }

        return $this;
    }

    public function toJSON()
    {
        return Tools::jsonEncode($this->toArray());
    }

    public function toArray()
    {
        $arr = array();

        for ($this->rewind(); $this->valid(); $this->next()) {
            $arr[] = $this->current()->toArray();
        }

        return $arr;
    }

    public function attach(ANPTTab $tab)
    {
        $this->results[] = $tab;
        return $this;
    }

    public function rewind()
    {
        parent::rewind();
        return $this;
    }
}
