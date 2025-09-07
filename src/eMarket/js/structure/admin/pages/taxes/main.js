/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/**
 * Taxes
 *
 * @package Taxes
 * @author eMarket
 * 
 */
class Taxes {
    /**
     * Constructor
     *
     */
    constructor() {
        Taxes.json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsondata);
        this.modalShow();
        this.fixedChange();
    }

    /**
     * Fixed/Percent view
     * 
     */
    fixedChange() {
        var currency = document.querySelector('#currency');
        var json_data = Taxes.json_data;
        document.querySelector('#fixed').addEventListener('change', (e) => {
            if (currency.innerHTML === '%') {
                currency.innerHTML = json_data.currency;
            } else {
                currency.innerHTML = '%';
            }
        });
    }

    /**
     * Modal show
     * 
     */
    modalShow() {
        document.querySelector('#index').addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var modal_id = Number(button.dataset.edit);
            var json_data = Taxes.json_data;

            if (Number.isInteger(modal_id)) {
                document.querySelector('#edit').value = modal_id;
                document.querySelector('#add').value = '';

                for (var x = 0; x < json_data.name.length; x++) {
                    document.querySelector('#name_taxes_' + x).value = json_data.name[x][modal_id];
                }
                document.querySelector('#rate_taxes').value = json_data.rate[modal_id];
                document.querySelector('#tax_type').checked = json_data.tax_type[modal_id];
                document.querySelector('#fixed').checked = json_data.fixed[modal_id];
                document.querySelector('#zones_id').innerHTML = '';

                json_data.zones.forEach((value) => {
                    document.querySelector('#zones_id').insertAdjacentHTML('beforeend', '<option value="' + value.id + '">' + value.name + '</option>');
                });

                if (json_data.zones_id[modal_id] !== undefined && json_data.zones_id[modal_id] !== null) {
                    document.querySelector('#zones_id option[value="' + json_data.zones_id[modal_id] + '"]').selected = true;
                }

                if (json_data.fixed[modal_id] === 0) {
                    document.querySelector('#currency').innerHTML = json_data.currency;
                } else {
                    document.querySelector('#currency').innerHTML = '%';
                }

            } else {

                document.querySelector('#edit').value = '';
                document.querySelector('#add').value = 'ok';
                document.querySelector('#currency').innerHTML = '%';
                document.querySelectorAll('form').forEach(e => e.reset());

                var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsondata);
                document.querySelector('#zones_id').innerHTML = '';

                json_data.zones.forEach((value) => {
                    document.querySelector('#zones_id').insertAdjacentHTML('beforeend', '<option value="' + value.id + '">' + value.name + '</option>');
                });
            }

        });
    }
}