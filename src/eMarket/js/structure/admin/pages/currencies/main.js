/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/**
 * Currencies
 *
 * @package Currencies
 * @author eMarket
 * 
 */
class Currencies {
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
                    document.querySelector('#name_currencies_' + x).value = json_data.name[x][modal_id];
                    document.querySelector('#code_currencies_' + x).value = json_data.code[x][modal_id];
                }

                document.querySelector('#iso_4217_currencies').value = json_data.iso_4217[modal_id];
                document.querySelector('#value_currencies').value = json_data.value[modal_id];
                document.querySelector('#symbol_currencies').value = json_data.symbol[modal_id];
                document.querySelector('#decimal_places_currencies').value = json_data.decimal_places[modal_id];
                document.querySelector('#default_value_currencies').checked = json_data.default_value[modal_id];

                if (json_data.symbol_position[modal_id] === 'left') {
                    document.querySelector('#symbol_position_currencies option[value="left"]').selected = true;
                } else {
                    document.querySelector('#symbol_position_currencies option[value="right"]').selected = true;
                }
            } else {
                document.querySelector('#edit').value = '';
                document.querySelector('#add').value = 'ok';
                document.querySelectorAll('form').forEach(e => e.reset());
            }
        });
    }
}