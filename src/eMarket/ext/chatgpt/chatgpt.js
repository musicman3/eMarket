/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global bootstrap, fetch, AjaxSuccess, Randomizer, tinymce */

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

        this.request('/services/jsonrpc/?request=' + param,
                {'message': content,
                'login': document.querySelector('#user_login').dataset.login},
                this.Response).then((data) => {
        });
        document.querySelector('#chatgptsendspan').classList.add('spinner-grow');
        document.querySelector('#chatgptsendspan').classList.add('spinner-grow-sm');
        document.querySelector('#chatgptsend').disabled = true;
    }

    /**
     * Response
     *
     * @param data {Object} (ChatGPT response)
     */
    Response(data) {
        var input = JSON.parse(data);
        if (input.choices[0].message.content !== undefined) {
            document.querySelector('#chatgptsendspan').classList.remove('spinner-grow');
            document.querySelector('#chatgptsendspan').classList.remove('spinner-grow-sm');
            document.querySelector('#chatgptsend').disabled = false;
            document.querySelector('#chat_bot').innerHTML = input.choices[0].message.content;
        } else {
            console.log(data);
        }
    }
}