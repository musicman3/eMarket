/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
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

        $('#fileupload-product').fileupload({
            url: url,
            dataType: 'json',
            submit: function (e, data) {
                $('#alert_messages_product').empty();
            },
            done: function (e, data) {

                $.each(data.result.files, function (index, file) {
                    var hash_name = md5(file.name);

                    jQuery.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: window.location.href,
                        data: {image_data: file.name,
                            effect_edit: $('#effect-product').val()},
                        success: function (image_size) {
                            var this_width = image_size[0];
                            var this_height = image_size[1];
                            var quality_width = resize_max[0];
                            var quality_height = resize_max[1];

                            if (this_height < quality_height && this_width < quality_width) {
                                if (document.querySelector('#add_product').value === 'ok') {
                                    $('#alert_messages_product').html('<div class="alert alert-danger">' + lang['image_resize_error'] + ' ' + quality_width + 'x' + quality_height + '</div>');
                                }
                                if (document.querySelector('#edit_product').value !== '') {
                                    $('#alert_messages_product').html('<div class="alert alert-danger">' + lang['image_resize_error'] + ' ' + quality_width + 'x' + quality_height + '</div>');
                                }
                            } else {
                                if (document.querySelector('#add_product').value === 'ok') {
                                    $('<div class="file-upload position-relative" id="image_add_new_product_' + hash_name + '"/>').html('<img src="/uploads/temp/thumbnail/' + file.name + '?' + Math.random() + '" class="img-thumbnail" id="general_product_' + hash_name + '" /><div class="block align-items-center justify-content-evenly"><button class="btn btn-primary btn-sm bi-trash" type="button" name="deleteImageAddNewProduct_' + hash_name + '" onclick="FileuploadProduct.deleteImageAddNewProduct(\'' + file.name + '\', \'' + hash_name + '\')"></button> <button class="btn btn-primary btn-sm bi-star" type="button" name="imageGeneralAddNewProduct_' + hash_name + '" onclick="FileuploadProduct.imageGeneralAddNewProduct(\'' + file.name + '\', \'' + hash_name + '\')"></button></div></div>').appendTo('#logo-product');
                                }
                                if (document.querySelector('#edit_product').value !== '') {
                                    $('<div class="file-upload position-relative" id="image_edit_new_product_' + hash_name + '"/>').html('<img src="/uploads/temp/thumbnail/' + file.name + '?' + Math.random() + '" class="img-thumbnail" id="general_edit_product_' + hash_name + '" /><div class="block align-items-center justify-content-evenly"><button class="btn btn-primary btn-sm bi-trash" type="button" name="deleteImageEditNewProduct_' + hash_name + '" onclick="FileuploadProduct.deleteImageEditNewProduct(\'' + file.name + '\', \'' + hash_name + '\')"></button> <button class="btn btn-primary btn-sm bi-star" type="button" name="imageGeneralEditNewProduct_' + hash_name + '" onclick="FileuploadProduct.imageGeneralEditNewProduct(\'' + file.name + '\', \'' + hash_name + '\')"></button></div></div>').appendTo('#logo-product');
                                }
                            }
                        }
                    });

                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('.progress-bar').css(
                        'width',
                        progress + '%'
                        );
                $('.progress-bar').empty();
                $('.progress-bar').removeClass('progress-bar bg-success').addClass('progress-bar bg-danger progress-bar-striped progress-bar-animated');
                if (progress === 100) {
                    setTimeout(function () {
                        $('.progress-bar').html(lang['download_complete']);
                        $('.progress-bar').removeClass('progress-bar bg-danger progress-bar-striped progress-bar-animated').addClass('progress-bar bg-success');
                    }, 1000);
                }
            }
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    }

    /**
     * Init
     *
     */
    static init() {
        $('#index_product').on('show.bs.modal', function (event) {
            jQuery.post(window.location.href,
                    {file_upload: 'empty'});
        });

        $('#index_product').on('hidden.bs.modal', function (event) {
            $('.progress-bar').css('width', 0 + '%');
            $('.file-upload').detach();
            document.querySelector('#delete_image_product').value = '';
            document.querySelector('#general_image_edit_product').value = '';
            document.querySelector('#general_image_edit_new_product').value = '';
            document.querySelector('#general_image_add_product').value = '';
            $('#alert_messages_product').empty();
            $(this).find('form').trigger('reset'); // Очищаем формы
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

            $('<div class="file-upload position-relative" id="image_edit_product_' + x + '"/>').html('<img src="/uploads/images/' + dir + '/resize_0/' + image + '" class="img-thumbnail" id="general_product_' + x + '" /><div class="block align-items-center justify-content-evenly"><button class="btn btn-primary btn-sm bi-trash" type="button" name="delete_image_product_' + x + '" onclick="FileuploadProduct.deleteImageEditProduct(\'' + image + '\', \'' + x + '\')"></button> <button class="btn btn-primary btn-sm bi-star" type="button" name="image_general_edit_product' + x + '" onclick="FileuploadProduct.imageGeneralEditProduct(\'' + image + '\', \'' + x + '\')"></button></div></div>').appendTo('#logo-product');
            if (logo_general_edit[modal_id] === image) {
                $('#general_product_' + x).addClass('border-danger');
            }
        }
    }

    /**
     * Selective deletion of images in "Edit" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static deleteImageEditProduct(image, num) {
        $('#image_edit_product_' + num).detach();
        document.querySelector('#delete_image_product').value = (document.querySelector('#delete_image_product').value + image + ',');
    }

    /**
     * Selective deletion of new unsaved images in "Add" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static deleteImageAddNewProduct(image, num) {
        jQuery.post(window.location.href,
                {delete_image: image,
                    delete_new_image: 'ok'},
                AjaxSuccess);
        function AjaxSuccess(data) {
            $('#image_add_new_product_' + num).detach();
        }
    }

    /**
     * Selective deletion of new unsaved images in "Edit" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static deleteImageEditNewProduct(image, num) {
        jQuery.post(window.location.href, // отправка данных POST
                {delete_image: image,
                    delete_new_image: 'ok'},
                AjaxSuccess);
        function AjaxSuccess(data) {
            $('#image_edit_new_product_' + num).detach();
        }
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