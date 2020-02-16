/* global $ */
$(document).ready(function () {
    var $searchWidget = $('#search_widget');
    var $searchBox    = $searchWidget.find('input[type=text]');
    var searchURL     = $searchWidget.attr('data-search-controller-url');

    $.widget('prestashop.psBlockSearchAutocomplete', $.ui.autocomplete, {
        
        _renderItem: function (ul, product) {
            return $("<li>")
                .append($("<a>")
                    .append($("<img src="+product.cover.bySize.search_default.url+">").addClass("product-image"))
                    .append($("<div class='product-desc'>")
                        .append($("<span>").html(product.category_name).addClass("category"))
                        .append($("<span>").html(product.name).addClass("product"))
                        .append($("<div class='prices-block'>")
                            .append($("<span>").html(product.price).addClass("product-price"))
                            .append($("<span>").html(product.regular_price).addClass("regular-price"))
                        )
                    )
                ).appendTo(ul)
            ;
        }
    });
    jQuery.ui.autocomplete.prototype._resizeMenu = function () {
        var ul = this.menu.element;
        ul.outerWidth(this.element.outerWidth());
    }
    $searchBox.psBlockSearchAutocomplete({
        source: function (query, response) {
            $.post(searchURL, {
                s: query.term,
                resultsPerPage: 10
            }, null, 'json')
            .then(function (resp) {
                response(resp.products);
            })
            .fail(response);
        },
        select: function (event, ui) {
            var url = ui.item.url;
            window.location.href = url;
        },
        open: function (event, ui) {
            $('.ui-autocomplete').wrapInner('<div class="container">');
            if ($('.ui-autocomplete.ui-widget-content').height() + $('.ui-autocomplete.ui-widget-content').offset().top > $(window).height()) {
                $('.ui-autocomplete').addClass('search-done');
                
            } else {
                $('.ui-autocomplete').remove('search-done');
            }
           
            if ($('.header-top').hasClass('fixed-menu')) {
                let bottomOffset = ($('.ui-autocomplete').offset().top + $(window).height() - $('#search_widget').height());
                $('.ui-autocomplete').css('bottom', bottomOffset + 'px');
                console.log(bottomOffset, $('.ui-autocomplete').offset().top);
                $('.ui-autocomplete').css('height', bottomOffset - $('.ui-autocomplete').offset().top  + 'px');
                $('.ui-autocomplete').addClass('fixed-search');
            }
        },
    });
});
