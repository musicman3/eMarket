<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Класс для Ajax методов
 *
 * @package Ajax
 * @author eMarket
 * 
 */
class Ajax {

    /**
     * Ajax обработка для Добавить, Редактировать, Удалить
     *
     * @param string $url (url страницы обработки)
     */
    public static function action($url) {
        ?>
        <!-- Модальное окно "Добавить" -->
        <script type="text/javascript">
            function callAdd(name, url) {
                if (name === undefined) {
                    var msg = $('#form_add').serialize();
                } else {
                    var msg = $('#' + name).serialize();
                }
                // Установка синхронного запроса для jQuery.ajax
                jQuery.ajaxSetup({async: false});
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $url ?>',
                    data: msg,
                    beforeSend: function () {
                        $('.modal').modal('hide');
                    }
                });
                // Отправка запроса для обновления страницы
                jQuery.get('<?php echo $url ?>',
                        {modify: 'update_ok'},
                        AjaxSuccess);
                // Обновление страницы
                function AjaxSuccess(data) {
                    setTimeout(function () {
                        if (url === undefined) {
                            document.location.href = '<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>';
                        } else {
                            document.location.href = url;
                        }
                    }, 100);
                }
            }
        </script>

        <!-- Модальное окно "Редактировать" -->
        <script type="text/javascript">
            function callEdit(url) {
                var msg = $('#form_edit').serialize();
                // Установка синхронного запроса для jQuery.ajax
                jQuery.ajaxSetup({async: false});
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $url ?>',
                    data: msg,
                    beforeSend: function () {
                        $('.modal').modal('hide');
                    }
                });
                // Отправка запроса для обновления страницы
                jQuery.get('<?php echo $url ?>',
                        {modify: 'update_ok'},
                        AjaxSuccess);
                // Обновление страницы
                function AjaxSuccess(data) {
                    setTimeout(function () {
                        if (url === undefined) {
                            document.location.href = '<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>';
                        } else {
                            document.location.href = url;
                        }
                    }, 100);
                }
            }
        </script>

        <!-- Функция "Удалить" -->
        <script type="text/javascript">
            function callDelete(id, url) {
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
                jQuery.get('<?php echo $url ?>',
                        {modify: 'update_ok'},
                        AjaxSuccess);
                // Обновление страницы
                function AjaxSuccess(data) {
                    setTimeout(function () {
                        if (url === undefined) {
                            document.location.href = '<?php echo \eMarket\Valid::inSERVER('REQUEST_URI') ?>';
                        } else {
                            document.location.href = url;
                        }
                    }, 100);
                }
            }
        </script>

        <?php
    }

}
?>
