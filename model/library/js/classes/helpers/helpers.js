/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Helpers
 *
 * @package Helpers
 * @author eMarket
 * 
 */
class Helpers {

    /**
     * Native on
     *
     *@param eSel {String} (parent selector)
     *@param eName {String} (event name)
     *@param selector {String} (search selector)
     *@param fn {Func} (Func)
     */
    static on(eSel, eName, selector, fn) {
        var element = document.querySelector(eSel);

        element.addEventListener(eName, function (event) {
            var targ = element.querySelectorAll(selector);
            var target = event.target;

            for (var i = 0, l = targ.length; i < l; i++) {
                var el = target;
                var p = targ[i];

                while (el && el !== element) {
                    if (el === p) {
                        return fn.call(p, event);
                    }

                    el = el.parentNode;
                }
            }
        });
    }

}