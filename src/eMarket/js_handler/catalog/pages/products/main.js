/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global bootstrap, Ajax */

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
            Ajax.postData(window.location.href, {
                add_to_cart: id,
                add_quantity: pcs
            }, true, null, AjaxSuccess).then((data) => {
            });
            function AjaxSuccess(data) {
                document.querySelector('#product_quantity').innerHTML = pcs;
                var ajax_data = document.createElement('div');
                ajax_data.innerHTML = data;
                document.querySelector('#cart_bar').replaceWith(ajax_data.querySelector('#cart_bar'));
                document.querySelector('#products').replaceWith(ajax_data.querySelector('#products'));
                new bootstrap.Modal(document.querySelector('#cart_message')).show();
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
        var a = document.querySelector('#number_' + id).value;

        document.querySelector('body').addEventListener('click', (e) => {
            if (e.target.closest('.button-plus') !== null) {
                return;
            }
            document.querySelectorAll('.popover').forEach(e => bootstrap.Popover.getInstance(e).hide());
        });

        if (val === 'minus' && a > 1) {
            document.querySelector('#number_' + id).value = +a - 1;
        }
        if (val === 'plus' && Number(a) < Number(max_quantity)) {
            document.querySelector('#number_' + id).value = +a + 1;
        }
        if (Number(a) === Number(max_quantity)) {
            new bootstrap.Popover(document.querySelector('#number_' + id)).show();
    }
    }

}