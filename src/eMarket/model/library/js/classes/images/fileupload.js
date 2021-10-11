/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global Ajax, ss */

/**
 *  Fileupload
 *
 * @package Fileupload
 * @author eMarket
 * 
 */
class Fileupload {
    /**
     * Constructor
     *
     *@param resize_max {Array} (max resize)
     *@param lang {Array} (language)
     */
    constructor(resize_max, lang) {
        Fileupload.init();
        Fileupload.process(resize_max, lang);
    }

    /**
     * Loading new images into "Edit & Add" modal
     *
     *@param resize_max {Array} (max resize)
     *@param lang {Array} (language)
     */
    static process(resize_max, lang) {
        'use strict';
        var url = '/uploads/temp/';

        var uploader = new ss.SimpleUpload({
            button: 'fileupload',
            url: url,
            responseType: 'json',
            name: 'uploadfile',
            multiple: true,
            multipleSelect: true,
            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
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
                        progress_bar.forEach(e => e.innerHTML = lang['download_complete']);
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
                var hash_name = md5(filename);

                Ajax.postData(window.location.href, {
                    image_data: filename
                }, false, false).then((data) => {
                    var this_width = data[0];
                    var this_height = data[1];
                    var quality_width = resize_max[0];
                    var quality_height = resize_max[1];

                    if (this_height < quality_height && this_width < quality_width) {
                        if (document.querySelector('#add').value === 'ok') {
                            document.querySelector('#alert_messages').innerHTML = '<div class="alert alert-danger">' + lang['image_resize_error'] + ' ' + quality_width + 'x' + quality_height + '</div>';
                        }
                        if (document.querySelector('#edit').value !== '') {
                            document.querySelector('#alert_messages').innerHTML = '<div class="alert alert-danger">' + lang['image_resize_error'] + ' ' + quality_width + 'x' + quality_height + '</div>';
                        }
                    } else {
                        if (document.querySelector('#add').value === 'ok') {
                            document.querySelector('#logo').insertAdjacentHTML('beforeend', '<div class="file-upload position-relative" id="image_add_new_' + hash_name + '"/><img src="/uploads/temp/thumbnail/' + filename + '?' + Math.random() + '" class="img-thumbnail" id="general_' + hash_name + '" /><div class="block align-items-center justify-content-evenly"><button class="btn btn-primary btn-sm bi-trash" type="button" name="deleteImageAddNew_' + hash_name + '" onclick="Fileupload.deleteImageAddNew(\'' + filename + '\', \'' + hash_name + '\')"></button> <button class="btn btn-primary btn-sm bi-star" type="button" name="imageGeneralAddNew_' + hash_name + '" onclick="Fileupload.imageGeneralAddNew(\'' + filename + '\', \'' + hash_name + '\')"></button></div></div></div>');
                        }
                        if (document.querySelector('#edit').value !== '') {
                            document.querySelector('#logo').insertAdjacentHTML('beforeend', '<div class="file-upload position-relative" id="image_edit_new_' + hash_name + '"/><img src="/uploads/temp/thumbnail/' + filename + '?' + Math.random() + '" class="img-thumbnail" id="general_edit_' + hash_name + '" /><div class="block align-items-center justify-content-evenly"><button class="btn btn-primary btn-sm bi-trash" type="button" name="deleteImageEditNew_' + hash_name + '" onclick="Fileupload.deleteImageEditNew(\'' + filename + '\', \'' + hash_name + '\')"></button> <button class="btn btn-primary btn-sm bi-star" type="button" name="imageGeneralEditNew_' + hash_name + '" onclick="Fileupload.imageGeneralEditNew(\'' + filename + '\', \'' + hash_name + '\')"></button></div></div></div>');
                        }
                    }
                });
            }
        });
    }

    /**
     * Init
     *
     */
    static init() {
        document.querySelector('#index').addEventListener('show.bs.modal', function (event) {
            Ajax.postData(window.location.href, {
                file_upload: 'empty'
            }, false).then((data) => {
            });
        });

        document.querySelector('#index').addEventListener('hidden.bs.modal', function (event) {
            document.querySelectorAll('.progress-bar').forEach(e => e.style.width = 0 + '%');
            document.querySelectorAll('.file-upload').forEach(e => e.remove());
            document.querySelector('#delete_image').value = '';
            document.querySelector('#general_image_edit').value = '';
            document.querySelector('#general_image_edit_new').value = '';
            document.querySelector('#general_image_add').value = '';
            document.querySelector('#alert_messages').innerHTML = '';
            document.querySelector('#logo').innerHTML = '';
            document.querySelectorAll('form').forEach(e => e.reset());
        });
    }

    /**
     * Loading images into "Edit" modal window
     * @param logo_general_edit {String} (general logo)
     * @param logo_edit {Array} (images array)
     * @param modal_id {String} (modal id)
     * @param dir {String} (dir)
     */
    static getImageToEdit(logo_general_edit, logo_edit, modal_id, dir) {
        for (var x = 0; x < logo_edit[modal_id].length; x++) {
            var image = logo_edit[modal_id][x];

            document.querySelector('#logo').insertAdjacentHTML('beforeend', '<div class="file-upload position-relative" id="image_edit_' + x + '"/><img src="/uploads/images/' + dir + '/resize_0/' + image + '" class="img-thumbnail" id="general_' + x + '" /><div class="block align-items-center justify-content-evenly"><button class="btn btn-primary btn-sm bi-trash" type="button" name="delete_image_' + x + '" onclick="Fileupload.deleteImageEdit(\'' + image + '\', \'' + x + '\')"></button> <button class="btn btn-primary btn-sm bi-star" type="button" name="image_general_edit' + x + '" onclick="Fileupload.imageGeneralEdit(\'' + image + '\', \'' + x + '\')"></button></div></div></div>');
            if (logo_general_edit[modal_id] === image) {
                document.querySelector('#general_' + x).classList.add('border-danger');
            }
        }
    }

    /**
     * Selective deletion of images in "Edit" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static deleteImageEdit(image, num) {
        document.querySelector('#image_edit_' + num).remove();
        document.querySelector('#delete_image').value = (document.querySelector('#delete_image').value + image + ',');
    }

    /**
     * Selective deletion of new unsaved images in "Add" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static deleteImageAddNew(image, num) {
        Ajax.postData(window.location.href, {
            delete_image: image,
            delete_new_image: 'ok'
        }, false).then((data) => {
            document.querySelector('#image_add_new_' + num).remove();
        });
    }

    /**
     * Selective deletion of new unsaved images in "Edit" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static deleteImageEditNew(image, num) {
        Ajax.postData(window.location.href, {
            delete_image: image,
            delete_new_image: 'ok'
        }, false).then((data) => {
            document.querySelector('#image_edit_new_' + num).remove();
        });
    }

    /**
     * Main image in "Edit" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static imageGeneralEdit(image, num) {
        document.querySelectorAll('img').forEach(e => e.classList.remove('border-danger'));
        document.querySelectorAll('#general_' + num).forEach(e => e.classList.add('border-danger'));
        document.querySelector('#general_image_edit').value = image;
    }

    /**
     * Main image in "Add" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static imageGeneralAddNew(image, num) {
        document.querySelectorAll('img').forEach(e => e.classList.remove('border-danger'));
        document.querySelectorAll('#general_' + num).forEach(e => e.classList.add('border-danger'));
        document.querySelector('#general_image_add').value = image;
    }

    /**
     * Main image for a new not saved image in "Edit" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static imageGeneralEditNew(image, num) {
        document.querySelectorAll('img').forEach(e => e.classList.remove('border-danger'));
        document.querySelectorAll('#general_edit_' + num).forEach(e => e.classList.add('border-danger'));
        document.querySelector('#general_image_edit_new').value = image;
    }

}