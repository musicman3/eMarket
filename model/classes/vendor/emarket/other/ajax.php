<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Other;

class Ajax {

    /**
     * Ajax обработка для Добавить, Редактировать, Удалить
     *
     * @param строка $url
     * @return javascript
     */
    public function action($url) {
        $VALID = new \eMarket\Core\Valid;

        ?>
        <!-- Модальное окно "Добавить" -->
        <script type="text/javascript" language="javascript">
            function callAdd() {
                var msg = $('#form_add').serialize();
                // Установка синхронного запроса для jQuery.ajax
                jQuery.ajaxSetup({async: false});
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $url ?>',
                    data: msg,
                    beforeSend: function () {
                        $('#add').modal('hide');
                    }
                });
                // Отправка запроса для обновления страницы
                jQuery.get('<?php echo $url ?>', // отправка данных GET
                        {modify: 'update_ok'},
                        AjaxSuccess);
                // Обновление страницы
                function AjaxSuccess(data) {
                    setTimeout(function () {
                        document.location.href = '<?php echo $VALID->inSERVER('REQUEST_URI') ?>';
                    }, 100);
                }
            }
        </script>

        <!-- Модальное окно "Редактировать" -->
        <script type="text/javascript" language="javascript">
            function callEdit() {
                var msg = $('#form_edit').serialize();
                // Установка синхронного запроса для jQuery.ajax
                jQuery.ajaxSetup({async: false});
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $url ?>',
                    data: msg,
                    beforeSend: function () {
                        $('#edit').modal('hide');
                    }
                });
                // Отправка запроса для обновления страницы
                jQuery.get('<?php echo $url ?>', // отправка данных GET
                        {modify: 'update_ok'},
                        AjaxSuccess);
                // Обновление страницы
                function AjaxSuccess(data) {
                    setTimeout(function () {
                        document.location.href = '<?php echo $VALID->inSERVER('REQUEST_URI') ?>';
                    }, 100);
                }
            }
        </script>

        <!-- Функция "Удалить" -->
        <script type="text/javascript" language="javascript">
            function callDelete(id) {
                var msg = $('#form_delete' + id).serialize();
                // Установка синхронного запроса для jQuery.ajax
                jQuery.ajaxSetup({async: false});
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $url ?>',
                    data: msg,
                    success: function () {
                        // Пустой запрос
                    }
                });
                // Отправка запроса для обновления страницы
                jQuery.get('<?php echo $url ?>', // отправка данных GET
                        {modify: 'update_ok'},
                        AjaxSuccess);
                // Обновление страницы
                function AjaxSuccess(data) {
                    setTimeout(function () {
                        document.location.href = '<?php echo $VALID->inSERVER('REQUEST_URI') ?>';
                    }, 100);
                }
            }
        </script>

        <?php
    }

    /**
     * jQuery File Upload
     *
     * @param $url
     * @return javascript
     */
    public function fileUpload($url) {

        ?>
        <!--Подгружаем jQuery File Upload -->
        <script src = "/ext/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>
        <script src="/ext/jquery_file_upload/js/jquery.iframe-transport.js"></script>
        <script src="/ext/jquery_file_upload/js/jquery.fileupload.js"></script>
        <script type="text/javascript" language="javascript">
            $(function () {
                'use strict';
                var url = '/downloads/upload_handler/';

                $('#fileupload-add, #fileupload-edit').fileupload({
                    url: url,
                    dataType: 'json',
                    done: function (e, data) {

                        $.each(data.result.files, function (index, file) {
                            var basename = file.name.split('.').slice(0, -1).join('.'); //Обрезаем расширение файла
                            $('<span class="file-upload" id="image_add_new_' + basename + '"/>').html('<div class="holder"><img src="/downloads/upload_handler/files/thumbnail/' + file.name + '" class="thumbnail img-active" /><div class="block"><button class="btn btn-primary btn-xs" type="button" name="deleteImageAddNew_' + basename + '" onclick="deleteImageAddNew(\'' + file.name + '\', \'' + basename + '\')"><span class="glyphicon glyphicon-trash"></span></button></div></div>').appendTo('#logo-add'); // Вставляем лого
                            $('<span class="file-upload" id="image_edit_new_' + basename + '"/>').html('<div class="holder"><img src="/downloads/upload_handler/files/thumbnail/' + file.name + '" class="thumbnail img-active" /><div class="block"><button class="btn btn-primary btn-xs" type="button" name="deleteImageEditNew_' + basename + '" onclick="deleteImageEditNew(\'' + file.name + '\', \'' + basename + '\')"><span class="glyphicon glyphicon-trash"></span></button></div></div>').appendTo('#logo-edit'); // Вставляем лого
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
                                $('.progress-bar').html('<?php echo lang('download_complete') ?>');
                                $('.progress-bar').removeClass('progress-bar progress-bar-warning progress-bar-striped active').addClass('progress-bar progress-bar-success');
                            }, 1000);
                        }
                    }
                }).prop('disabled', !$.support.fileInput)
                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
            });
        </script>

        <!--Удаление изображений-->
        <script type="text/javascript" language="javascript">
            $(this).on('show.bs.modal', function (event) {
                // Отправка запроса для очистки временных файлов
                jQuery.post('<?php echo $url ?>', // отправка данных POST
                        {file_upload: 'empty'});
            });

            // Очищаем модальное окно и hidden input при закрытии
            $(this).on('hidden.bs.modal', function () {
                $('.progress-bar').css('width', 0 + '%');
                $('.file-upload').empty();
                $('.files').empty();
                $('#delete_image').val('');
                $('#image_id').val('');
                $('#general_image').val('');
                //$(this).find('form').trigger('reset'); // Очищаем формы
            });

            // Выборочное удаление изображений в модальном окне "Редактировать"
            function deleteImageEdit(image, id, num) {
                // Удаляем изображение
                $('#image_edit_' + num).detach();
                // Меняем значение в hidden input
                $('#delete_image').val($('#delete_image').val() + image + ',');
                $('#image_id').val(id);
            }

            // Выборочное удаление новых не сохранненных изображений в модальном окне "Добавить"
            function deleteImageAddNew(image, num) {
                jQuery.post('<?php echo $url ?>', // отправка данных POST
                        {delete_image: image,
                            delete_new_image: 'ok'},
                        AjaxSuccess);
                function AjaxSuccess(data) {
                    // Удаляем изображение
                    $('#image_add_new_' + num).detach();
                }
            }

            // Выборочное удаление новых не сохранненных изображений в модальном окне "Редактировать"
            function deleteImageEditNew(image, num) {
                jQuery.post('<?php echo $url ?>', // отправка данных POST
                        {delete_image: image,
                            delete_new_image: 'ok'},
                        AjaxSuccess);
                function AjaxSuccess(data) {
                    // Удаляем изображение
                    $('#image_edit_new_' + num).detach();
                }
            }
            
            // Главное изображение в модальном окне "Редактировать"
            function imageGeneralEdit(image, id, num) {
                    $('img').removeClass('img-active');
                    $('#general_' + num).addClass('img-active');
                    // Меняем значение в hidden input
                    $('#general_image').val(image);
                    $('#image_id').val(id);
            }
        </script>
        
        <?php
    }

}

?>
