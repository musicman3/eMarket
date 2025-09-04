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

        var jsonRpcRequest = {
            'jsonrpc': '2.0',
            'method': 'eMarket\\JsonRpc\\Update',
            'param': {'login': document.querySelector('#user_login').dataset.login},
            'id': randomizer.uid(32)};

        if (document.querySelector('#user_login').dataset.login !== 'false' && Update.requestTime() === true) {
            Ajax.jsonRpcSend('/services/jsonrpc/request/',
                    jsonRpcRequest,
                    Update.Response).then((data) => {
            });
        } else {
            Update.Response(sessionStorage.getItem('update_response'));
        }
    }

    /**
     * Update button click
     *
     */
    static updateClick() {

        document.querySelector('#update_button').onclick = function () {
            var randomizer = new Randomizer();

            var jsonRpcRequest = {
                'jsonrpc': '2.0',
                'method': 'eMarket\\JsonRpc\\Update',
                'param': {
                    'message': 'update',
                    'login': document.querySelector('#user_login').dataset.login
                },
                'id': randomizer.uid(32)};

            Ajax.jsonRpcSend('/services/jsonrpc/request/',
                    jsonRpcRequest,
                    Update.Redirect).then((data) => {
            });
        };
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
        Update.updateClick();
    }

    /**
     * Response
     *
     * @param data {Object} (response)
     */
    static Response(data) {

        var input = JSON.parse(data);
        if (input !== null) {
            sessionStorage.setItem('update_response', data);
            const tooltip = bootstrap.Tooltip.getOrCreateInstance('#update_box');

            document.querySelector('#update_box').setAttribute('data-bs-original-title', input.result.message);
            var text_class = 'text-success';

            if (input.result.status === 'false') {
                text_class = 'text-danger';
            }
            document.querySelector('#update_box').classList.replace('text-warning', text_class);
        }
    }

    /**
     * Redirect
     *
     * @param data {Object} (response)
     */
    static Redirect(data) {
        var input = JSON.parse(data);
        if (input.result.status === 'update') {
            document.location.href = '/update.php';
        }
    }
}