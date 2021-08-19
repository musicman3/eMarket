/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* global Fileupload */

/**
 * Manufacturers
 *
 * @package Manufacturers
 * @author eMarket
 * 
 */
class Manufacturers {
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
                    document.querySelector('#name_manufacturers_' + x).value = json_data.name[x][modal_id];
                }
                document.querySelector('#site_manufacturers').value = json_data.site[modal_id];

                Fileupload.getImageToEdit(json_data.logo_general, json_data.logo, modal_id, 'manufacturers');
            } else {
                document.querySelector('#edit').value = '';
                document.querySelector('#add').value = 'ok';
                document.querySelectorAll('form').forEach(e => e.reset());
            }
        });
    }
}