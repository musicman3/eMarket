/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* global Ajax, bootstrap, config_confirm, confirmation, config_input */

/**
 * Templates
 *
 * @package Templates
 * @author eMarket
 * 
 */
class Templates {
    /**
     * Constructor
     *
     */
    constructor() {
        Templates.sortablePref('#sortable1', 'header');
        Templates.sortablePref('#sortable2', 'header');
        Templates.sortablePref('#sortable3', 'content');
        Templates.sortablePref('#sortable4', 'content');
        Templates.sortablePref('#sortable5', 'boxes');
        Templates.sortablePref('#sortable6', 'boxes');
        Templates.sortablePref('#sortable7', 'boxes');
        Templates.sortablePref('#sortable8', 'footer');
        Templates.sortablePref('#sortable9', 'footer');
        this.init();
    }

    /**
     * Init
     * 
     */
    init() {
        document.querySelector('#name_templates').addEventListener('change', (e) => {
            document.forms['select_template'].submit();
        });
        document.querySelector('#layout_pages_templates').addEventListener('change', (e) => {
            document.forms['select_page'].submit();
        });
        document.querySelector('#save_config').addEventListener('click', (e) => {
            this.saveConfig();
        });
        document.querySelector('#delete_config').addEventListener('click', (e) => {
            this.deleteConfig();
        });
        document.querySelector('#set_config').addEventListener('click', (e) => {
            this.setConfig();
        });
    }

    /**
     * Save config
     * 
     */
    saveConfig() {
        config_input.oninput = function () {
            let str = document.querySelector('#config_input').value;

            let res = str.replace(' ', "_");
            res = res.replace('{', "_");
            res = res.replace('}', "_");
            res = res.replace('$', "_");
            res = res.replace('*', "_");
            res = res.replace('#', "_");
            res = res.replace('`', "_");
            res = res.replace('[', "_");
            res = res.replace(']', "_");
            res = res.replace('/', "_");
            res = res.replace('.', "_");
            res = res.replace(',', "_");
            res = res.replace(':', "_");
            res = res.replace(';', "_");
            res = res.replace('^', "_");
            res = res.replace('%', "_");
            res = res.replace('(', "_");
            res = res.replace(')', "_");
            res = res.replace('&', "_");
            res = res.replace('@', "_");
            res = res.replace('!', "_");
            res = res.replace('=', "_");
            res = res.replace('+', "_");
            res = res.replace('?', "_");
            res = res.replace('№', "_");

            document.querySelector('#config_input').value = res;
        };

        new bootstrap.Modal(document.querySelector('#config_name')).show();
        config_confirm.onclick = function () {
            bootstrap.Modal.getInstance(document.querySelector('#config_name')).hide();
            Ajax.postData(window.location.href, {
                save_config: 'ok',
                template_name: document.querySelector('#name_templates').value,
                config_input: document.querySelector('#config_input').value
            }, null, null, Templates.AjaxSuccess);
        };
    }

    /**
     * Delete config
     * 
     */
    deleteConfig() {
        new bootstrap.Modal(document.querySelector('#confirm')).show();
        confirmation.onclick = function () {
            bootstrap.Modal.getInstance(document.querySelector('#confirm')).hide();
            Ajax.postData(window.location.href, {
                delete_config: 'ok',
                config_name: document.querySelector('#config_list').value
            }, null, null, Templates.AjaxSuccess);
        };
    }

    /**
     * Set config
     * 
     */
    setConfig() {
        Ajax.postData(window.location.href, {
            set_config: 'ok',
            config_name: document.querySelector('#config_list').value
        }, null, null, Templates.AjaxSuccess);
    }

    /**
     * Ajax Success
     *
     *@param data {Object} (ajax data)
     */
    static AjaxSuccess(data) {
        setTimeout(function () {
            location.reload();
        }, 100);
    }

    /**
     * idHandler
     *
     * @param selector {String} (selector)
     * @return idArray {Array} (id Array)
     */
    static idHandler(selector) {
        var idArray = [];
        var data = Array.from(document.querySelector(selector).children);
        data.splice(0, 1);
        data.forEach(function (string, index) {
            if (string.id !== '') {
                idArray[index] = string.id;
            }
        });
        return idArray;
    }

    /**
     * update Data
     *
     */
    static updateData() {
        Ajax.postData(window.location.href, {
            layout_header: Templates.idHandler('#sortable1'),
            layout_header_basket: Templates.idHandler('#sortable2'),
            layout_content: Templates.idHandler('#sortable3'),
            layout_content_basket: Templates.idHandler('#sortable4'),
            layout_boxes_left: Templates.idHandler('#sortable5'),
            layout_boxes_right: Templates.idHandler('#sortable6'),
            layout_boxes_basket: Templates.idHandler('#sortable7'),
            layout_footer: Templates.idHandler('#sortable8'),
            layout_footer_basket: Templates.idHandler('#sortable9'),
            template: document.querySelector('#name_templates').value,
            page: document.querySelector('#layout_pages_templates').value
        });
    }

    /**
     * Sortable pref
     *
     * @param selector {String} (selector)
     * @param group {String} (group)
     */
    static sortablePref(selector, group) {
        new Sortable(document.querySelector(selector), {
            group: group,
            animation: 150,
            filter: '.sortno',
            ghostClass: 'bg-info',
            draggable: '.sortyes',
            onEnd: function () {
                Templates.updateData();
            }
        });
    }
}