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
}