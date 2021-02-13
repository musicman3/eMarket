/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Fileupload
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

        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            submit: function (e, data) {
                $('#alert_messages').empty();
            },
            done: function (e, data) {

                $.each(data.result.files, function (index, file) {
                    var hash_name = md5(file.name);

                    jQuery.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: window.location.href,
                        data: {image_data: file.name},
                        success: function (image_size) {

                            var this_width = image_size[0];
                            var this_height = image_size[1];
                            var quality_width = resize_max[0];
                            var quality_height = resize_max[1];

                            if (this_height < quality_height && this_width < quality_width) {
                                if ($('#add').val() === 'ok') {
                                    $('#alert_messages').html('<div class="alert alert-danger">' + lang['image_resize_error'] + ' ' + quality_width + 'x' + quality_height + '</div>');
                                }
                                if ($('#edit').val() !== '') {
                                    $('#alert_messages').html('<div class="alert alert-danger">' + lang['image_resize_error'] + ' ' + quality_width + 'x' + quality_height + '</div>');
                                }
                            } else {
                                if ($('#add').val() === 'ok') {
                                    $('<div class="file-upload" id="image_add_new_' + hash_name + '"/>').html('<img src="/uploads/temp/thumbnail/' + file.name + '" class="img-thumbnail" id="general_' + hash_name + '" /><div class="block align-items-center justify-content-evenly"><button class="btn btn-primary btn-sm" type="button" name="deleteImageAddNew_' + hash_name + '" onclick="Fileupload.deleteImageAddNew(\'' + file.name + '\', \'' + hash_name + '\')"><span class="bi-trash"></span></button> <button class="btn btn-primary btn-sm" type="button" name="imageGeneralAddNew_' + hash_name + '" onclick="Fileupload.imageGeneralAddNew(\'' + file.name + '\', \'' + hash_name + '\')"><span class="bi-star"></span></button></div></div>').appendTo('#logo'); // Вставляем лого
                                }
                                if ($('#edit').val() !== '') {
                                    $('<div class="file-upload" id="image_edit_new_' + hash_name + '"/>').html('<img src="/uploads/temp/thumbnail/' + file.name + '" class="img-thumbnail" id="general_edit_' + hash_name + '" /><div class="block align-items-center justify-content-evenly"><button class="btn btn-primary btn-sm" type="button" name="FdeleteImageEditNew_' + hash_name + '" onclick="Fileupload.deleteImageEditNew(\'' + file.name + '\', \'' + hash_name + '\')"><span class="bi-trash"></span></button> <button class="btn btn-primary btn-sm" type="button" name="imageGeneralEditNew_' + hash_name + '" onclick="Fileupload.imageGeneralEditNew(\'' + file.name + '\', \'' + hash_name + '\')"><span class="bi-star"></span></button></div></div>').appendTo('#logo'); // Вставляем лого
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
        $('#index').on('show.bs.modal', function (event) {
            jQuery.post(window.location.href,
                    {file_upload: 'empty'});
        });

        $('#index').on('hidden.bs.modal', function (event) {
            $('.progress-bar').css('width', 0 + '%');
            $('.file-upload').detach();
            $('#delete_image').val('');
            $('#general_image_edit').val('');
            $('#general_image_edit_new').val('');
            $('#general_image_add').val('');
            $('#alert_messages').empty();
            $(this).find('form').trigger('reset');
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

            $('<div class="file-upload" id="image_edit_' + x + '"/>').html('<img src="/uploads/images/' + dir + '/resize_0/' + image + '" class="img-thumbnail" id="general_' + x + '" /><div class="block align-items-center justify-content-evenly"><button class="btn btn-primary btn-sm" type="button" name="delete_image_' + x + '" onclick="Fileupload.deleteImageEdit(\'' + image + '\', \'' + x + '\')"><span class="bi-trash"></span></button> <button class="btn btn-primary btn-sm" type="button" name="image_general_edit' + x + '" onclick="Fileupload.imageGeneralEdit(\'' + image + '\', \'' + x + '\')"><span class="bi-star"></span></button></div></div>').appendTo('#logo');
            if (logo_general_edit[modal_id] === image) {
                $('#general_' + x).addClass('border border-danger rounded');
            }
        }
    }
    
    /**
     * Selective deletion of images in "Edit" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static deleteImageEdit(image, num) {
        $('#image_edit_' + num).detach();
        $('#delete_image').val($('#delete_image').val() + image + ',');
    }
    
    /**
     * Selective deletion of new unsaved images in "Add" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static deleteImageAddNew(image, num) {
        jQuery.post(window.location.href,
                {delete_image: image,
                    delete_new_image: 'ok'},
                AjaxSuccess);
        function AjaxSuccess(data) {
            $('#image_add_new_' + num).detach();
        }
    }
    
    /**
     * Selective deletion of new unsaved images in "Edit" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static deleteImageEditNew(image, num) {
        jQuery.post(window.location.href,
                {delete_image: image,
                    delete_new_image: 'ok'},
                AjaxSuccess);
        function AjaxSuccess(data) {
            $('#image_edit_new_' + num).detach();
        }
    }

    /**
     * Main image in "Edit" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static imageGeneralEdit(image, num) {
        $('img').removeClass('border border-danger rounded');
        $('#general_' + num).addClass('border border-danger rounded');
        $('#general_image_edit').val(image);
    }

    /**
     * Main image in "Add" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static imageGeneralAddNew(image, num) {
        $('img').removeClass('border border-danger rounded');
        $('#general_' + num).addClass('border border-danger rounded');
        $('#general_image_add').val(image);
    }

    /**
     * Main image for a new not saved image in "Edit" modal window
     * @param image {String} (image)
     * @param num {String} (number)
     */
    static imageGeneralEditNew(image, num) {
        $('img').removeClass('border border-danger rounded');
        $('#general_edit_' + num).addClass('border border-danger rounded');
        $('#general_image_edit_new').val(image);
    }

}