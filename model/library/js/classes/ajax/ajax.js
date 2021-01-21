/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Ajax requests
 *
 * @package Ajax
 * @author eMarket
 * 
 */
class Ajax {

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
                document.querySelector('#alert_block').innerHTML = '<div id="alert" class="alert text-danger fade in"><span class="glyphicon glyphicon-alert"></span> ' + alert + '</div>';
            }
            if (document.querySelector('.modal')) {
                $('.modal').modal('hide');
                $('.modal').on('hidden.bs.modal', function () {
                    Ajax.getUpdate(url);
                });
            } else {
                Ajax.getUpdate(url);
            }
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
            Ajax.getUpdate(url);
        }
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