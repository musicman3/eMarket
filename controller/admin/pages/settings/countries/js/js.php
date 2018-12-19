<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<?php if (isset($name_edit)) { ?>
<!-- Загрузка данных в модальное окно -->
<script type="text/javascript" language="javascript">
    $('#edit').on('show.bs.modal', function (event) {
        var modal = $(this);
        var button = $(event.relatedTarget);
        var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
        // Получаем массивы данных
        var name_edit = <?php echo $name_edit ?>;
        var alpha_2 = <?php echo $alpha_2 ?>;
        var alpha_3 = <?php echo $alpha_3 ?>;
        var address_format = <?php echo $address_format ?>;

        // Ищем классы и меняем данные
        for (x = 0; x < name_edit.length; x++) {
            modal.find('.name_edit' + x).val(name_edit[x][modal_id]);
        }

        modal.find('.alpha_2').val(alpha_2[modal_id]);
        modal.find('.alpha_3').val(alpha_3[modal_id]);
        modal.find('.address_format').val(address_format[modal_id]);
        modal.find('.js_edit').val(modal_id);
    });
</script>
<?php } ?>

<!-- Модальное окно "Добавить" -->
<script type="text/javascript" language="javascript">
    function call_add() {
        var msg = $('#form_add').serialize();
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.ajax({
            type: 'POST',
            url: '/controller/admin/pages/settings/countries/index.php',
            data: msg,
            success: function (data) {
                $('#add').modal('hide');
            }
        });
        // Отправка запроса для обновления страницы
        jQuery.get('/controller/admin/pages/settings/countries/index.php', // отправка данных GET
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
            url: '/controller/admin/pages/settings/countries/index.php',
            data: msg,
            success: function (data) {
                $('#edit').modal('hide');
            }
        });
        // Отправка запроса для обновления страницы
        jQuery.get('/controller/admin/pages/settings/countries/index.php', // отправка данных GET
                {modify: 'ok'},
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
            url: '/controller/admin/pages/settings/countries/index.php',
            data: msg,
            success: function (data) {
                // Пустой запрос
            }
        });
        // Отправка запроса для обновления страницы
        jQuery.get('/controller/admin/pages/settings/countries/index.php', // отправка данных GET
                {modify: 'ok'},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            setTimeout(function () {
                document.location.href = '<?php echo $VALID->inSERVER('REQUEST_URI') ?>';
            }, 100);
        }
    }
</script>