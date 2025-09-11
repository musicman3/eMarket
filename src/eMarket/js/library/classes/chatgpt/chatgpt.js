/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global Ajax, Randomizer, JsonRpc */

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
        sessionStorage.setItem('ChatGPT.request.id', randomizer.uid(32));

        var jsonRpcRequest = [
            {
                'jsonrpc': '2.0',
                'method': 'eMarket\\JsonRpc\\ChatGPT',
                'param': {
                    'message': content,
                    'login': document.querySelector('#user_login').dataset.login
                },
                'id': sessionStorage.getItem('ChatGPT.request.id')
            }
        ];

        Ajax.jsonRpcSend(jsonRpcRequest,
                ChatGPT.Response).then((data) => {
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
        sessionStorage.setItem('ChatGPT.apiKey.id', randomizer.uid(32));

        var jsonRpcRequest = [
            {
                'jsonrpc': '2.0',
                'method': 'eMarket\\JsonRpc\\ChatGPT',
                'param': {
                    'api_key': content,
                    'login': document.querySelector('#user_login').dataset.login
                },
                'id': sessionStorage.getItem('ChatGPT.apiKey.id')
            }
        ];

        Ajax.jsonRpcSend(jsonRpcRequest,
                ChatGPT.save).then((data) => {
        });
    }

    /**
     * Save
     *
     * @param data {String} (data)
     */
    static save(data) {
        if (data !== null && data !== undefined) {

            var input = JSON.parse(data);
            input = JsonRpc.jsonRpcSelect(input, sessionStorage.getItem('ChatGPT.apiKey.id'));

            document.querySelector('#chat_bot').value = input.result[0];
            document.querySelector('#chatgpt_key').value = '';
        }
    }

    /**
     * Init
     *
     */
    static init() {

        if (document.querySelector('#api_key') !== null) {
            document.querySelector('#api_key').onclick = function () {
                ChatGPT.apiKey(document.querySelector('#chatgpt_key').value);
            };
        }

        document.querySelector('#chatgptsend').onclick = function () {
            document.querySelector('#chat_bot').innerHTML += '<div class="text-secondary bi-person-fill">: ' + document.querySelector('#chat_user').value + '<div>';
            ChatGPT.request(document.querySelector('#chat_user').value);
            if (document.querySelector('#chat_empty')) {
                document.querySelector('#chat_empty').remove();
            }
        };

        document.querySelector('#chat_user')
                .addEventListener('keyup', function (event) {
                    event.preventDefault();
                    if (event.keyCode === 13) {
                        document.querySelector('#chat_user').blur();
                        document.querySelector('#chat_user').disabled = true;
                        document.querySelector('#chat_bot').innerHTML += '<div class="text-secondary bi-person-fill">: ' + document.querySelector('#chat_user').value + '</div>';
                        ChatGPT.request(document.querySelector('#chat_user').value);
                        if (document.querySelector('#chat_empty')) {
                            document.querySelector('#chat_empty').remove();
                        }
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
        if (data !== null && data !== undefined) {

            var input = JSON.parse(data);
            input = JsonRpc.jsonRpcSelect(input, sessionStorage.getItem('ChatGPT.request.id'));

            if (input !== undefined && input.result[0].choices !== undefined && input.result[0].choices[0] !== undefined) {
                document.querySelector('#chat_bot').innerHTML += '<div class="text-success bi-chat-left-text">: ' + input.result[0].choices[0].message.content + '</div>';
                document.querySelector('#chat_user').disabled = false;
                document.querySelector('#chat_user').value = '';
                document.querySelector('#chat_user').focus();
            } else {
                document.querySelector('#chat_bot').innerHTML = '<div class="text-danger bi-exclamation-triangle-fill">: ' + input.result[0].error.message + '</div>';
            }
            ChatGPT.removeClass();
        }
    }
}