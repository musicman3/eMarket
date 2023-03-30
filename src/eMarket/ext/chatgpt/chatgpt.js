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
     * Constructor
     *
     */
    constructor() {
        ChatGPT.init();
    }

    /**
     * ChatGPT POST request
     *
     * @param url {String} (url)
     * @param data {Obj} (data)
     * @param func {Object} (function)
     * @returns {Object|Void} (return data)
     */
    static async request(url = '', data = {}, func = null) {

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
    static chat(content = 'Say this is a test!') {

        var randomizer = new Randomizer();

        var param = encodeURI(JSON.stringify({
            'jsonrpc': '2.0',
            'method': 'ChatGPT',
            'param': [],
            'id': randomizer.uid(32)}));

        ChatGPT.request('/services/jsonrpc/?request=' + param,
                {'message': content,
                    'login': document.querySelector('#user_login').dataset.login},
                ChatGPT.Response).then((data) => {
        });
        document.querySelector('#chatgptsendspan').classList.add('spinner-grow');
        document.querySelector('#chatgptsendspan').classList.add('spinner-grow-sm');
        document.querySelector('#chatgptsend').disabled = true;

    }

    /**
     * Init
     *
     */
    static init() {

        document.querySelector('#chatgptsend').onclick = function () {
            ChatGPT.chat(document.querySelector('#chat_user').value);
        };

        document.querySelector('#offcanvasRight').addEventListener('show.bs.offcanvas', function (event) {
            ChatGPT.removeClass();
            document.querySelector('#chatgptsend').disabled = false;
            document.querySelector('#chat_user').value = '';
            document.querySelector('#chat_bot').value = '';
        });
    }

    /**
     * Remove Class for send button
     *
     */
    static removeClass() {
        document.querySelector('#chatgptsendspan').classList.remove('spinner-grow');
        document.querySelector('#chatgptsendspan').classList.remove('spinner-grow-sm');
        document.querySelector('#chatgptsend').disabled = false;
    }

    /**
     * Response
     *
     * @param data {Object} (ChatGPT response)
     */
    static Response(data) {
        var input = JSON.parse(data);
        if (input !== undefined && input.choices !== undefined) {
            document.querySelector('#chat_bot').value = input.choices[0].message.content;
        } else {
            console.log(data);
        }
        ChatGPT.removeClass();
    }
}