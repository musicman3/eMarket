/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global Ajax, ss */

/**
 * Product Fileupload
 *
 * @package ProductFileupload
 * @author eMarket
 * 
 */
class FileuploadProduct {
    /**
     * Constructor
     *
     *@param resize_max {Array} (max resize)
     *@param lang {Array} (language)
     */
    constructor(resize_max, lang) {
        FileuploadProduct.init();
        FileuploadProduct.process(resize_max, lang);
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
            button: 'fileupload-product',
            url: url,
            responseType: 'json',
            name: 'uploadfile',
            multiple: true,
            multipleSelect: true,
            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
            onSubmit: function (filename, extension) {
                document.querySelector('#alert_messages_product').innerHTML = '';
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
                    image_data: filename,
                    effect_edit: document.querySelector('#effect-product').value
                }, false, false).then((data) => {
                    var this_width = data[0];
                    var this_height = data[1];
                    var quality_width = resize_max[0];
                    var quality_height = resize_max[1];

                    if (this_height < quality_height && this_width < quality_width) {
                        if (document.querySelector('#add_product').value === 'ok') {
                            document.querySelector('#alert_messages_product').innerHTML = '<div class="alert alert-danger">' + lang['image_resize_error'] + ' ' + quality_width + 'x' + quality_height + '</div>';
                        }
                        if (document.querySelector('#edit_product').value !== '') {
                            document.querySelector('#alert_messages_product').innerHTML = '<div class="alert alert-danger">' + lang['image_resize_error'] + ' ' + quality_width + 'x' + quality_height + '</div>';
                        }
                    } else {
                        if (document.querySelector('#add_product').value === 'ok') {
                            document.querySelector('#logo-product').insertAdjacentHTML('beforeend', '<div class="file-upload position-relative" id="image_add_new_product_' + hash_name + '"/><img src="/uploads/temp/thumbnail/' + filename + '?' + Math.random() + '" class="img-thumbnail" id="general_product_' + hash_name + '" /><div class="block align-items-center justify-content-evenly"><button class="btn btn-primary btn-sm bi-trash" type="button" name="deleteImageAddNewProduct_' + hash_name + '" onclick="FileuploadProduct.deleteImageAddNewProduct(\'' + filename + '\', \'' + hash_name + '\')"></button> <button class="btn btn-primary btn-sm bi-star" type="button" name="imageGeneralAddNewProduct_' + hash_name + '" onclick="FileuploadProduct.imageGeneralAddNewProduct(\'' + filename + '\', \'' + hash_name + '\')"></button></div></div></div>');
                        }
                        if (document.querySelector('#edit_product').value !== '') {
                            document.querySelector('#logo-product').insertAdjacentHTML('beforeend', '<div class="file-upload position-relative" id="image_edit_new_product_' + hash_name + '"/><img src="/uploads/temp/thumbnail/' + filename + '?' + Math.random() + '" class="img-thumbnail" id="general_edit_product_' + hash_name + '" /><div class="block align-items-center justify-content-evenly"><button class="btn btn-primary btn-sm bi-trash" type="button" name="deleteImageEditNewProduct_' + hash_name + '" onclick="FileuploadProduct.deleteImageEditNewProduct(\'' + filename + '\', \'' + hash_name + '\')"></button> <button class="btn btn-primary btn-sm bi-star" type="button" name="imageGeneralEditNewProduct_' + hash_name + '" onclick="FileuploadProduct.imageGeneralEditNewProduct(\'' + filename + '\', \'' + hash_name + '\')"></button></div></div></div>');
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
        document.querySelector('#index_product').addEventListener('show.bs.modal', function (event) {
            Ajax.postData(window.location.href, {
                file_upload: 'empty'
            }, false).then((data) => {
            });
        });

        document.querySelector('#index_product').addEventListener('hidden.bs.modal', function (event) {
            document.querySelectorAll('.progress-bar').forEach(e => e.style.width = 0 + '%');
            document.querySelectorAll('.file-upload').forEach(e => e.remove());
            document.querySelector('#delete_image_product').value = '';
            document.querySelector('#general_image_edit_product').value = '';
            document.querySelector('#general_image_edit_new_product').value = '';
            document.querySelector('#general_image_add_product').value = '';
            document.querySelector('#alert_messages_product').innerHTML = '';
            document.querySelector('#logo-product').innerHTML = '';
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
    static getImageToEditProduct(logo_general_edit, logo_edit, modal_id, dir) {
        for (var x = 0; x < logo_edit[modal_id].length; x++) {
            var image = logo_edit[modal_id][x];

            document.querySelector('#logo-product').insertAdjacentHTML('beforeend', '<div class="file-upload position-relative" id="image_edit_product_' + x + '"/><img src="/uploads/images/' + dir + '/resize_0/' + image + '" class="img-thumbnail" id="general_product_' + x + '" /><div class="block align-items-center justify-content-evenly"><button class="btn btn-primary btn-sm bi-trash" type="button" name="delete_image_product_' + x + '" onclick="FileuploadProduct.deleteImageEditProduct(\'' + image + '\', \'' + x + '\')"></button> <button class="btn btn-primary btn-sm bi-star" type="button" name="image_general_edit_product' + x + '" onclick="FileuploadProduct.imageGeneralEditProduct(\'' + image + '\', \'' + x + '\')"></button></div></div></div>');
            if (logo_general_edit[modal_id] === image) {
                document.querySelector('#general_product_' + x).classList.add('border-danger');
            }
        }
    }

    /**
     * Selective deletion of images in "Edit" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static deleteImageEditProduct(image, num) {
        document.querySelector('#image_edit_product_' + num).remove();
        document.querySelector('#delete_image_product').value = (document.querySelector('#delete_image_product').value + image + ',');
    }

    /**
     * Selective deletion of new unsaved images in "Add" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static deleteImageAddNewProduct(image, num) {
        Ajax.postData(window.location.href, {
            delete_image: image,
            delete_new_image: 'ok'
        }, false).then((data) => {
            document.querySelector('#image_add_new_product_' + num).remove();
        });
    }

    /**
     * Selective deletion of new unsaved images in "Edit" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static deleteImageEditNewProduct(image, num) {
        Ajax.postData(window.location.href, {
            delete_image: image,
            delete_new_image: 'ok'
        }, false).then((data) => {
            document.querySelector('#image_edit_new_product_' + num).remove();
        });
    }

    /**
     * Main image in "Edit" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static imageGeneralEditProduct(image, num) {
        document.querySelectorAll('img').forEach(e => e.classList.remove('border-danger'));
        document.querySelectorAll('#general_product_' + num).forEach(e => e.classList.add('border-danger'));
        document.querySelector('#general_image_edit_product').value = image;
    }

    /**
     * Main image in "Add" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static imageGeneralAddNewProduct(image, num) {
        document.querySelectorAll('img').forEach(e => e.classList.remove('border-danger'));
        document.querySelectorAll('#general_product_' + num).forEach(e => e.classList.add('border-danger'));
        document.querySelector('#general_image_add_product').value = image;
    }

    /**
     * Main image for a new not saved image in "Edit" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static imageGeneralEditNewProduct(image, num) {
        document.querySelectorAll('img').forEach(e => e.classList.remove('border-danger'));
        document.querySelectorAll('#general_edit_product_' + num).forEach(e => e.classList.add('border-danger'));
        document.querySelector('#general_image_edit_new_product').value = image;
    }

}