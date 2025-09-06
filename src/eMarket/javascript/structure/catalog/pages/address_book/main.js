/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* global Ajax */

/**
 * Address Book
 *
 * @package AddressBook
 * @author eMarket
 * 
 */
class AddressBook {
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
            var modal_id = Number(button.dataset.edit) - 1;

            document.querySelector('#countries').innerHTML = '';
            var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.json);
            var countries = JSON.parse(document.querySelector('#ajax_data').dataset.countries);

            if (Number.isInteger(modal_id)) {
                for (var x = 0; x < countries.length; x++) {
                    if (countries[x].id === json_data[modal_id].countries_id) {
                        document.querySelector('#countries').insertAdjacentHTML('beforeend', '<option selected value="' + countries[x].id + '">' + countries[x].name + '</option>');
                    } else {
                        document.querySelector('#countries').insertAdjacentHTML('beforeend', '<option value="' + countries[x].id + '">' + countries[x].name + '</option>');
                    }
                }

                Ajax.postData(window.location.href, {
                    countries_select: json_data[modal_id].countries_id
                }, true, null, AjaxSuccess).then((data) => {
                });
                function AjaxSuccess(data) {
                    var regions = JSON.parse(data);
                    document.querySelector('#regions').innerHTML = '';

                    for (var x = 0; x < regions.length; x++) {
                        if (regions[x]['id'] === json_data[modal_id].regions_id) {
                            document.querySelector('#regions').insertAdjacentHTML('beforeend', '<option selected value="' + regions[x].id + '">' + regions[x].name + '</option>');
                        } else {
                            document.querySelector('#regions').insertAdjacentHTML('beforeend', '<option value="' + regions[x].id + '">' + regions[x].name + '</option>');
                        }
                    }
                }

                document.querySelector('#countries').addEventListener('change', (e) => {
                    Ajax.postData(window.location.href, {
                        countries_select: document.querySelector('#countries').value
                    }, true, null, AjaxSuccess).then((data) => {
                    });
                    function AjaxSuccess(data) {
                        var regions = JSON.parse(data);
                        document.querySelector('#regions').innerHTML = '';

                        for (var x = 0; x < regions.length; x++) {
                            if (regions[x]['id'] === json_data[modal_id].regions_id) {
                                document.querySelector('#regions').insertAdjacentHTML('beforeend', '<option selected value="' + regions[x].id + '">' + regions[x].name + '</option>');
                            } else {
                                document.querySelector('#regions').insertAdjacentHTML('beforeend', '<option value="' + regions[x].id + '">' + regions[x].name + '</option>');
                            }
                        }
                    }
                });

                document.querySelector('#city').value = json_data[modal_id].city;
                document.querySelector('#zip').value = json_data[modal_id].zip;
                document.querySelector('#address').value = json_data[modal_id].address;
                document.querySelector('#edit').value = modal_id + 1;
                document.querySelector('#add').value = '';

                document.querySelector('#default').checked = json_data[modal_id].default;

            } else {

                document.querySelector('#edit').value = '';
                document.querySelector('#add').value = 'ok';
                document.querySelectorAll('form').forEach(e => e.reset());

                for (var x = 0; x < countries.length; x++) {
                    document.querySelector('#countries').insertAdjacentHTML('beforeend', '<option value="' + countries[x].id + '">' + countries[x].name + '</option>');
                }

                Ajax.postData(window.location.href, {
                    countries_select: countries[0].id
                }, true, null, AjaxSuccess).then((data) => {
                });
                function AjaxSuccess(data) {
                    var regions = JSON.parse(data);
                    document.querySelector('#regions').innerHTML = '';

                    for (var x = 0; x < regions.length; x++) {
                        document.querySelector('#regions').insertAdjacentHTML('beforeend', '<option value="' + regions[x].id + '">' + regions[x].name + '</option>');
                    }
                }

                document.querySelector('#countries').addEventListener('change', (e) => {
                    Ajax.postData(window.location.href, {
                        countries_select: document.querySelector('#countries').value
                    }, true, null, AjaxSuccess).then((data) => {
                    });
                    function AjaxSuccess(data) {
                        var regions = JSON.parse(data);
                        document.querySelector('#regions').innerHTML = '';

                        for (var x = 0; x < regions.length; x++) {
                            document.querySelector('#regions').insertAdjacentHTML('beforeend', '<option value="' + regions[x].id + '">' + regions[x].name + '</option>');
                        }
                    }
                });
            }
        });
    }
}