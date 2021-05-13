/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global bootstrap, fetch, tinymce, AjaxSuccess */

/**
 * Ajax requests
 *
 * @package Ajax
 * @author eMarket
 * 
 */
class Ajax {

    /**
     * Ajax POST
     *
     * @param url {String} (url)
     * @param data {Obj} (data)
     * @param reload {String} (reload marker)
     * @param relay {String} (relay marker)
     */
    static async postData(url = '', data = {}, reload = null, relay = null) {
        var pref = {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json'
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
            body: JSON.stringify(data)
        };
        if (relay === null) {
            const response = await fetch(url, pref).then(
                    data => {
                        return data.text();
                    }
            ).then(
                    text => {
                        if (reload !== false && typeof AjaxSuccess === 'function') {
                            AjaxSuccess(text);
                        }
                    }
            );
        } else {
            const response = await fetch(url, pref);
            return await response.json();
    }

    }

    /**
     * Add
     *
     * @param name {String} (name)
     * @param url {String} (url)
     * @param alert {String} (alert block)
     */
    static callAdd(name, url, alert) {
        if (document.querySelector('#attributes') !== null) {
            document.querySelector('#attributes').value = sessionStorage.getItem('attributes');
        }
        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
        }
        if (name === undefined || name === null) {
            var msg = document.forms.form_add;
        } else {
            var msg = document.querySelector('#' + name);
        }

        let data = new FormData(msg);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', window.location.href, false);
        xhr.send(data);
        if (xhr.status === 200) {
            if (alert !== undefined && alert !== null) {
                document.querySelector('#alert_block').innerHTML = '<div id="alert" class="alert text-danger fade in bi-alert-triangle"> ' + alert + '</div>';
            }
            Ajax.closeModals(url);

        }
    }

    /**
     * Delete
     *
     * @param id {String} (id)
     * @param url {String} (url)
     */
    static callDelete(id, url) {
        var msg = document.forms['form_delete' + id];

        let data = new FormData(msg);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', window.location.href, false);
        xhr.send(data);
        if (xhr.status === 200) {
            Ajax.closeModals(url);
        }
    }

    /**
     * Close modals
     *
     *@param url {String} (url)
     */
    static closeModals(url) {
        var modals = document.querySelectorAll('.modal');
        modals.forEach(function (modal) {
            if (bootstrap.Modal.getInstance(document.querySelector('#' + modal.id)) !== null) {
                bootstrap.Modal.getInstance(document.querySelector('#' + modal.id)).hide();
                document.querySelector('#' + modal.id).addEventListener('hidden.bs.modal', function () {
                    Ajax.getUpdate(url);
                });
            }
        });
        Ajax.getUpdate(url);
    }

    /**
     * Get update
     *
     * @param url {String} (url)
     */
    static getUpdate(url) {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', window.location.href, false);
        xhr.send();
        if (xhr.status === 200) {
            if (url === undefined || url === null) {
                document.location.href = window.location.href;
            } else {
                document.location.href = url;
            }
        }
    }
}