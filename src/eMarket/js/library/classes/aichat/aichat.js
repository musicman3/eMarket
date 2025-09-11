/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global Ajax, Randomizer, JsonRpc */

/**
 * AiChat
 *
 * @package AiChat
 * @author eMarket
 * 
 */
class AiChat {

    /**
     * Constructor
     *
     */
    constructor() {
        AiChat.init();
    }

    /**
     * Request
     *
     * @param content {String} (question for AiChat assistant)
     */
    static request(content = 'Say this is a test!') {

        var randomizer = new Randomizer();
        sessionStorage.setItem('AiChat.request.id', randomizer.uid(32));

        var jsonRpcRequest = [
            {
                'jsonrpc': '2.0',
                'method': 'eMarket\\JsonRpc\\AiChat',
                'param': {
                    'message': content,
                    'login': document.querySelector('#user_login').dataset.login
                },
                'id': sessionStorage.getItem('AiChat.request.id')
            }
        ];

        Ajax.jsonRpcSend(jsonRpcRequest,
                AiChat.Response).then((data) => {
        });
        document.querySelector('#aichatsendspan').classList.add('spinner-grow');
        document.querySelector('#aichatsendspan').classList.add('spinner-grow-sm');
        document.querySelector('#aichatsend').disabled = true;
    }

    /**
     * API Key request
     *
     * @param content {String} (API key)
     */
    static apiKey(content = '') {

        var randomizer = new Randomizer();
        sessionStorage.setItem('AiChat.apiKey.id', randomizer.uid(32));

        var jsonRpcRequest = [
            {
                'jsonrpc': '2.0',
                'method': 'eMarket\\JsonRpc\\AiChat',
                'param': {
                    'api_key': content,
                    'login': document.querySelector('#user_login').dataset.login
                },
                'id': sessionStorage.getItem('AiChat.apiKey.id')
            }
        ];

        Ajax.jsonRpcSend(jsonRpcRequest,
                AiChat.save).then((data) => {
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
            input = JsonRpc.jsonRpcSelect(input, sessionStorage.getItem('AiChat.apiKey.id'));

            document.querySelector('#chat_bot').innerHTML = '<div class="text-danger bi-exclamation-triangle-fill">: ' + input.result[0] + '</div>';
            document.querySelector('#aichat_key').value = '';
        }
    }

    /**
     * Init
     *
     */
    static init() {

        if (document.querySelector('#api_key') !== null) {
            document.querySelector('#api_key').onclick = function () {
                AiChat.apiKey(document.querySelector('#aichat_key').value);
                if (document.querySelector('#chat_empty')) {
                document.querySelector('#chat_empty').remove();
            }
            };
        }

        document.querySelector('#aichatsend').onclick = function () {
            document.querySelector('#chat_bot').innerHTML += '<div class="text-secondary bi-person-fill">: ' + document.querySelector('#chat_user').value + '<div>';
            AiChat.request(document.querySelector('#chat_user').value);
            if (document.querySelector('#chat_empty')) {
                document.querySelector('#chat_empty').remove();
            }
        };

        document.querySelector('#chatgpt-outlined').onclick = function () {
            AiChat.AiChatName('ChatGPT');
        };

        document.querySelector('#deepseek-outlined').onclick = function () {
            AiChat.AiChatName('DeepSeek');
        };

        document.querySelector('#chat_user')
                .addEventListener('keyup', function (event) {
                    event.preventDefault();
                    if (event.keyCode === 13) {
                        document.querySelector('#chat_user').blur();
                        document.querySelector('#chat_user').disabled = true;
                        document.querySelector('#chat_bot').innerHTML += '<div class="text-secondary bi-person-fill">: ' + document.querySelector('#chat_user').value + '</div>';
                        AiChat.request(document.querySelector('#chat_user').value);
                        if (document.querySelector('#chat_empty')) {
                            document.querySelector('#chat_empty').remove();
                        }
                    }
                });

        document.querySelector('#offcanvasRight').addEventListener('show.bs.offcanvas', function (event) {
            AiChat.removeClass();
            document.querySelector('#chat_user').value = '';
        });

        document.querySelector('#offcanvasRight').addEventListener('shown.bs.offcanvas', function (event) {
            document.querySelector('#chat_user').focus();
        });

    }

    /**
     * AiChat name send
     *
     * @param name {String} (AiChat name)
     */
    static AiChatName(name) {
        var jsonRpcRequest = [
            {
                'jsonrpc': '2.0',
                'method': 'eMarket\\JsonRpc\\AiChat',
                'param': {
                    'aichat_name': name,
                    'login': document.querySelector('#user_login').dataset.login
                },
                'id': sessionStorage.getItem('AiChat.request.id')
            }
        ];

        Ajax.jsonRpcSend(jsonRpcRequest,
                AiChat.Response).then((data) => {
        });
    }

    /**
     * Remove Class for send button
     *
     */
    static removeClass() {
        document.querySelector('#aichatsendspan').classList.remove('spinner-grow');
        document.querySelector('#aichatsendspan').classList.remove('spinner-grow-sm');
        document.querySelector('#aichatsend').disabled = false;
    }

    /**
     * Response
     *
     * @param data {Object} (AiChat response)
     */
    static Response(data) {
        if (data !== null && data !== undefined) {

            var input = JSON.parse(data);
            input = JsonRpc.jsonRpcSelect(input, sessionStorage.getItem('AiChat.request.id'));

            if (input !== undefined && input.result[0].choices !== undefined && input.result[0].choices[0] !== undefined) {
                document.querySelector('#chat_bot').innerHTML += '<div class="text-success bi-chat-left-text">: ' + input.result[0].choices[0].message.content + '</div>';
                document.querySelector('#chat_user').disabled = false;
                document.querySelector('#chat_user').value = '';
                document.querySelector('#chat_user').focus();
            } else {
                document.querySelector('#chat_bot').innerHTML = '<div class="text-danger bi-exclamation-triangle-fill">: ' + input.result[0].error.message + '</div>';
            }
            AiChat.removeClass();
        }
    }
}