/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Helpers
 *
 * @package Helpers
 * @author eMarket
 * 
 */
class Helpers {

    /**
     * Native on
     *
     *@param eSel {String} (parent selector)
     *@param eName {String} (event name)
     *@param selector {String} (search selector)
     *@param fn {Func} (Func)
     */
    static on(eSel, eName, selector, fn) {
        var element = document.querySelector(eSel);

        element.addEventListener(eName, function (event) {
            var targ = element.querySelectorAll(selector);
            var target = event.target;

            for (var i = 0, l = targ.length; i < l; i++) {
                var el = target;
                var p = targ[i];

                while (el && el !== element) {
                    if (el === p) {
                        return fn.call(p, event);
                    }

                    el = el.parentNode;
                }
            }
        });
    }

    /**
     * Serialize all form data into an array of key/value pairs
     * (c) 2020 Chris Ferdinandi, MIT License, https://gomakethings.com
     * @param {Node} form The form to serialize
     * @return {Array} The serialized form data
     */
    static serializeArray(form) {
        var arr = [];
        Array.prototype.slice.call(document.querySelector(form).elements).forEach(function (field) {
            if (!field.name || field.disabled || ['file', 'reset', 'submit', 'button'].indexOf(field.type) > -1)
                return;
            if (field.type === 'select-multiple') {
                Array.prototype.slice.call(field.options).forEach(function (option) {
                    if (!option.selected)
                        return;
                    arr.push({
                        name: field.name,
                        value: option.value
                    });
                });
                return;
            }
            if (['checkbox', 'radio'].indexOf(field.type) > -1 && !field.checked)
                return;
            arr.push({
                name: field.name,
                value: field.value
            });
        });
        return arr;
    }

    /**
     * Url from array
     *
     *@param url {String} (URL)
     *@param array {Array} (name array)
     *@return url {String} (URL)
     */
    static urlFromArray(url, array) {
        let url_out = new URL(url);
        let params = new URLSearchParams(url_out.search.slice(1));
        
        for (var key in array) {
            params.append(key, array[key]);
        }
        return '?' + params.toString();
        
    }

}