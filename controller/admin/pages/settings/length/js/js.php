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
<?php if (isset($name)) { ?>
    <!-- Загрузка данных в модальное окно -->
    <script type="text/javascript">
        $('#index').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
            if (Number.isInteger(modal_id)) {
                $('#default_length').bootstrapSwitch('destroy', true);
                // Получаем массивы данных
                var name = $('div#ajax_data').data('name');
                var code = $('div#ajax_data').data('code');
                var value_length = $('div#ajax_data').data('value');
                var status = $('div#ajax_data').data('status');

                $('#edit').val(modal_id);
                $('#add').val('');

                // Ищем id и добавляем данные
                for (x = 0; x < name.length; x++) {
                    $('#name_length_' + x).val(name[x][modal_id]);
                    $('#code_length_' + x).val(code[x][modal_id]);
                }

                $('#value_length').val(value_length[modal_id]);
                // Меняем значение чекбокса
                $('#default_length').prop('checked', status[modal_id]);
                $('#default_length').bootstrapSwitch();
            } else {
                $('#edit').val('');
                $('#add').val('ok');
                //Очищаем поля
                $(this).find('form').trigger('reset');
                // Меняем значение чекбокса
                $('#default_length').prop('checked', '1');
            }
        });
    </script>
    <?php
}
// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');
?>

