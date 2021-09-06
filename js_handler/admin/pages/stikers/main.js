/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/**
 * Stickers
 *
 * @package Stickers
 * @author eMarket
 * 
 */
class Stickers {
    /**
     * Constructor
     *
     */
    constructor() {
        this.modalShow();
    }

    /**
     * Modal show
     * 
     */
    modalShow() {
        document.querySelector('#index').addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var modal_id = Number(button.dataset.edit);
            if (Number.isInteger(modal_id)) {
                var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsondata);

                document.querySelector('#edit').value = modal_id;
                document.querySelector('#add').value = '';

                for (var x = 0; x < json_data.name.length; x++) {
                    document.querySelector('#name_stickers_' + x).value = json_data.name[x][modal_id];
                }

                document.querySelector('#default_stickers').checked = json_data.default_stickers[modal_id];
            } else {
                document.querySelector('#edit').value = '';
                document.querySelector('#add').value = 'ok';
                document.querySelectorAll('form').forEach(e => e.reset());
            }
        });
    }
}