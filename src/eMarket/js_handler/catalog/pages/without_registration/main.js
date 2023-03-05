/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* global Ajax */

/**
 * Without Registration
 *
 * @package WithoutRegistration
 * @author eMarket
 * 
 */
class WithoutRegistration {
    /**
     * Constructor
     *
     */
    constructor() {
        this.init();
    }

    /**
     * Init
     * 
     */
    init() {

        document.querySelector('#countries').innerHTML = '';
        var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.json);
        var countries = JSON.parse(document.querySelector('#ajax_data').dataset.countries);
        var registration_data = JSON.parse(document.querySelector('#ajax_data').dataset.registrationdata);
        var registration_user = JSON.parse(document.querySelector('#ajax_data').dataset.registrationuser);
        var default_country = countries[0].id;
        var default_region = '0';

        document.querySelector('#add').value = 'ok';
        document.querySelectorAll('form').forEach(e => e.reset());

        if (registration_data.length > 0) {
            default_country = registration_data[0].countries_id;
            default_region = registration_data[0].regions_id;
            document.querySelector('#city').value = registration_data[0].city;
            document.querySelector('#zip').value = registration_data[0].zip;
            document.querySelector('#address').value = registration_data[0].address;
        }
        if (registration_user.length > 0) {
            document.querySelector('#input-firstname').value = registration_user[0].firstname;
            document.querySelector('#input-lastname').value = registration_user[0].lastname;
            document.querySelector('#input-telephone').value = registration_user[0].telephone;
        }

        for (var x = 0; x < countries.length; x++) {
            if (countries[x].id === default_country) {
                document.querySelector('#countries').insertAdjacentHTML('beforeend', '<option selected value="' + countries[x].id + '">' + countries[x].name + '</option>');
            } else {
                document.querySelector('#countries').insertAdjacentHTML('beforeend', '<option value="' + countries[x].id + '">' + countries[x].name + '</option>');
            }
        }

        Ajax.postData(window.location.href, {
            countries_select: default_country
        }, true, null, AjaxSuccess).then((data) => {
        });
        function AjaxSuccess(data) {
            var regions = JSON.parse(data);
            document.querySelector('#regions').innerHTML = '';

            for (var x = 0; x < regions.length; x++) {
                if (regions[x].id === default_region) {
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
                    document.querySelector('#regions').insertAdjacentHTML('beforeend', '<option value="' + regions[x].id + '">' + regions[x].name + '</option>');
                }
            }
        });
    }
}