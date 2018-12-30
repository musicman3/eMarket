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
            function call_add() {
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
            function call_edit() {
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

        <!-- Модальное окно "Удалить" -->
        <script type="text/javascript" language="javascript">
            function call_delete() {
                var msg = $('#form_delete').serialize();
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
     * @return javascript
     */
    public function fileUpload() {

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
                            $('<span/>').html('<span class="file-upload"><img src="/downloads/upload_handler/files/thumbnail/' + file.name + '" class="img-thumbnail" /> </span>').appendTo('#logo-add');
                            $('<span/>').html('<span class="file-upload"><div class="holder"><img src="/downloads/upload_handler/files/thumbnail/' + file.name + '" class="img-thumbnail" /><div class="block"><button class="btn btn-primary btn-xs" type="button"><span class="glyphicon glyphicon-trash"></span></button></div></div></span>').appendTo('#logo-edit');
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

        <?php
    }

    /**
     * Отправляем POST на удаление временных
     * файлов при открытии модального окна
     * и выборочно удаляем изображения
     *
     * @param $url
     * @return javascript
     */
    public function fileUploadEmpty($url) {

        ?>
        <script type="text/javascript" language="javascript">
            $(this).on('show.bs.modal', function (event) {
                // Отправка запроса для очистки временных файлов
                jQuery.post('<?php echo $url ?>', // отправка данных POST
                        {file_upload: 'empty'});
            });

            // Очищаем модал
            $(this).on('hidden.bs.modal', function () {
                $('.progress-bar').css('width', 0 + '%');
                $('.file-upload').empty();
                $('.files').empty();
                //$(this).find('form').trigger('reset'); // Очищаем формы
            });

            // Выборочное удаление изображений
            function delete_image(image, id, num) {
                // Отправка запроса для обновления страницы
                jQuery.post('<?php echo $url ?>', // отправка данных POST
                        {delete_image: image,
                            delete_image_id: id},
                        AjaxSuccess);
                // Обновление страницы
                function AjaxSuccess(data) {
                    $('#image_' + num).empty();
                }
            }

        </script>
        <?php
    }

}

?>
