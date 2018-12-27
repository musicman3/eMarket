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
                function AjaxSuccess() {
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
                function AjaxSuccess() {
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
                function AjaxSuccess() {
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
    public function file_upload() {

        ?>
        <!--Подгружаем jQuery File Upload -->
        <script src = "/ext/jquery_file_upload/js/vendor/jquery.ui.widget.js"></script>
        <script src="/ext/jquery_file_upload/js/jquery.iframe-transport.js"></script>
        <script src="/ext/jquery_file_upload/js/jquery.fileupload.js"></script>
        <script>
            $(function () {
                'use strict';
                var url = '/downloads/upload_handler/';
                $('#fileupload').fileupload({
                    url: url,
                    dataType: 'json',
                    done: function (e, data) {
                        $.each(data.result.files, function (index, file) {
                            $('<span/>').html('<img src="/downloads/upload_handler/files/thumbnail/' + file.name + '" />').appendTo('#files');
                        });
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                                'width',
                                progress + '%'
                                );
                    }
                }).prop('disabled', !$.support.fileInput)
                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
            });
        </script>

        <?php
    }

}

?>