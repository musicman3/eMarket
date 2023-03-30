/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* global tinymce, moment */

/**
 * Stock
 *
 * @package Stock
 * @author eMarket
 * 
 */
class Stock {
    /**
     * Constructor
     *
     * @param {string} resize_max
     * @param {string} lang
     * @param {string} resize_max_prod
     */
    constructor(resize_max, lang, resize_max_prod) {
        this.init(resize_max, lang, resize_max_prod);
        this.mousedown();
        this.tinymceInit();
        this.focusin();
    }

    /**
     * Init
     * @param {string} resize_max
     * @param {string} lang
     * @param {string} resize_max_prod
     */
    init(resize_max, lang, resize_max_prod) {
        new Fileupload(resize_max, lang);
        new FileuploadProduct(resize_max_prod, lang);
        new Ajax();
        new Mouse(lang);
        new GroupAttributes(lang);
        new Attributes(lang);
        new ValuesAttribute(lang);

        new TableSelect(document.querySelector('#table-id'), {
            selectedClassName: 'table-primary',
            shouldSelectRow(row) {
                return !row.classList.contains('unselectable');
            }
        });
    }

    /**
     * Mousedown
     * 
     */
    mousedown() {
        document.querySelector('#table-id').addEventListener('mousedown', function (event) {
            if (event.ctrlKey) {
                event.preventDefault();
            }
        });
    }

    /**
     * Tinymce init
     * 
     */
    tinymceInit() {
        tinymce.init({
            selector: '.wysiwyg',
            plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media table charmap hr toc advlist lists imagetools wordcount textpattern noneditable help charmap quickbars emoticons',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            autosave_interval: '30s',
            autosave_prefix: '{path}{query}-{id}-',
            autosave_restore_when_empty: false,
            autosave_retention: '2m',
            image_advtab: true,
            toolbar_mode: 'sliding',
            contextmenu: 'link image imagetools table',
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            language: document.documentElement.lang
        });
    }

    /**
     * Tinymce focusin
     * 
     */
    focusin() {
        document.addEventListener('focusin', function (e) {
            if (e.target.closest('.tox-tinymce-aux, .moxman-window, .tam-assetmanager-root') !== null) {
                e.stopImmediatePropagation();
            }
        });
    }

    /**
     * Pikaday
     * 
     * @return {Object} Picker
     */
    static pikaday() {
        moment.locale(document.documentElement.lang);
        var months = moment.months();
        var weekdays = moment.weekdays();
        var weekdays_min = moment.weekdaysMin();
        var picker = new Pikaday({
            field: document.querySelector('#date_available_product_stock'),
            position: 'top left',
            minDate: new Date(),
            toString(date, format) {
                return moment(date).format('L');
            },
            i18n: {
                months: [months[0], months[1], months[2], months[3], months[4], months[5], months[6], months[7], months[8], months[9], months[10], months[11]],
                weekdays: [weekdays[0], weekdays[1], weekdays[2], weekdays[3], weekdays[4], weekdays[5], weekdays[6]],
                weekdaysShort: [weekdays_min[0], weekdays_min[1], weekdays_min[2], weekdays_min[3], weekdays_min[4], weekdays_min[5], weekdays_min[6]]
            }
        });

        return picker;
    }
}