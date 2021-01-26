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
     * Init for confirm
     *
     *@param id {String} (id)
     */
    init(id) {
        $('#confirm').modal('show');

        confirmation.onclick = function () {
            $('#confirm').modal('hide');
            $('#confirm').on('hidden.bs.modal', function (event) {
                Ajax.callDelete(id);
            });

        };
    }
}