/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* global Ajax, tinymce, bootstrap, Fileupload */

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
     */
    init() {
        
        document.querySelector('#fileupload').onmouseover = function (event) {
            document.getElementsByName('uploadfile').forEach(e => e.parentElement.remove());
        };
        
        var lang = JSON.parse(document.querySelector('#ajax_data').dataset.lang);
        var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsondata);
        this.tinymceInit(lang);

        if (json_data.logo_general === null || json_data.length === 0) {
            document.querySelector('#edit').value = '';
            document.querySelector('#add').value = 'ok';
        } else {
            Contacts.getImageToEdit(json_data.logo_general, JSON.parse(json_data.logo), 'contacts');
            document.querySelector('#edit').value = '1';
            document.querySelector('#add').value = '';
        }
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
            link_class_list: [
                {title: lang['tinymce_litebox'], value: 'gallery'},
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

    /**
     * Loading images into "Edit" modal window
     * @param logo_general_edit {String} (general logo)
     * @param logo_edit {Array} (images array)
     * @param dir {String} (dir)
     */
    static getImageToEdit(logo_general_edit, logo_edit, dir) {
        for (var x = 0; x < logo_edit.length; x++) {
            var image = logo_edit[x];

            document.querySelector('#logo').insertAdjacentHTML('beforeend', '<div class="file-upload position-relative" id="image_edit_' + x + '"/><img src="/uploads/images/' + dir + '/resize_0/' + image + '" class="img-thumbnail" id="general_' + x + '" /><div class="block align-items-center justify-content-evenly"><button class="btn btn-primary btn-sm bi-trash" type="button" name="delete_image_' + x + '" onclick="Fileupload.deleteImageEdit(\'' + image + '\', \'' + x + '\')"></button> <button class="btn btn-primary btn-sm bi-star" type="button" name="image_general_edit' + x + '" onclick="Fileupload.imageGeneralEdit(\'' + image + '\', \'' + x + '\')"></button> <button class="btn btn-primary btn-sm clipboard bi-clipboard" type="button" id="image_clipboard_edit' + x + '" onclick="Contacts.imageClipboard(\'' + image + '\', \'' + dir + '\', \'' + x + '\')"></button></div></div></div>');
            if (logo_general_edit === image) {
                document.querySelector('#general_' + x).classList.add('border-danger');
            }
        }
    }

    /** 
     * Image Clipboard
     * @param image {String} (image) 
     * @param dir {String} (dir)
     * @param id {String} (id)
     * */
    static imageClipboard(image, dir, id) {
        document.querySelectorAll('.clipboard').forEach(e => e.classList.replace('bi-clipboard-check', 'bi-clipboard'));
        document.querySelector('#image_clipboard_edit' + id).classList.replace('bi-clipboard', 'bi-clipboard-check');
        var url = '/uploads/images/' + dir + '/resize_2/' + image;
        navigator.clipboard.writeText(url);
    }
}