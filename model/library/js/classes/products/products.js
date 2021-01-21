/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Product in the catalog
 *
 * @package Products
 * @author eMarket
 * 
 */
class Products {
    /**
     * Add to cart
     * @param id {String} (id)
     * @param pcs {String} (quantity)
     *
     */
    static addToCart(id, pcs) {
        if (pcs > 0) {
            jQuery.ajaxSetup({async: false});
            jQuery.get(window.location.href,
                    {add_to_cart: id,
                        add_quantity: pcs},
                    AjaxSuccess);
            function AjaxSuccess(data) {
                $('#product_quantity').html(pcs);
                $('#cart_bar').replaceWith($(data).find('#cart_bar'));
                $('#products').replaceWith($(data).find('#products'));
                $('#cart_message').modal('show');

                new Products();
            }
        }
    }

    /**
     * Quantity of products in input
     * @param val {String} (label value)
     * @param id {String} (product id)
     * @param max_quantity {String} (Maximum order quantity)
     *
     */
    static pcsProduct(val, id, max_quantity = null) {
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
        if (val === 'plus' && Number(a) < Number(max_quantity)) {
            $('#number_' + id).val(+a + 1);
        }
        if (Number(a) === Number(max_quantity)) {
            $('#number_' + id).popover('show');
    }

    }

}