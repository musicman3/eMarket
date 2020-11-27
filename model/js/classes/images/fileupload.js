/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Корзина
 *
 * @package Fileupload
 * @author eMarket
 * 
 */
class Fileupload {
    /**
     * Конструктор
     *
     *@param resize_max {Array} (размеры ресайза)
     *@param lang {Array} (языковые переменные)
     */
    constructor(resize_max, lang) {
        Fileupload.init();
        Fileupload.process(resize_max, lang);
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

        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            submit: function (e, data) {
                $('#alert_messages').empty();
            },
            done: function (e, data) {

                $.each(data.result.files, function (index, file) {
                    var hash_name = md5(file.name); // Хэшируем

                    jQuery.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: window.location.href,
                        data: {image_data: file.name},
                        success: function (image_size) {
                            // Вычисляем размеры изображения
                            var this_width = image_size[0]; // Ширина оригинала
                            var this_height = image_size[1]; // Высота оригинала
                            var quality_width = resize_max[0]; // Минимальный размер ширины для качественного ресайза
                            var quality_height = resize_max[1]; // Минимальный размер высоты для качественного ресайза

                            if (this_height < quality_height && this_width < quality_width) {
                                // Если изображение не соответствует минимальным размерам то выводим сообщение
                                if ($('#add').val() === 'ok') {
                                    $('#alert_messages').html('<div class="alert alert-danger">' + lang['image_resize_error'] + ' ' + quality_width + 'x' + quality_height + '</div>');
                                }
                                if ($('#edit').val() !== '') {
                                    $('#alert_messages').html('<div class="alert alert-danger">' + lang['image_resize_error'] + ' ' + quality_width + 'x' + quality_height + '</div>');
                                }
                            } else {
                                // Если все ок, то выводим изображение
                                if ($('#add').val() === 'ok') {
                                    $('<span class="file-upload" id="image_add_new_' + hash_name + '"/>').html('<div class="holder"><img src="/uploads/temp/thumbnail/' + file.name + '" class="thumbnail" id="general_' + hash_name + '" /><div class="block"><button class="btn btn-primary btn-xs" type="button" name="Fileupload.deleteImageAddNew_' + hash_name + '" onclick="Fileupload.deleteImageAddNew(\'' + file.name + '\', \'' + hash_name + '\')"><span class="glyphicon glyphicon-trash"></span></button> <button class="btn btn-primary btn-xs" type="button" name="Fileupload.imageGeneralAddNew_' + hash_name + '" onclick="Fileupload.imageGeneralAddNew(\'' + file.name + '\', \'' + hash_name + '\')"><span class="glyphicon glyphicon-star"></span></button></div></div>').appendTo('#logo'); // Вставляем лого
                                }
                                if ($('#edit').val() !== '') {
                                    $('<span class="file-upload" id="image_edit_new_' + hash_name + '"/>').html('<div class="holder"><img src="/uploads/temp/thumbnail/' + file.name + '" class="thumbnail" id="general_edit_' + hash_name + '" /><div class="block"><button class="btn btn-primary btn-xs" type="button" name="Fileupload.deleteImageEditNew_' + hash_name + '" onclick="Fileupload.deleteImageEditNew(\'' + file.name + '\', \'' + hash_name + '\')"><span class="glyphicon glyphicon-trash"></span></button> <button class="btn btn-primary btn-xs" type="button" name="Fileupload.imageGeneralEditNew_' + hash_name + '" onclick="Fileupload.imageGeneralEditNew(\'' + file.name + '\', \'' + hash_name + '\')"><span class="glyphicon glyphicon-star"></span></button></div></div>').appendTo('#logo'); // Вставляем лого
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

    static init() {
        //Если открыли модальное окно
        $('#index').on('show.bs.modal', function (event) {
            // Отправка запроса для очистки временных файлов
            jQuery.post(window.location.href,
                    {file_upload: 'empty'});
        });

        // Очищаем модальное окно и hidden input при закрытии
        $('#index').on('hidden.bs.modal', function (event) {
            $('.progress-bar').css('width', 0 + '%');
            $('.file-upload').detach();
            $('#delete_image').val('');
            $('#general_image_edit').val('');
            $('#general_image_edit_new').val('');
            $('#general_image_add').val('');
            $('#alert_messages').empty();
            $(this).find('form').trigger('reset'); // Очищаем формы
        });
    }

    // Загрузка изображений в модальное окно "Редактировать"
    static getImageToEdit(logo_general_edit, logo_edit, modal_id, dir) {
        // Добавляем данные
        for (var x = 0; x < logo_edit[modal_id].length; x++) {
            var image = logo_edit[modal_id][x];

            $('<span class="file-upload" id="image_edit_' + x + '"/>').html('<div class="holder"><img src="/uploads/images/' + dir + '/resize_0/' + image + '" class="thumbnail" id="general_' + x + '" /><div class="block"><button class="btn btn-primary btn-xs" type="button" name="delete_image_' + x + '" onclick="Fileupload.deleteImageEdit(\'' + image + '\', \'' + x + '\')"><span class="glyphicon glyphicon-trash"></span></button> <button class="btn btn-primary btn-xs" type="button" name="image_general_edit' + x + '" onclick="Fileupload.imageGeneralEdit(\'' + image + '\', \'' + x + '\')"><span class="glyphicon glyphicon-star"></span></button></div></div>').appendTo('#logo'); // Вставляем лого
            // Если это главное изображение, то выделяем его
            if (logo_general_edit[modal_id] === image) {
                $('#general_' + x).addClass('img-active');
            }
        }
    }

    // Выборочное удаление изображений в модальном окне "Редактировать"
    static deleteImageEdit(image, num) {
        // Удаляем изображение
        $('#image_edit_' + num).detach();
        // Меняем значение в hidden input
        $('#delete_image').val($('#delete_image').val() + image + ',');
    }

    // Выборочное удаление новых не сохранненных изображений в модальном окне "Добавить"
    static deleteImageAddNew(image, num) {
        jQuery.post(window.location.href, // отправка данных POST
                {delete_image: image,
                    delete_new_image: 'ok'},
                AjaxSuccess);
        function AjaxSuccess(data) {
            // Удаляем изображение
            $('#image_add_new_' + num).detach();
        }
    }

    // Выборочное удаление новых не сохранненных изображений в модальном окне "Редактировать"
    static deleteImageEditNew(image, num) {
        jQuery.post(window.location.href, // отправка данных POST
                {delete_image: image,
                    delete_new_image: 'ok'},
                AjaxSuccess);
        function AjaxSuccess(data) {
            // Удаляем изображение
            $('#image_edit_new_' + num).detach();
        }
    }

    // Главное изображение в модальном окне "Редактировать"
    static imageGeneralEdit(image, num) {
        $('img').removeClass('img-active');
        $('#general_' + num).addClass('img-active');
        // Меняем значение в hidden input
        $('#general_image_edit').val(image);
    }

    // Главное изображение в модальном окне "Добавить"
    static imageGeneralAddNew(image, num) {
        $('img').removeClass('img-active');
        $('#general_' + num).addClass('img-active');
        // Меняем значение в hidden input
        $('#general_image_add').val(image);
    }

    // Главное изображение для нового не сохраненного изображения в модальном окне "Редактировать"
    static imageGeneralEditNew(image, num) {
        $('img').removeClass('img-active');
        $('#general_edit_' + num).addClass('img-active');
        // Меняем значение в hidden input
        $('#general_image_edit_new').val(image);
    }

}