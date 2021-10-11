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

        document.querySelector('#payment_method').addEventListener('change', (e) => {
            Cart.paymentClickValue(lang);
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
        var complete = document.querySelector('#complete');
        if (document.querySelector('#address_class').className !== 'form-control is-valid' && document.querySelector('#shipping_method').className !== 'form-control is-valid' && document.querySelector('#payment_method').className !== 'form-control is-valid') {
            complete.classList.remove('btn-primary');
            complete.classList.add('btn-danger');
            complete.setAttribute('disabled', 'disabled');
        } else {
            complete.removeAttribute('disabled');
            complete.classList.remove('btn-danger');
            complete.classList.add('btn-primary');
        }
    }

    /**
     * Data for payment modules
     *
     *@param lang {Array} (lang)
     */
    static paymentData(lang) {
        var shipping = document.querySelector('#shipping_method');
        Ajax.postData(window.location.href, {
            payment_shipping_json: shipping.value
        }, true, null, AjaxSuccess).then((data) => {
        });
        function AjaxSuccess(data) {
            var payment_method = JSON.parse(data);
            var payment = document.querySelector('#payment_method');
            payment.innerHTML = '';
            if (shipping.className !== 'form-control is-valid' || payment_method.length < 1) {
                payment.insertAdjacentHTML('beforeend', '<option value="no">' + lang.cart_payment_is_not_available + '</option>');
                payment.classList.remove('is-valid');
                payment.classList.add('is-invalid');
            } else {
                for (var payment_val of payment_method) {
                    payment.insertAdjacentHTML('beforeend', '<option value="' + payment_val.chanel_module_name + '">' + payment_val.chanel_name + '</option>');
                    payment.classList.remove('is-invalid');
                    payment.classList.add('is-valid');
                    if (payment_val.chanel_module_name === payment.value) {
                        document.querySelector('#callback_url').value = payment_val.chanel_callback_url;
                        document.querySelector('#callback_type').value = payment_val.chanel_callback_type;
                        document.querySelector('#callback_data').value = payment_val.chanel_callback_data;
                    }
                }
            }
            Cart.buttonClass();
        }
    }

    /**
     * Values for selected payment module
     *
     *@param lang {Array} (lang)
     */
    static paymentClickValue(lang) {
        Ajax.postData(window.location.href, {
            payment_shipping_json: document.querySelector('#shipping_method').value
        }, true, null, AjaxSuccess).then((data) => {
        });
        function AjaxSuccess(data) {
            var payment_method = JSON.parse(data);

            for (var payment_val of payment_method) {
                if (payment_val.chanel_module_name === document.querySelector('#payment_method').value) {
                    document.querySelector('#callback_url').value = payment_val.chanel_callback_url;
                    document.querySelector('#callback_type').value = payment_val.chanel_callback_type;
                    document.querySelector('#callback_data').value = payment_val.chanel_callback_data;
                }
            }
        }
    }

    /**
     * Data for shipping modules
     *
     *@param lang {Array} (lang)
     */
    static shippingData(lang) {
        var address = document.querySelector('#address');
        if (address.selectedOptions.length > 0) {
            Ajax.postData(window.location.href, {
                shipping_region_json: address.selectedOptions[0].dataset.regions,
                products_order_json: document.querySelector('#products_order').value
            }, true, null, AjaxSuccess).then((data) => {
            });
        }

        function AjaxSuccess(data) {
            var shipping_method = JSON.parse(data);
            var shipping = document.querySelector('#shipping_method');
            shipping.innerHTML = '';
            var shipping_price = document.querySelector('#shipping_price');
            var total_price_modal = document.querySelector('#total_price_modal');
            var total_tax_price = document.querySelector('#total_tax_price');
            var hash = document.querySelector('#hash');
            var order_total = document.querySelector('#order_total');

            if (shipping_method.length < 1) {
                shipping.insertAdjacentHTML('beforeend', '<option value="no">' + lang.cart_shipping_is_not_available + '</option>');
                shipping.classList.remove('is-valid');
                shipping.classList.add('is-invalid');
                shipping_price.innerHTML = lang.cart_shipping_price + ' <b>' + lang.product_price + '</b>';
                total_price_modal.innerHTML = lang.cart_subtotal + ' <b>' + lang.total_price_cart_with_sale + '</b>';
            } else {
                for (var shipping_val of shipping_method) {
                    if (shipping_val['chanel_total_price'] < shipping_val.chanel_minimum_price) {
                        shipping.insertAdjacentHTML('beforeend', '<option value="no">' + shipping_val.chanel_name + lang.cart_shipping_is_not_available_and_min_price + ' ' + shipping_val.chanel_minimum_price_format + '</option>');
                        shipping.classList.remove('is-valid');
                        shipping.classList.add('is-invalid');
                        shipping_price.innerHTML = lang.cart_shipping_price + ' <b>' + shipping_val.chanel_shipping_price_format + '</b>';
                        total_price_modal.innerHTML = lang.cart_subtotal + +' <b>' + shipping_val.chanel_total_price_with_shipping_format + '</b>';
                        // input hidden
                        order_total.value = shipping_val.chanel_total_price_with_shipping;
                        hash.value = shipping_val.chanel_hash;
                    } else {
                        shipping.insertAdjacentHTML('beforeend', '<option value="' + shipping_val.chanel_module_name + '" data-shipping="' + shipping_val.chanel_id + '">' + shipping_val.chanel_name + '</option>');
                        shipping.classList.remove('is-invalid');
                        shipping.classList.add('is-valid');
                        shipping_price.innerHTML = lang.cart_shipping_price + ' <b>' + shipping_val.chanel_shipping_price_format + '</b>';
                        total_price_modal.innerHTML = lang.cart_subtotal + ' <b>' + shipping_val.chanel_total_price_with_shipping_format + '</b>';
                        if (shipping_val.chanel_total_tax > 0) {
                            total_tax_price.innerHTML = lang.cart_estimated_taxes + ' <b>' + shipping_val.chanel_total_tax_format + '</b>';
                        }
                        if (shipping_val.chanel_total_tax === 0) {
                            total_tax_price.innerHTML = lang.cart_price_including_all_taxes;
                        }
                        document.querySelector('#total_price_to_pay_modal').innerHTML = '<h5>' + lang.cart_total + ' ' + shipping_val.chanel_order_to_pay_format + '</h5>';
                        // input hidden
                        document.querySelector('#order_to_pay').value = shipping_val.chanel_order_to_pay;
                        order_total.value = shipping_val.chanel_total_price;
                        document.querySelector('#order_shipping_price').value = shipping_val.chanel_shipping_price;
                        document.querySelector('#order_total_tax').value = shipping_val.chanel_total_tax;
                        document.querySelector('#order_total_with_shipping').value = shipping_val.chanel_total_price_with_shipping;
                        hash.value = shipping_val.chanel_hash;
                    }
                }
            }
            Cart.buttonClass();
            // Update
            Cart.paymentData(lang);
        }
    }

    /**
     * Success
     *
     */
    static callSuccess() {
        bootstrap.Modal.getInstance(document.querySelector('#index')).hide();
        document.querySelector('#index').addEventListener('hidden.bs.modal', function (event) {
            document.querySelector('#form_cart').submit();
        });
    }
}