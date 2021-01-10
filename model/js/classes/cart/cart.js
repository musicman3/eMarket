/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
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
        $('#address').change(function (event) {
            Cart.shippingData(lang);
        });

        $('#shipping_method').change(function (event) {
            Cart.paymentData(lang);
        });
    }

    /**
     * Quantity
     * @param val {String} (value)
     * @param id {String} (product id)
     * @param max_quantity {String} (max quantity)
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

    /**
     * Quantity update
     *
     *@param id {String} (product id)
     *@param pcs {Int} (quantity)
     */
    static quantityProduct(id, pcs) {
        jQuery.ajaxSetup({async: false});
        jQuery.get(window.location.href,
                {quantity_product_id: id,
                    pcs_product: pcs},
                AjaxSuccess);
        function AjaxSuccess(data) {
            $('#cart_bar').replaceWith($(data).find('#cart_bar'));
            $('#cart').replaceWith($(data).find('#cart'));
            $('#index').replaceWith($(data).find('#index'));
            new Cart();
        }
    }

    /**
     * Delete
     *
     *@param id {String} (product id)
     */
    static deleteProduct(id) {
        jQuery.ajaxSetup({async: false});
        jQuery.get(window.location.href,
                {delete_product: id},
                AjaxSuccess);
        function AjaxSuccess(data) {
            $('#cart_bar').replaceWith($(data).find('#cart_bar'));
            $('#cart').replaceWith($(data).find('#cart'));
            $('#index').replaceWith($(data).find('#index'));
            new Cart();
        }
    }

    /**
     * Changing class of buttons
     *
     */
    static buttonClass() {
        if ($("#address_class").attr("class") !== 'input-group has-success' || $("#shipping_method_class").attr("class") !== 'input-group has-success' || $("#payment_method_class").attr("class") !== 'input-group has-success') {
            $("#complete").attr("disabled", "disabled");
        } else {
            $("#complete").removeAttr("disabled");
        }
    }

    /**
     * Data for payment modules
     *
     *@param lang {Array} (lang)
     */
    static paymentData(lang) {
        jQuery.post(window.location.href,
                {payment_shipping_json: $(':selected', '#shipping_method').val()},
                AjaxSuccess);
        function AjaxSuccess(data) {
            var payment_method = JSON.parse(data);
            $("#payment_method").empty();

            if ($("#shipping_method_class").attr("class") !== 'input-group has-success' || payment_method.length < 1) {
                $("#payment_method").append($('<option value="no">' + lang['cart_payment_is_not_available'] + '</option>'));
                $('#payment_method_class').removeClass('has-success');
                $('#payment_method_class').addClass('has-error');
            } else {
                for (var payment_val of payment_method) {
                    $("#payment_method").append($('<option value="' + payment_val['chanel_module_name'] + '">' + payment_val['chanel_name'] + '</option>'));
                    $('#payment_method_class').removeClass('has-error');
                    $('#payment_method_class').addClass('has-success');
                    $('#callback_url').val(payment_val['chanel_callback_url']);
                    $('#callback_type').val(payment_val['chanel_callback_type']);
                    $('#callback_data').val(payment_val['chanel_callback_data']);
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
        jQuery.post(window.location.href,
                {shipping_region_json: $(':selected', '#address').data('regions'),
                    products_order_json: $('#products_order').val()},
                AjaxSuccess);
        function AjaxSuccess(data) {
            var shipping_method = JSON.parse(data);
            $("#shipping_method").empty();

            if (shipping_method.length < 1) {
                $("#shipping_method").append($('<option value="no">' + lang['cart_shipping_is_not_available'] + '</option>'));
                $('#shipping_method_class').removeClass('has-success');
                $('#shipping_method_class').addClass('has-error');
                $('#shipping_price').html(lang['cart_shipping_price'] + ' <b>' + lang['product_price'] + '</b>');
                $('#total_price_modal').html(lang['cart_subtotal'] + ' <b>' + lang['total_price_cart_with_sale'] + '</b>');
            } else {
                for (var shipping_val of shipping_method) {
                    if (shipping_val['chanel_total_price'] < shipping_val['chanel_minimum_price']) {
                        $("#shipping_method").append($('<option value="no">' + shipping_val['chanel_name'] + lang['cart_shipping_is_not_available_and_min_price'] + ' ' + shipping_val['chanel_minimum_price_format'] + '</option>'));
                        $('#shipping_method_class').removeClass('has-success');
                        $('#shipping_method_class').addClass('has-error');
                        $('#shipping_price').html(lang['cart_shipping_price'] + ' <b>' + shipping_val['chanel_shipping_price_format'] + '</b>');
                        $('#total_price_modal').html(lang['cart_subtotal'] +  + ' <b>' + shipping_val['chanel_total_price_with_shipping_format'] + '</b>');
                        // input hidden
                        $('#order_total').val(shipping_val['chanel_total_price_with_shipping']);
                        $('#hash').val(shipping_val['chanel_hash']);
                    } else {
                        $("#shipping_method").append($('<option value="' + shipping_val['chanel_module_name'] + '" data-shipping="' + shipping_val['chanel_id'] + '">' + shipping_val['chanel_name'] + '</option>'));
                        $('#shipping_method_class').removeClass('has-error');
                        $('#shipping_method_class').addClass('has-success');
                        $('#shipping_price').html(lang['cart_shipping_price'] + ' <b>' + shipping_val['chanel_shipping_price_format'] + '</b>');
                        $('#total_price_modal').html(lang['cart_subtotal'] + ' <b>' + shipping_val['chanel_total_price_with_shipping_format'] + '</b>');
                        if (shipping_val['chanel_total_tax'] > 0) {
                            $('#total_tax_price').html(lang['cart_estimated_taxes'] + ' <b>' + shipping_val['chanel_total_tax_format'] + '</b>');
                        }
                        if (shipping_val['chanel_total_tax'] === 0) {
                            $('#total_tax_price').html(lang['cart_price_including_all_taxes']);
                        }
                        $('#total_price_to_pay_modal').html('<h5>' + lang['cart_total'] + ' ' + shipping_val['chanel_order_to_pay_format'] + '</h5>');
                        // input hidden
                        $('#order_to_pay').val(shipping_val['chanel_order_to_pay']);
                        $('#order_total').val(shipping_val['chanel_total_price']);
                        $('#order_shipping_price').val(shipping_val['chanel_shipping_price']);
                        $('#order_total_tax').val(shipping_val['chanel_total_tax']);
                        $('#order_total_with_shipping').val(shipping_val['chanel_total_price_with_shipping']);
                        $('#hash').val(shipping_val['chanel_hash']);
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
        $.each(callback_data_arr, function (key, value) {
            form += '<input type="hidden" name="' + key + '" value="' + value + '">';
        });
        $('<form action="' + callback_url + '" method="' + callback_type + '">' + form + '</form>').appendTo($('#index')).submit();
    }

    /**
     * Success
     *
     */
    static callSuccess() {
        var msg = $('#form_cart').serialize();
        var callback_url = $('#callback_url').val();
        var callback_type = $('#callback_type').val();
        var callback_data = $('#callback_data').val();

        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'POST',
            url: '?route=success',
            data: msg,
            beforeSend: function () {
                $('#index').modal('hide');
            },
            success: function (data) {
                if (data !== 'false') {
                    sessionStorage.removeItem('lang');
                    Cart.redirect(callback_url, callback_data, callback_type);
                }
            }
        });
    }
}