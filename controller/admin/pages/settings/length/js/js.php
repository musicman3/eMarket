<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<?php if (isset($name_edit)) { ?>
    <!-- Загрузка данных в модальное окно -->
    <script type="text/javascript">
        $('#edit').on('show.bs.modal', function (event) {
            
            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
            // Получаем массивы данных
            var name_edit = $('div#ajax_data').data('name');
            var code_edit = $('div#ajax_data').data('code');
            var value_length_edit = $('div#ajax_data').data('value');
            var status = $('div#ajax_data').data('status');

            // Ищем id и добавляем данные
            for (x = 0; x < name_edit.length; x++) {
                $('#name_length_edit_' + x).val(name_edit[x][modal_id]);
                $('#code_length_edit_' + x).val(code_edit[x][modal_id]);
            }

            $('#value_length_edit').val(value_length_edit[modal_id]);
            $('#js_edit').val(modal_id);
            // Меняем значение чекбокса
            $('#default_length_edit').prop('checked', status[modal_id]);
        });
    </script>
<?php
}
// Подгружаем Ajax Добавить, Редактировать, Удалить
$AJAX->action('');
?>

