/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* global Ajax, tinymce, bootstrap */

/**
 * Contacts
 *
 * @package Stock
 * @author eMarket
 * 
 */
class Contacts {

    /**
     * Constructor
     *
     */
    constructor() {
            this.init();
    }

    /**
     * Init
     * 
     * * @param action {String} (action)
     */
    init(action) {
        var lang = JSON.parse(document.querySelector('#ajax_data').dataset.lang);
        this.tinymceInit(lang);

    }

    /**
     * Tinymce init
     * 
     * @param lang {Array} (language)
     */
    tinymceInit(lang) {
        tinymce.init({
            selector: '.wysiwyg',
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media table charmap advlist lists wordcount help charmap quickbars emoticons',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
            quickbars_insert_toolbar: 'image quicktable',
            toolbar_sticky: true,
            image_class_list: [
                {title: lang['tinymce_thumbnail'], value: 'img-thumbnail img-fluid mb-3'},
                {title: lang['tinymce_rounded'], value: 'rounded img-fluid mb-3'}
            ],
            table_class_list: [
                {title: lang['tinymce_table'], value: 'table align-middle'},
                {title: lang['tinymce_none'], value: ''}
            ],
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
            language: document.documentElement.lang,
            promotion: false,
            license_key: 'gpl'
        });
    }
}