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
        $('#confirm').modal('show');
        confirmation.onclick = function () {
            Ajax.callDelete(id);
        };
    }

    /**
     * Init for confirm add
     *
     *@param name {String} (name)
     */
    update(name) {
        $('#confirm').modal('show');
        confirmation.onclick = function () {
            Ajax.callAdd(name);

        };
    }
}