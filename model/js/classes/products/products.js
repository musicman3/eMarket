/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Товар в каталоге
 *
 * @package Products
 * @author eMarket
 * 
 */
class Products {
    /**
     * Добавить товар в корзину
     * @param id {String} (id товара)
     * @param pcs {String} (количество)
     *
     */
    static addToCart(id, pcs) {
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.get(window.location.href,
                {add_to_cart: id,
                    add_quantity: pcs},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            $('#product_quantity').html(pcs);
            $('#cart_bar').replaceWith($(data).find('#cart_bar'));
            $('#cart_message').modal('show');

            new Products();
        }
    }

    /**
     * Количество товара в input
     * @param val {String} (значение метки)
     * @param id {String} (id товара)
     * @param quantity {String} (id общее количество)
     *
     */
    static pcsProduct(val, id, quantity = null) {
        var a = $('#number_' + id).val();

        $(document).click(function (e) {
            if ($(e.target).closest('.button-plus').length) {
                return;
            }
            $('.popover').popover('hide');
        });

        if (val === 'minus' && a > 1) {
            $('#number_' + id).val(+a - 1);
        }
        if (val === 'plus' && Number(a) < Number(quantity)) {
            $('#number_' + id).val(+a + 1);
        }
        if (val === 'plus' && Number(a) === Number(quantity)) {
            $('#number_' + id).popover('show');
    }
    }

}