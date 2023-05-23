/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global Ajax, Randomizer */

/**
 * ChatGPT
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
     * Request
     *
     * @param content {String} (question for ChatGPT assistant)
     */
    static request(content = 'Say this is a test!') {

        var randomizer = new Randomizer();

        var param = encodeURI(JSON.stringify({
            'jsonrpc': '2.0',
            'method': 'ChatGPT',
            'param': [],
            'id': randomizer.uid(32)}));

        Ajax.postData('/services/jsonrpc/?request=' + param,
                {'message': content,
                    'login': document.querySelector('#user_login').dataset.login},
                null, null, ChatGPT.Response).then((data) => {
        });
        document.querySelector('#chatgptsendspan').classList.add('spinner-grow');
        document.querySelector('#chatgptsendspan').classList.add('spinner-grow-sm');
        document.querySelector('#chatgptsend').disabled = true;
    }

    /**
     * API Key request
     *
     * @param content {String} (API key)
     */
    static apiKey(content = '') {

        var randomizer = new Randomizer();

        var param = encodeURI(JSON.stringify({
            'jsonrpc': '2.0',
            'method': 'ChatGPT',
            'param': [],
            'id': randomizer.uid(32)}));

        Ajax.postData('/services/jsonrpc/?request=' + param,
                {'api_key': content,
                    'login': document.querySelector('#user_login').dataset.login},
                null, null, ChatGPT.save).then((data) => {
        });
    }

    /**
     * Save
     *
     * @param data {String} (data)
     */
    static save(data) {
        var input = JSON.parse(data);
        document.querySelector('#chat_bot').value = input[0];
        document.querySelector('#chatgpt_key').value = '';
    }

    /**
     * Init
     *
     */
    static init() {
        document.querySelector('#chatgptsend').onclick = function () {
            ChatGPT.request(document.querySelector('#chat_user').value);
        };

        document.querySelector('#api_key').onclick = function () {
            ChatGPT.apiKey(document.querySelector('#chatgpt_key').value);
        };

        document.querySelector('#chat_user')
                .addEventListener('keyup', function (event) {
                    event.preventDefault();
                    if (event.keyCode === 13) {
                        document.querySelector('#chat_user').blur();
                        document.querySelector('#chat_user').disabled = true;
                        ChatGPT.request(document.querySelector('#chat_user').value);
                    }
                });

        document.querySelector('#offcanvasRight').addEventListener('show.bs.offcanvas', function (event) {
            ChatGPT.removeClass();
            document.querySelector('#chat_user').value = '';
        });

        document.querySelector('#offcanvasRight').addEventListener('shown.bs.offcanvas', function (event) {
            document.querySelector('#chat_user').focus();
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
            document.querySelector('#chat_user').disabled = false;
            document.querySelector('#chat_user').value = '';
            document.querySelector('#chat_user').focus();
        } else {
            document.querySelector('#chat_bot').value = input.error.message;
        }
        ChatGPT.removeClass();
    }
}