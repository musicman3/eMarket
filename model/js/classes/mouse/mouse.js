/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Действия мышью
 *
 * @package Mouse
 * @author eMarket
 * 
 */
class Mouse {
    /**
     * Конструктор
     *
     **@param lang {Array} (языковые переменные)
     */
    constructor(lang) {

        this.lang = lang;

        this.start = function (e, ui) {
            let $originals = ui.helper.children();
            ui.placeholder.children().each(function (index) {
                $(this).width($originals.eq(index).width());
            });
        };

        this.helper = function (e, tr) {
            let $helper = tr.clone();
            let $originals = tr.children();
            $helper.children().each(function (index) {
                $(this).width($originals.eq(index).outerWidth(true));
            });
            return $helper;
        };

        Mouse.sortInitAll();
    }

    /**
     * Инициализация сортировки
     * @param id {String} (id)
     * @param items {String} (items)
     * @param handle {String} (handle)
     *
     */
    static sortInit(id, items, handle) {
        $(id).sortable({
            items: items,
            handle: handle,
            axis: "y",
            helper: this.helper,
            start: this.start,
            over: function (event, ui) {
                ui.helper.css("opacity", "0.7"),
                        ui.helper.css("background-color", "#F5F5F5");
            },
            beforeStop: function (event, ui) {
                ui.helper.css("opacity", "1.0"),
                        ui.helper.css("background-color", "");
            },
            stop: function (event, ui) {
                if (id === '#sort-list') {
                    Mouse.sortList();
                }
                if (id === '.group-attributes') {
                    var GroupAttributes = new GroupAttributes(this.lang);
                    GroupAttributes.sort(this.lang);
                }
                if (id === '.attribute') {
                    var Attributes = new Attributes(this.lang);
                    Attributes.sort(this.lang);
                }
                if (id === '.values_attribute') {
                    var ValuesAttribute = new ValuesAttribute(this.lang);
                    ValuesAttribute.sort(this.lang);
                }
            }
        });
    }

    /**
     * Инициализация всего
     *
     */
    static sortInitAll() {
        Mouse.sortInit('#sort-list', 'tr.sort-list', 'td.sortyes');
        if ($('tbody').is('.group-attributes')) {
            Mouse.sortInit('.group-attributes', 'tr.groupattributes', 'td.sortyes-group');
        }
        if ($('tbody').is('.attribute')) {
            Mouse.sortInit('.attribute', 'tr.attributes-class', 'td.sortyes-attributes');
        }
        if ($('tbody').is('.values_attribute')) {
            Mouse.sortInit('.values_attribute', 'tr.value-attributes-class', 'td.sortyes-value-attributes');
        }
        //Выбор мышкой
        $(".option").click(function () {
            $(this).find('span').toggleClass('inactive');
            $(this).toggleClass('active');
        });
    }

    /**
     * Сортировка
     *
     */
    static sortList() {
        var ids = [];
        $("#sort-list tr").each(function () {
            ids[ids.length] = $(this).attr('unitid');
        });

        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.post(window.location.href,
                {ids: ids.join()});
    }
}