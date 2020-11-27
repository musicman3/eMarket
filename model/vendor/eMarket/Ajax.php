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
        <script type="text/javascript">
            // Модальное окно "Добавить"
            function callAdd(name, url) {
                if (name === undefined) {
                    var msg = $('#form_add').serialize();
                } else {
                    var msg = $('#' + name).serialize();
                }
                jQuery.ajaxSetup({async: false});
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $url ?>',
                    data: msg,
                    beforeSend: function () {
                        $('.modal').modal('hide');
                    }
                });
                jQuery.get('<?php echo $url ?>',
                        {modify: 'update_ok'},
                        AjaxSuccess);
                function AjaxSuccess(data) {
                    setTimeout(function () {
                        if (url === undefined) {
                            document.location.href = window.location.href;
                        } else {
                            document.location.href = url;
                        }
                    }, 100);
                }
            }

            // Модальное окно "Редактировать"
            function callEdit(url) {
                var msg = $('#form_edit').serialize();
                jQuery.ajaxSetup({async: false});
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $url ?>',
                    data: msg,
                    beforeSend: function () {
                        $('.modal').modal('hide');
                    }
                });
                jQuery.get('<?php echo $url ?>',
                        {modify: 'update_ok'},
                        AjaxSuccess);
                function AjaxSuccess(data) {
                    setTimeout(function () {
                        if (url === undefined) {
                            document.location.href = window.location.href;
                        } else {
                            document.location.href = url;
                        }
                    }, 100);
                }
            }

            // Функция "Удалить"
            function callDelete(id, url) {
                var msg = $('#form_delete' + id).serialize();
                jQuery.ajaxSetup({async: false});
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $url ?>',
                    data: msg,
                    success: function () {
                        // Пустой запрос
                    }
                });
                jQuery.get('<?php echo $url ?>',
                        {modify: 'update_ok'},
                        AjaxSuccess);
                function AjaxSuccess(data) {
                    setTimeout(function () {
                        if (url === undefined) {
                            document.location.href = window.location.href;
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
