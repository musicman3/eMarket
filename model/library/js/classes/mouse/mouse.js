/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
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

        this.lang = lang;
        Mouse.sortInitAll(lang);
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
            onEnd: function () {
                if (id === '#sort-list') {
                    Mouse.sortList();
                }
                if (id === '.group-attributes') {
                    var GroupAttributesObj = new GroupAttributes(lang);
                    GroupAttributesObj.sort(lang, sortable);
                }
                if (id === '.attribute') {
                    var AttributesObj = new Attributes(lang);
                    AttributesObj.sort(lang, sortable);
                }
                if (id === '.values_attribute') {
                    var ValuesAttributeObj = new ValuesAttribute(lang);
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
        if ($('tbody').is('.group-attributes')) {
            Mouse.sortInit('.group-attributes', lang);
        }
        if ($('tbody').is('.attribute')) {
            Mouse.sortInit('.attribute', lang);
        }
        if ($('tbody').is('.values_attribute')) {
            Mouse.sortInit('.values_attribute', lang);
        }

        $('.option').click(function () {
            $(this).find('span').toggleClass('inactive');
            $(this).toggleClass('active');
        });
    }

    /**
     * Sorting
     *
     */
    static sortList() {
        var ids = [];
        $('#sort-list tr').each(function () {
            ids[ids.length] = $(this).attr('unitid');
        });

        jQuery.ajaxSetup({async: false});
        jQuery.post(window.location.href,
                {ids: ids.join()});
    }
}