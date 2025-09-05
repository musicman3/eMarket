/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/**
 * JsonRpc
 *
 * @package JsonRpc
 * @author eMarket
 * 
 */
class JsonRpc {

    /**
     * jsonRpc select
     *
     * @param input {Object} (input data)
     * @param id {String} (id)
     * @returns {Object}
     */
    static jsonRpcSelect(input, id) {
        for (var x = 0; x < input.length; x++) {
            if (input[x]['id'] === id) {
                var input = input[x];
            }
        }
        return input;
    }
}