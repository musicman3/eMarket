/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* global Ajax, ss, bootstrap */
/**
 * Basic Settings
 *
 * @package BasicSettings
 * @author eMarket
 * 
 */
class BasicSettings {
    /**
     * Constructor
     *
     */
    constructor() {
        this.change();

        document.querySelector('#fileupload').onmouseover = function (event) {
            BasicSettings.process('fileupload', 'uploadfile', '/uploads/temp/?route=uploads');
            document.getElementsByName('uploadfile').forEach(e => e.parentElement.remove());
        };

        document.querySelector('#fileupload-product').onmouseover = function (event) {
            BasicSettings.process('fileupload-product', 'uploadfile-product', '/uploads/temp/?route=product');
            document.getElementsByName('uploadfile-product').forEach(e => e.parentElement.remove());
        };

    }

    /**
     * Change
     * 
     */
    change() {
        var smtp_status = document.querySelector('#smtp_status');
        if (smtp_status.options.selectedIndex === 0) {
            BasicSettings.disableInput();
        }

        smtp_status.addEventListener('change', function (event) {
            if (smtp_status.options.selectedIndex === 0) {
                BasicSettings.disableInput();
            } else {
                document.querySelector('#smtp_auth').removeAttribute('disabled');
                document.querySelector('#host_email').removeAttribute('disabled');
                document.querySelector('#username_email').removeAttribute('disabled');
                document.querySelector('#password_email').removeAttribute('disabled');
                document.querySelector('#smtp_secure').removeAttribute('disabled');
                document.querySelector('#smtp_port').removeAttribute('disabled');
            }
        });
    }

    /**
     * Disable Input
     * 
     */
    static disableInput() {
        document.querySelector('#smtp_auth').setAttribute('disabled', 'disabled');
        document.querySelector('#host_email').setAttribute('disabled', 'disabled');
        document.querySelector('#username_email').setAttribute('disabled', 'disabled');
        document.querySelector('#password_email').setAttribute('disabled', 'disabled');
        document.querySelector('#smtp_secure').setAttribute('disabled', 'disabled');
        document.querySelector('#smtp_port').setAttribute('disabled', 'disabled');
    }

    /**
     * Loading new images into "Edit & Add" modal
     *
     *@param button {String} (button id)
     *@param name {String} (name)
     *@param url {String} (url)
     */
    static process(button, name, url) {
        'use strict';

        var uploader = new ss.SimpleUpload({
            button: button,
            url: url,
            responseType: 'json',
            name: name,
            multiple: false,
            multipleSelect: false,
            allowedExtensions: ['png'],
            accept: 'image/png',
            onSubmit: function (filename, extension) {
                document.querySelector('#alert_messages').innerHTML = '';
            },
            onProgress: function (pct) {
                var progress_bar = document.querySelectorAll('.progress-bar');
                progress_bar.forEach(e => e.style.width = pct + '%');
                progress_bar.forEach(e => e.innerHTML = '');
                progress_bar.forEach(e => e.classList.remove('bg-success'));
                progress_bar.forEach(e => e.classList.add('bg-danger', 'progress-bar-striped', 'progress-bar-animated'));

                if (pct === 100) {
                    setTimeout(function () {
                        progress_bar.forEach(e => e.innerHTML = '100%');
                        progress_bar.forEach(e => e.classList.remove('bg-danger', 'progress-bar-striped', 'progress-bar-animated'));
                        progress_bar.forEach(e => e.classList.add('bg-success'));
                    }, 1000);
                }
            },
            onComplete: function (filename, response) {
                if (!response) {
                    alert(filename + 'upload failed');
                    return false;
                }

                Ajax.postData(window.location.href, {
                    image_data: filename,
                    logo_for: button
                }).then((data) => {
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 1500);
                });
            }
        });
    }

}