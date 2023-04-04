/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global bootstrap, Ajax, Randomizer */

/**
 * Update
 *
 * @package Update
 * @author eMarket
 * 
 */
class Update {

    /**
     * Constructor
     *
     */
    constructor() {
        Update.init();
    }

    /**
     * Request
     *
     */
    static request() {

        var randomizer = new Randomizer();

        var param = encodeURI(JSON.stringify({
            'jsonrpc': '2.0',
            'method': 'Update',
            'param': [],
            'id': randomizer.uid(32)}));

        if (document.querySelector('#user_login').dataset.login !== 'false' && Update.requestTime() === true) {
            Ajax.postData('/services/jsonrpc/?request=' + param,
                    {'login': document.querySelector('#user_login').dataset.login},
                    null, null, Update.Response).then((data) => {
            });
        } else {
            Update.Response(sessionStorage.getItem('update_response'));
        }
    }

    /**
     * Time for request
     *
     */
    static requestTime() {
        var time = new Date();
        var time_second = Math.round(time.getTime() / 1000);

        if (sessionStorage.getItem('update_time') === null) {
            sessionStorage.setItem('update_time', time_second);
            return true;
        }
        if (sessionStorage.getItem('update_time') < (time_second - 3600)) {
            sessionStorage.setItem('update_time', time_second);
            return true;
        }

        return false;
    }

    /**
     * Init
     *
     */
    static init() {
        Update.request();
    }

    /**
     * Response
     *
     * @param data {Object} (response)
     */
    static Response(data) {
        var input = JSON.parse(data);
        sessionStorage.setItem('update_response', data);

        const tooltip = bootstrap.Tooltip.getOrCreateInstance('#update_box');
        document.querySelector('#update_box').setAttribute('data-bs-original-title', input.message);

        var text_class = 'text-success';

        if (input.status === 'false') {
            text_class = 'text-warning';
        }
        document.querySelector('#update_box').classList.replace('text-secondary', text_class);
    }
}