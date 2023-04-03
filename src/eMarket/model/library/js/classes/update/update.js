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
        
        if (document.querySelector('#user_login').dataset.login !== 'false') {
            Ajax.postData('/services/jsonrpc/?request=' + param,
                    {'login': document.querySelector('#user_login').dataset.login},
                    null, null, Update.Response).then((data) => {
            });
        }
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
     * @param data {Object} (ChatGPT response)
     */
    static Response(data) {
        var input = JSON.parse(data);

        const tooltip = bootstrap.Tooltip.getInstance('#update_box');
        tooltip.setContent({'.tooltip-inner': input.message});

        var text_class = 'text-success';

        if (input.status === 'false') {
            text_class = 'text-warning';
        }
        document.querySelector('#update_box').classList.replace('text-secondary', text_class);
    }
}