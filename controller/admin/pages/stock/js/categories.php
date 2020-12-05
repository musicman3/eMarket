<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- Модальное окно "Добавить категорию" -->
<script type="text/javascript">
    function callAdd() {
        $('#attributes').val(sessionStorage.getItem('attributes'));

        var msg = $('#form_add').serialize();
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'POST',
            url: '?route=stock',
            data: msg,
            beforeSend: function (data) {
                $('#index').modal('hide');
                GroupAttributes.clearAttributes();
            }
        });
        // Отправка запроса для обновления страницы
        jQuery.get('?route=stock',
                {parent_down: <?php echo $parent_id ?>,
                    message: 'ok'},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            setTimeout(function () {
                $('#ajax').replaceWith($(data).find('#ajax'));
                Mouse.sortInitAll();
            }, 100);
        }
    }
</script>  