/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global bootstrap, Ajax */

/**
 * Cart
 *
 * @package Cart
 * @author eMarket
 * 
 */
class Cart {
    /**
     * Constructor
     * 
     */
    constructor() {
        var lang = JSON.parse(sessionStorage.getItem('lang'));
        Cart.init(lang);
        Cart.shippingData(lang);
    }

    /**
     * Init
     * 
     *@param lang {Array} (lang)
     */
    static init(lang) {
        document.querySelector('#address').addEventListener('change', (e) => {
            Cart.shippingData(lang);
        });

        document.querySelector('#shipping_method').addEventListener('change', (e) => {
            Cart.paymentData(lang);
        });
    }

    /**
     * Ajax Success
     *
     *@param data {Object} (ajax data)
     */
    static AjaxSuccess(data) {
        setTimeout(function () {
            var ajax_data = document.createElement('div');
            ajax_data.innerHTML = data;
            document.querySelector('#cart_bar').replaceWith(ajax_data.querySelector('#cart_bar'));
            document.querySelector('#cart').replaceWith(ajax_data.querySelector('#cart'));
            document.querySelector('#index').replaceWith(ajax_data.querySelector('#index'));
            new Cart();
        }, 100);
    }

    /**
     * Quantity
     * @param val {String} (value)
     * @param id {String} (product id)
     * @param max_quantity {String} (max quantity)
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

    /**
     * Quantity update
     *
     *@param id {String} (product id)
     *@param pcs {Int} (quantity)
     */
    static quantityProduct(id, pcs) {
        Ajax.postData(window.location.href, {
            quantity_product_id: id,
            pcs_product: pcs
        }, true, null, Cart.AjaxSuccess).then((data) => {
        });
    }

    /**
     * Delete
     *
     *@param id {String} (product id)
     */
    static deleteProduct(id) {
        Ajax.postData(window.location.href, {
            delete_product: id
        }, true, null, Cart.AjaxSuccess).then((data) => {
        });
    }

    /**
     * Changing class of buttons
     *
     */
    static buttonClass() {
        if (document.querySelector('#address_class').className !== 'form-control is-valid' && document.querySelector('#shipping_method').className !== 'form-control is-valid' && document.querySelector('#payment_method').className !== 'form-control is-valid') {
            document.querySelector('#complete').classList.remove('btn-primary');
            document.querySelector('#complete').classList.add('btn-danger');
            document.querySelector('#complete').setAttribute('disabled', 'disabled');
        } else {
            document.querySelector("#complete").removeAttribute('disabled');
            document.querySelector('#complete').classList.remove('btn-danger');
            document.querySelector('#complete').classList.add('btn-primary');
        }
    }

    /**
     * Data for payment modules
     *
     *@param lang {Array} (lang)
     */
    static paymentData(lang) {
        Ajax.postData(window.location.href, {
            payment_shipping_json: document.querySelector('#shipping_method').value
        }, true, null, AjaxSuccess).then((data) => {
        });
        function AjaxSuccess(data) {
            var payment_method = JSON.parse(data);
            document.querySelector('#payment_method').innerHTML = '';

            if (document.querySelector('#shipping_method').className !== 'form-control is-valid' || payment_method.length < 1) {
                document.querySelector('#payment_method').insertAdjacentHTML('beforeend', '<option value="no">' + lang['cart_payment_is_not_available'] + '</option>');
                document.querySelector('#payment_method').classList.remove('is-valid');
                document.querySelector('#payment_method').classList.add('is-invalid');
            } else {
                for (var payment_val of payment_method) {
                    document.querySelector('#payment_method').insertAdjacentHTML('beforeend', '<option value="' + payment_val.chanel_module_name + '">' + payment_val.chanel_name + '</option>');
                    document.querySelector('#payment_method').classList.remove('is-invalid');
                    document.querySelector('#payment_method').classList.add('is-valid');
                    document.querySelector('#callback_url').value = payment_val.chanel_callback_url;
                    document.querySelector('#callback_type').value = payment_val.chanel_callback_type;
                    document.querySelector('#callback_data').value = payment_val.chanel_callback_data;
                }
            }
            Cart.buttonClass();
        }
    }
    /**
     * Data for shipping modules
     *
     *@param lang {Array} (lang)
     */
    static shippingData(lang) {
        Ajax.postData(window.location.href, {
            shipping_region_json: document.querySelector('#address').selectedOptions[0].dataset.regions,
            products_order_json: document.querySelector('#products_order').value
        }, true, null, AjaxSuccess).then((data) => {
        });

        function AjaxSuccess(data) {
            var shipping_method = JSON.parse(data);
            document.querySelector('#shipping_method').innerHTML = '';

            if (shipping_method.length < 1) {
                document.querySelector('#shipping_method').insertAdjacentHTML('beforeend', '<option value="no">' + lang.cart_shipping_is_not_available + '</option>');
                document.querySelector('#shipping_method').classList.remove('is-valid');
                document.querySelector('#shipping_method').classList.add('is-invalid');
                document.querySelector('#shipping_price').innerHTML = lang.cart_shipping_price + ' <b>' + lang.product_price + '</b>';
                document.querySelector('#total_price_modal').innerHTML = lang.cart_subtotal + ' <b>' + lang.total_price_cart_with_sale + '</b>';
            } else {
                for (var shipping_val of shipping_method) {
                    if (shipping_val['chanel_total_price'] < shipping_val.chanel_minimum_price) {
                        document.querySelector('#shipping_method').insertAdjacentHTML('beforeend', '<option value="no">' + shipping_val.chanel_name + lang.cart_shipping_is_not_available_and_min_price + ' ' + shipping_val.chanel_minimum_price_format + '</option>');
                        document.querySelector('#shipping_method').classList.remove('is-valid');
                        document.querySelector('#shipping_method').classList.add('is-invalid');
                        document.querySelector('#shipping_price').innerHTML = lang.cart_shipping_price + ' <b>' + shipping_val.chanel_shipping_price_format + '</b>';
                        document.querySelector('#total_price_modal').innerHTML = lang.cart_subtotal + +' <b>' + shipping_val.chanel_total_price_with_shipping_format + '</b>';
                        // input hidden
                        document.querySelector('#order_total').value = shipping_val.chanel_total_price_with_shipping;
                        document.querySelector('#hash').value = shipping_val.chanel_hash;
                    } else {
                        document.querySelector('#shipping_method').insertAdjacentHTML('beforeend', '<option value="' + shipping_val.chanel_module_name + '" data-shipping="' + shipping_val.chanel_id + '">' + shipping_val.chanel_name + '</option>');
                        document.querySelector('#shipping_method').classList.remove('is-invalid');
                        document.querySelector('#shipping_method').classList.add('is-valid');
                        document.querySelector('#shipping_price').innerHTML = lang.cart_shipping_price + ' <b>' + shipping_val.chanel_shipping_price_format + '</b>';
                        document.querySelector('#total_price_modal').innerHTML = lang.cart_subtotal + ' <b>' + shipping_val.chanel_total_price_with_shipping_format + '</b>';
                        if (shipping_val.chanel_total_tax > 0) {
                            document.querySelector('#total_tax_price').innerHTML = lang.cart_estimated_taxes + ' <b>' + shipping_val.chanel_total_tax_format + '</b>';
                        }
                        if (shipping_val.chanel_total_tax === 0) {
                            document.querySelector('#total_tax_price').innerHTML = lang.cart_price_including_all_taxes;
                        }
                        document.querySelector('#total_price_to_pay_modal').innerHTML = '<h5>' + lang.cart_total + ' ' + shipping_val.chanel_order_to_pay_format + '</h5>';
                        // input hidden
                        document.querySelector('#order_to_pay').value = shipping_val.chanel_order_to_pay;
                        document.querySelector('#order_total').value = shipping_val.chanel_total_price;
                        document.querySelector('#order_shipping_price').value = shipping_val.chanel_shipping_price;
                        document.querySelector('#order_total_tax').value = shipping_val.chanel_total_tax;
                        document.querySelector('#order_total_with_shipping').value = shipping_val.chanel_total_price_with_shipping;
                        document.querySelector('#hash').value = shipping_val.chanel_hash;
                    }
                }
            }
            Cart.buttonClass();
            // Update
            Cart.paymentData(lang);
        }
    }

    /**
     * Redirect
     *@param callback_url {String} (redirect url)
     *@param callback_data {Array} (callback data)
     *@param callback_type {String} (post/get)
     */
    static redirect(callback_url, callback_data, callback_type) {
        var form = '';
        var callback_data_arr = JSON.parse(callback_data);
        callback_data_arr.forEach (function (key, value) {
            form += '<input type="hidden" name="' + key + '" value="' + value + '">';
        });
        document.querySelector('#index').insertAdjacentHTML('afterbegin', '<form id="redirect" action="' + callback_url + '" method="' + callback_type + '">' + form + '</form>');
        document.querySelector('#redirect').submit();
    }

    /**
     * Success
     *
     */
    static callSuccess() {
        var callback_url = document.querySelector('#callback_url').value;
        var callback_type = document.querySelector('#callback_type').value;
        var callback_data = document.querySelector('#callback_data').value;
        bootstrap.Modal.getInstance(document.querySelector('#index')).hide();
        document.querySelector('#index').addEventListener('hidden.bs.modal', function (event) {
            let data = new FormData(document.forms.form_cart);
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '?route=success', false);
            xhr.send(data);
            if (xhr.status === 200) {
                if (data !== 'false') {
                    sessionStorage.removeItem('lang');
                    Cart.redirect(callback_url, callback_data, callback_type);
                }
            }
        });
    }
}