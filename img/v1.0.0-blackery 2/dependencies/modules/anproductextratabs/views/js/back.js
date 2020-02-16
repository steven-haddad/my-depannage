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

jQuery(document).ready(function () {
    $(document.getElementsByName('submit_tabs')).click(function (e) {
        e.preventDefault();
        id = this.id;
        if (id!=1) {
            id = id.split('_')[0];
        }
        var mce = {};
        var title = {};
        var emptytitle = true;
        languageids.forEach(function (item) {
            if (typeof tinyMCE !== 'undefined' && jQuery('#content_content_'+id+'_'+item).length) {
                mce[item] = tinyMCE.get('content_content_'+id+'_'+item).getContent();
            }
            title[item] =  $('#content_title_'+id+'_'+item).val();
            if (title[item]!='') {
                emptytitle = false;
            }
        });
        if (emptytitle) {
            showErrorMessage(anpt_messages.fill_title.error);
            return false;
        }
        var cathegories = [];
        document.getElementsByName('categoryBox[]').forEach(function (item) {
            if (item.checked) {
                cathegories.push(item.value);
            }
        });

        if (cathegories.length<1) {
            showErrorMessage(anpt_messages.choose_cathegory.error);
            return false;
        }

        jQuery.post(anpt_controller_url, {
            action: 'updateCategories',
            cathegories: cathegories,
            id_anproducttabs: id,
            type: jQuery('input[name="type_' + id + '"]').val(),
            title: title,
            content: mce,
            active: $('#content_active_'+id+'_on')[0].checked
        }).then(function (response) {
            if (response.success == true) {
                showSuccessMessage(anpt_messages.update.success);
            } else {
                showErrorMessage(anpt_messages.update.error);
            }
        });
    });

    jQuery('form.anproductextratabs').on('submit', function (event) {
        var name_input = jQuery(this).find('input[name="name"]');
        
        if (name_input.val() == "") {
            event.preventDefault();
            showErrorMessage(name_input.parents('.form-group').find('.label-tooltip').attr('data-original-title'));
            //alert(name_input.parents('.form-group').find('.label-tooltip').attr('data-original-title'));
            return false;
        }

        return true;
    });
    if (languages.length>1){
        $('.tab_type').parents('.form-group').hide();
        $('.tab_' + jQuery('.select_tab').val()).parents('.lang-' + id_language).parents('.form-group').show();
        $('.tab_' + jQuery('.select_tab').val()).parents('.lang-' + id_language).show();
        jQuery('.select_tab').change(function () {
            switch ($(this).val()) {
                case 'content':
                    $('.tab_type').parents('.form-group').hide();
                    $('.tab_content').parents('.lang-' + id_language).parents('.form-group').show();
                    $('.tab_content').parents('.lang-' + id_language).show();
                    break;
                case 'contact':
                    $('.tab_type').parents('.form-group').hide();
                    $('.tab_contact').parents('.lang-' + id_language).parents('.form-group').show();
                    $('.tab_contact').parents('.lang-' + id_language).show();
                    break;
                case 'products':
                    $('.tab_type').parents('.form-group').hide();
                    $('.tab_products').parents('.lang-' + id_language).parents('.form-group').show();
                    $('.tab_products').parents('.lang-' + id_language).show();
                    break;
            }
        });
    } else {
        $('.tab_type').parents('.form-group').hide();
        $('.tab_' + jQuery('.select_tab').val()).parents('.form-group').show();
        jQuery('.select_tab').change(function () {
            switch ($(this).val()) {
                case 'content':
                    $('.tab_type').parents('.form-group').hide();
                    $('.tab_content').parents('.form-group').show();
                    break;
                case 'contact':
                    $('.tab_type').parents('.form-group').hide();
                    $('.tab_contact').parents('.form-group').show();
                    break;
                case 'products':
                    $('.tab_type').parents('.form-group').hide();
                    $('.tab_products').parents('.form-group').show();
                    break;
            }
        });
    }


});

