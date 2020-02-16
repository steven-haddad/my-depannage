var mypresta_productListCart = {
    add: function(_0x4bd3x2) {
        _0x4bd3x2['find']('i')['html']('autorenew')['addClass']('atc_spinner');
        idCombination = _0x4bd3x2['parent']()['parent']()['parent']()['parent']()['parent']()['attr']('data-id-product-attribute');
        quantity = _0x4bd3x2['parent']()['find']('.atc_qty')['val']();
        idProduct = _0x4bd3x2['parent']()['parent']()['parent']()['parent']()['parent']()['attr']('data-id-product');
        $['ajax']({
            type: 'POST',
            headers: {
                "\x63\x61\x63\x68\x65\x2D\x63\x6F\x6E\x74\x72\x6F\x6C": 'no-cache'
            },
            url: prestashop['urls']['pages']['cart'] + '?rand=' + new Date()['getTime'](),
            async: true,
            cache: false,
            dataType: 'json',
            data: 'action=update&add=1&ajax=true&qty=' + ((quantity && quantity != null) ? quantity : '1') + '&id_product=' + idProduct + '&token=' + prestashop['static_token'] + ((parseInt(idCombination) && idCombination != null) ? '&ipa=' + parseInt(idCombination) : '' + '&id_customization=' + ((typeof customizationId !== 'undefined') ? customizationId : 0)),
            success: function(_0x4bd3x3, _0x4bd3x4, _0x4bd3x5) {
                _0x4bd3x2['find']('i')['html']('add_shopping_cart')['removeClass']('atc_spinner');
                prestashop['emit']('updateCart', {
                    reason: {
                        idProduct: idProduct,
                        idProductAttribute: idCombination,
                        linkAction: 'add-to-cart'
                    }
                })
            }
        })
    }
}