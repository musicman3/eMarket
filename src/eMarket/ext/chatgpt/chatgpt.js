/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global bootstrap, fetch, AjaxSuccess, Randomizer */

/**
 * Ajax requests
 *
 * @package ChatGPT
 * @author eMarket
 * 
 */
class ChatGPT {

    /**
     * ChatGPT POST request
     *
     * @param url {String} (url)
     * @param data {Obj} (data)
     * @param func {Object} (function)
     * @returns {Object|Void} (return data)
     */
    async request(url = '', data = {}, func = null) {

        data.csrf_token = document.querySelector('#csrf_token').dataset.csrf;

        var pref = {
            method: 'POST',
            mode: 'no-cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'User-Agent': 'eMarket'
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
            body: JSON.stringify(data)
        };

        const response = await fetch(url, pref).then(
                data => {
                    return data.text();
                }
        ).then(
                text => {
                    if (func !== null && func !== false && typeof func === 'function') {
                        func(text);
                    }
                }
        );
    }

    /**
     * Chat
     *
     * @param content {String} (question for ChatGPT assistant)
     */
    chat(content = 'Say this is a test!') {

        var randomizer = new Randomizer();

        var param = encodeURI(JSON.stringify({
            'jsonrpc': '2.0',
            'method': 'ChatGPT',
            'param': [],
            'id': randomizer.uid(32)}));

        var chatrequest =  this.request('/services/jsonrpc/?request=' + param,
                {'message': content},
                ChatGPT.Response).then((data) => {
        });
    }

    /**
     * Response
     *
     * @param data {Object} (ChatGPT response)
     */
    static Response(data) {

            console.log(data);
        
    }
}