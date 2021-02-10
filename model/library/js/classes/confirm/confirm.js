/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global bootstrap, confirmation, Ajax */

/**
 * Confirmation
 *
 * @package Confirm
 * @author eMarket
 * 
 */
class Confirm {

    /**
     * Init for confirm delete
     *
     *@param id {String} (id)
     */
    del(id) {
        new bootstrap.Modal(document.querySelector('#confirm')).show();
        confirmation.onclick = function () {
            Ajax.callDelete(id);
        };
    }

    /**
     * Init for confirm update
     *
     *@param name {String} (name)
     *@param text {String} (body text)
     */
    update(name, text) {
        var body_text = document.querySelector('#confirm_body').innerHTML;
        document.querySelector('#confirm_body').innerHTML = text;
        new bootstrap.Modal(document.querySelector('#confirm')).show();
        confirmation.onclick = function () {
            Ajax.callAdd(name);
        };
        document.querySelector('#confirm').addEventListener('hidden.bs.modal', function (event) {
            document.querySelector('#confirm_body').innerHTML = body_text;
        });
    }
}