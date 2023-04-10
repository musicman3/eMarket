/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/**
 * Countries
 *
 * @package Countries
 * @author eMarket
 * 
 */
class Countries {
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
                    document.querySelector('#name_countries_' + x).value = json_data.name[x][modal_id];
                }

                document.querySelector('#alpha_2_countries').value = json_data.alpha_2[modal_id];
                document.querySelector('#alpha_3_countries').value = json_data.alpha_3[modal_id];
                document.querySelector('#address_format_countries').value = json_data.address_format[modal_id];
            } else {
                document.querySelector('#edit').value = '';
                document.querySelector('#add').value = 'ok';
                document.querySelectorAll('form').forEach(e => e.reset());
            }
        });
    }
}