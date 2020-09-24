/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Символьные генераторы
 *
 * @package Randomizer
 * @author eMarket
 * 
 */
class Randomizer {

    /**
     * Random generator uid (генератор случайной строки)
     * @author Waruyama
     * @param length {String} (количество символов)
     * @returns id {String}
     */

    uid(length) {
        var id = '';
        var rdm62;
        while (length--) {
            // Generate random integer between 0 and 61, 0|x works for Math.floor(x) in this case 
            rdm62 = 0 | Math.random() * 62;
            // Map to ascii codes: 0-9 to 48-57 (0-9), 10-35 to 65-90 (A-Z), 36-61 to 97-122 (a-z)
            id += String.fromCharCode(rdm62 + (rdm62 < 10 ? 48 : rdm62 < 36 ? 55 : 61));
        }
        return id;
    }

    /**
     * UUID 4 generator (генератор UUID 4 RFC 4122)
     * @author Robert Kieffer http://www.broofa.com
     * @returns id {String}
     */

    uuid4() {
        return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
            (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16));
    }
}