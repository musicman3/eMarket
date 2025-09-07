/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* global tail, define */

/**
 * Zones listing
 *
 * @package ZonesListing
 * @author eMarket
 * 
 */
class ZonesListing {
    /**
     * Constructor
     *
     * @param lang {Object} (lang)
     */
    constructor(lang) {
        this.multiselect();
        this.tail(lang);
    }

    /**
     * Modal show
     * 
     */
    multiselect() {
        document.addEventListener('DOMContentLoaded', function () {
            tail.select(document.querySelector('#multiselect'), {
                search: true,
                multiSelectAll: true,
                height: 600,
                width: 450,
                animate: false
            });
        });
    }

    /**
     * Tail
     * 
     * @param lang {Object} (lang)
     */
    tail(lang) {
        (function (factory) {
            if (typeof (define) === 'function' && define.amd) {
                define(function () {
                    return function (select) {
                        factory(select);
                    };
                });
            } else {
                if (typeof (window.tail) !== 'undefined' && window.tail.select) {
                    factory(window.tail.select);
                }
            }
        }(function (select) {
            select.strings.register('en', {
                all: lang.select_all,
                none: lang.cancel,
                actionAll: lang.select_all,
                empty: lang.no_listing,
                placeholder: lang.select_country_and_region,
                search: lang.search
            });
            return select;
        }));
    }
}