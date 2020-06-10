<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $('#default_length').bootstrapSwitch();
</script>
<?php if (isset($name_edit)) { ?>
    <!-- Загрузка данных в модальное окно -->
    <script type="text/javascript">
        $('#index').on('show.bs.modal', function (event) {
            $('#default_length').bootstrapSwitch('destroy', true);
            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
            if (Number.isInteger(modal_id)) {
                // Получаем массивы данных
                var name_edit = $('div#ajax_data').data('name');
                var code_edit = $('div#ajax_data').data('code');
                var value_length_edit = $('div#ajax_data').data('value');
                var status = $('div#ajax_data').data('status');

                $('#edit').val(modal_id);
                $('#add').val('');

                // Ищем id и добавляем данные
                for (x = 0; x < name_edit.length; x++) {
                    $('#name_length_' + x).val(name_edit[x][modal_id]);
                    $('#code_length_' + x).val(code_edit[x][modal_id]);
                }

                $('#value_length').val(value_length_edit[modal_id]);
                // Меняем значение чекбокса
                $('#default_length').prop('checked', status[modal_id]);
                $('#default_length').bootstrapSwitch();
            } else {
                $('#edit').val('');
                $('#add').val('ok');
                //Очищаем поля
                $('.input-sm').val('');
                // Меняем значение чекбокса
                $('#default_length').prop('checked', '1');
                $('#default_length').bootstrapSwitch();
            }
        });
    </script>
    <?php
}
// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');
?>

