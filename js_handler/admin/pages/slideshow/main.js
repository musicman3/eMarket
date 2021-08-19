/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* global Fileupload */

/**
 * Slideshow
 *
 * @package Slideshow
 * @author eMarket
 * 
 */
class Slideshow {
    /**
     * Constructor
     *
     */
    constructor() {
        this.settings();
        this.tabs();
        this.modalShow();
    }

    /**
     * Settings
     * 
     */
    settings() {
        document.querySelector('#settings').addEventListener('show.bs.modal', function (event) {
            var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsonsettings);
            document.querySelector('#show_interval').value = json_data.show_interval;
            document.querySelector('#mouse_stop').checked = Number(json_data.mouse_stop);
            document.querySelector('#autostart').checked = Number(json_data.autostart);
            document.querySelector('#cicles').checked = Number(json_data.cicles);
            document.querySelector('#indicators').checked = Number(json_data.indicators);
            document.querySelector('#navigation').checked = Number(json_data.navigation);
        });
    }

    /**
     * Tabs
     * 
     */
    tabs() {
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function (tab) {
            tab.addEventListener('shown.bs.tab', function (e) {
                var tab = e.target['hash'].slice(1);
                document.querySelector('#set_language').value = tab;
                window.history.pushState(null, null, "?route=slideshow&slide_lang=" + tab);

                let xhr = new XMLHttpRequest();
                xhr.open('GET', window.location.href, false);
                xhr.send({slide_lang: tab});
                if (xhr.status === 200) {
                    var data = xhr.response;
                    var dataXHR = document.createElement('div');
                    dataXHR.innerHTML = data;
                    document.querySelector('#csrf_token').replaceWith(dataXHR.querySelector('#csrf_token'));
                    document.querySelector('.ajax-tab').replaceWith(dataXHR.querySelector('.ajax-tab'));
                    document.querySelector('#ajax_data').replaceWith(dataXHR.querySelector('#ajax_data'));
                }
            });
        });
    }

    /**
     * Modal show
     * 
     */
    modalShow() {
        document.querySelector('#index').addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var modal_id = Number(button.dataset.edit);
            if (Number.isInteger(modal_id)) {
                var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsondata);

                document.querySelector('#edit').value = modal_id;
                document.querySelector('#add').value = '';

                document.querySelector('#view_slideshow').checked = json_data.status[modal_id];
                document.querySelector('#animation').checked = json_data.animation[modal_id];

                document.querySelector('#color').value = json_data.color[modal_id];
                document.querySelector('#url').value = json_data.url[modal_id];
                document.querySelector('#name').value = json_data.name[modal_id];
                document.querySelector('#heading').value = json_data.heading[modal_id];

                var start = json_data.date_start[modal_id];
                var end = json_data.date_finish[modal_id];
                new SmartDatepicker(start, end);

                Fileupload.getImageToEdit(json_data.logo_general, json_data.logo, modal_id, 'slideshow');
            }

            if (!Number.isInteger(modal_id) && button.dataset.bsToggle === 'modal') {
                document.querySelector('#edit').value = '';
                document.querySelector('#add').value = 'ok';
                document.querySelectorAll('form').forEach(e => e.reset());
                new SmartDatepicker();
            }
        });
    }
}