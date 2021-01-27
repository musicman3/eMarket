/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
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
     */
    update(name) {
        new bootstrap.Modal(document.querySelector('#confirm')).show();
        confirmation.onclick = function () {
            Ajax.callAdd(name);

        };
    }
}