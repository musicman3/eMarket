/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global bootstrap, Ajax */

/**
 * Checkout
 *
 * @package Cart
 * @author eMarket
 * 
 */
class Checkout {
    /**
     * Redirect
     *@param callback_url {String} (redirect url)
     *@param callback_data {Array} (callback data)
     *@param callback_type {String} (post/get)
     */
    static redirect(callback_url, callback_data, callback_type) {
        var form = '';
        var callback_data_arr = JSON.parse(callback_data);
        for(let key in callback_data_arr) {
            form += '<input type="hidden" name="' + key + '" value="' + callback_data_arr[key] + '">';
        }
        document.querySelector('#checkout').insertAdjacentHTML('afterbegin', '<form name="redirect" id="redirect" action="' + callback_url + '" method="' + callback_type + '">' + form + '</form>');
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

        let data = new FormData(document.forms.form_cart);
        data.append('csrf_token', document.querySelector('#csrf_token').dataset.csrf);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '?route=success', false);
        xhr.send(data);
        if (xhr.status === 200 && data !== 'false') {
            sessionStorage.removeItem('lang');
            Checkout.redirect(callback_url, callback_data, callback_type);
        }
    }
}