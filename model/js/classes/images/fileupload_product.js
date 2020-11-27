/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Загрузка изображений в товар
 *
 * @package FileuploadProduct
 * @author eMarket
 * 
 */
class FileuploadProduct {
    /**
     * Конструктор
     *
     *@param resize_max {Array} (размеры ресайза)
     *@param lang {Array} (языковые переменные)
     */
    constructor(resize_max, lang) {
        FileuploadProduct.init();
        FileuploadProduct.process(resize_max, lang);
    }

    /**
     * Загрузка новых изображений в модальное окно "Редактировать и Добавить"
     *
     *@param resize_max {Array} (размеры ресайза)
     *@param lang {Array} (языковые переменные)
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
                    var hash_name = md5(file.name); // Хэшируем

                    jQuery.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: window.location.href,
                        data: {image_data: file.name,
                            effect_edit: $('#effect-product').val()},
                        success: function (image_size) {
                            // Вычисляем размеры изображения
                            var this_width = image_size[0]; // Ширина оригинала
                            var this_height = image_size[1]; // Высота оригинала
                            var quality_width = resize_max[0]; // Минимальный размер ширины для качественного ресайза
                            var quality_height = resize_max[1]; // Минимальный размер высоты для качественного ресайза

                            if (this_height < quality_height && this_width < quality_width) {
                                // Если изображение не соответствует минимальным размерам то выводим сообщение
                                if ($('#add_product').val() === 'ok') {
                                    $('#alert_messages_product').html('<div class="alert alert-danger"><' + lang['image_resize_error'] + ' ' + quality_width + 'x' + quality_height + '</div>');
                                }
                                if ($('#edit_product').val() !== '') {
                                    $('#alert_messages_product').html('<div class="alert alert-danger">' + lang['image_resize_error'] + ' ' + quality_width + 'x' + quality_height + '</div>');
                                }
                            } else {
                                // Если все ок, то выводим изображение
                                if ($('#add_product').val() === 'ok') {
                                    $('<span class="file-upload" id="image_add_new_product_' + hash_name + '"/>').html('<div class="holder"><img src="/uploads/temp/thumbnail/' + file.name + '?' + Math.random() + '" class="thumbnail" id="general_product_' + hash_name + '" /><div class="block"><button class="btn btn-primary btn-xs" type="button" name="deleteImageAddNewProduct_' + hash_name + '" onclick="FileuploadProduct.deleteImageAddNewProduct(\'' + file.name + '\', \'' + hash_name + '\')"><span class="glyphicon glyphicon-trash"></span></button> <button class="btn btn-primary btn-xs" type="button" name="imageGeneralAddNewProduct_' + hash_name + '" onclick="FileuploadProduct.imageGeneralAddNewProduct(\'' + file.name + '\', \'' + hash_name + '\')"><span class="glyphicon glyphicon-star"></span></button></div></div>').appendTo('#logo-product'); // Вставляем лого
                                }
                                if ($('#edit_product').val() !== '') {
                                    $('<span class="file-upload" id="image_edit_new_product_' + hash_name + '"/>').html('<div class="holder"><img src="/uploads/temp/thumbnail/' + file.name + '?' + Math.random() + '" class="thumbnail" id="general_edit_product_' + hash_name + '" /><div class="block"><button class="btn btn-primary btn-xs" type="button" name="deleteImageEditNewProduct_' + hash_name + '" onclick="FileuploadProduct.deleteImageEditNewProduct(\'' + file.name + '\', \'' + hash_name + '\')"><span class="glyphicon glyphicon-trash"></span></button> <button class="btn btn-primary btn-xs" type="button" name="imageGeneralEditNewProduct_' + hash_name + '" onclick="FileuploadProduct.imageGeneralEditNewProduct(\'' + file.name + '\', \'' + hash_name + '\')"><span class="glyphicon glyphicon-star"></span></button></div></div>').appendTo('#logo-product'); // Вставляем лого
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
                // Разные стили для прогресс-бара и надпись об успехе загрузки
                $('.progress-bar').empty();
                $('.progress-bar').removeClass('progress-bar progress-bar-success').addClass('progress-bar progress-bar-warning progress-bar-striped active');
                if (progress === 100) {
                    setTimeout(function () {
                        $('.progress-bar').html(lang['download_complete']);
                        $('.progress-bar').removeClass('progress-bar progress-bar-warning progress-bar-striped active').addClass('progress-bar progress-bar-success');
                    }, 1000);
                }
            }
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    }

    /**
     * Инициализация
     *
     */
    static init() {
        //Если открыли модальное окно
        $('#index_product').on('show.bs.modal', function (event) {
            // Отправка запроса для очистки временных файлов
            jQuery.post(window.location.href,
                    {file_upload: 'empty'});
        });

        // Очищаем модальное окно и hidden input при закрытии
        $('#index_product').on('hidden.bs.modal', function (event) {
            $('.progress-bar').css('width', 0 + '%');
            $('.file-upload').detach();
            $('#delete_image_product').val('');
            $('#general_image_edit_product').val('');
            $('#general_image_edit_new_product').val('');
            $('#general_image_add_product').val('');
            $('#alert_messages_product').empty();
            $(this).find('form').trigger('reset'); // Очищаем формы
        });
    }

    /**
     * Загрузка изображений в модальное окно "Редактировать"
     * @param logo_general_edit {String} (главное изображение)
     * @param logo_edit {Array} (массив изображений)
     * @param modal_id {String} (id модала)
     * @param dir {String} (директория)
     */
    static getImageToEditProduct(logo_general_edit, logo_edit, modal_id, dir) {
        // Добавляем данные
        for (var x = 0; x < logo_edit[modal_id].length; x++) {
            var image = logo_edit[modal_id][x];

            $('<span class="file-upload" id="image_edit_product_' + x + '"/>').html('<div class="holder"><img src="/uploads/images/' + dir + '/resize_0/' + image + '" class="thumbnail" id="general_product_' + x + '" /><div class="block"><button class="btn btn-primary btn-xs" type="button" name="delete_image_product_' + x + '" onclick="FileuploadProduct.deleteImageEditProduct(\'' + image + '\', \'' + x + '\')"><span class="glyphicon glyphicon-trash"></span></button> <button class="btn btn-primary btn-xs" type="button" name="image_general_edit_product' + x + '" onclick="FileuploadProduct.imageGeneralEditProduct(\'' + image + '\', \'' + x + '\')"><span class="glyphicon glyphicon-star"></span></button></div></div>').appendTo('#logo-product'); // Вставляем лого
            // Если это главное изображение, то выделяем его
            if (logo_general_edit[modal_id] === image) {
                $('#general_product_' + x).addClass('img-active');
            }
        }
    }

    /**
     * Выборочное удаление изображений в модальном окне "Редактировать"
     * @param image {String} (изображение)
     * @param num {String} (номер)
     */
    static deleteImageEditProduct(image, num) {
        $('#image_edit_product_' + num).detach();
        $('#delete_image_product').val($('#delete_image_product').val() + image + ',');
    }

    /**
     * Выборочное удаление новых не сохранненных изображений в модальном окне "Добавить"
     * @param image {String} (изображение)
     * @param num {String} (номер)
     */
    static deleteImageAddNewProduct(image, num) {
        jQuery.post(window.location.href, // отправка данных POST
                {delete_image: image,
                    delete_new_image: 'ok'},
                AjaxSuccess);
        function AjaxSuccess(data) {
            $('#image_add_new_product_' + num).detach();
        }
    }

    /**
     * Выборочное удаление новых не сохранненных изображений в модальном окне "Редактировать"
     * @param image {String} (изображение)
     * @param num {String} (номер)
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
     * Главное изображение в модальном окне "Редактировать"
     * @param image {String} (изображение)
     * @param num {String} (номер)
     */
    static imageGeneralEditProduct(image, num) {
        $('img').removeClass('img-active');
        $('#general_product_' + num).addClass('img-active');
        $('#general_image_edit_product').val(image);
    }

    /**
     * Главное изображение в модальном окне "Добавить"
     * @param image {String} (изображение)
     * @param num {String} (номер)
     */
    static imageGeneralAddNewProduct(image, num) {
        $('img').removeClass('img-active');
        $('#general_product_' + num).addClass('img-active');
        $('#general_image_add_product').val(image);
    }

    /**
     * Главное изображение для нового не сохраненного изображения в модальном окне "Редактировать"
     * @param image {String} (изображение)
     * @param num {String} (номер)
     */
    static imageGeneralEditNewProduct(image, num) {
        $('img').removeClass('img-active');
        $('#general_edit_product_' + num).addClass('img-active');
        $('#general_image_edit_new_product').val(image);
    }

}