/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global Ajax, Randomizer */

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
     * Init
     *
     */
    static init() {
        document.querySelector('#chatgptsend').onclick = function () {
            ChatGPT.chat(document.querySelector('#chat_user').value);
        };

        document.querySelector('#chat_user')
                .addEventListener('keyup', function (event) {
                    event.preventDefault();
                    if (event.keyCode === 13) {
                        document.querySelector('#chat_user').blur();
                        document.querySelector('#chat_user').disabled = true;
                        ChatGPT.chat(document.querySelector('#chat_user').value);
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
            console.log(data);
        }
        ChatGPT.removeClass();
    }
}