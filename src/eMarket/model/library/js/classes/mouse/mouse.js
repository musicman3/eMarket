/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global AjaxSuccess, Ajax */

/**
 * Mouse actions
 *
 * @package Mouse
 * @author eMarket
 * 
 */
class Mouse {
    /**
     * Constructor
     *
     **@param lang {Array} (language)
     */
    constructor(lang) {
        if (lang !== undefined) {
            this.lang = lang;
            Mouse.sortInitAll(lang);
        }
    }

    /**
     * Sort init
     * @param id {String} (id)
     * @param lang {Array} (language)
     *
     */
    static sortInit(id, lang) {
        var sortable = new Sortable(document.querySelector(id), {
            animation: 150,
            ghostClass: 'table-primary',
            handle: '.sortyes',
            onEnd: function () {
                if (id === '#sort-list') {
                    Mouse.sortList();
                }
                if (id === '.group-attributes') {
                    var GroupAttributesObj = new GroupAttributes();
                    GroupAttributesObj.sort(lang, sortable);
                }
                if (id === '.attribute') {
                    var AttributesObj = new Attributes();
                    AttributesObj.sort(lang, sortable);
                }
                if (id === '.values_attribute') {
                    var ValuesAttributeObj = new ValuesAttribute();
                    ValuesAttributeObj.sort(lang, sortable);
                }
            }
        });
    }

    /**
     * Init all
     * @param lang {Array} (language)
     *
     */
    static sortInitAll(lang) {
        Mouse.sortInit('#sort-list', lang);

        if (document.querySelector('.group-attributes') !== null) {
            Mouse.sortInit('.group-attributes', lang);
        }
        if (document.querySelector('.attribute') !== null) {
            Mouse.sortInit('.attribute', lang);
        }
        if (document.querySelector('.values_attribute') !== null) {
            Mouse.sortInit('.values_attribute', lang);
        }
    }

    /**
     * Sorting
     *
     */
    static sortList() {
        var ids = [];
        document.querySelectorAll('#sort-list tr').forEach(function (string, index) {
            ids[index] = string.getAttribute('unitid');
        });

        Ajax.postData(window.location.href, {
            ids: ids.join()
        }, false);

    }
}