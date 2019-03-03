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
            var iso_4217_edit = $('div#ajax_data').data('iso4217');
            var value_edit = $('div#ajax_data').data('value');
            var symbol_edit = $('div#ajax_data').data('symbol');
            var symbol_position_edit = $('div#ajax_data').data('position');
            var decimal_places_edit = $('div#ajax_data').data('decimal');
            var status = $('div#ajax_data').data('status');

            // Ищем id и добавляем данные
            for (x = 0; x < name_edit.length; x++) {
                $('#name_currencies_edit_' + x).val(name_edit[x][modal_id]);
                $('#code_currencies_edit_' + x).val(code_edit[x][modal_id]);
            }
            
            $('#iso_4217_currencies_edit').val(iso_4217_edit[modal_id]);
            $('#value_currencies_edit').val(value_edit[modal_id]);
            $('#symbol_currencies_edit').val(symbol_edit[modal_id]);
            $('#decimal_places_currencies_edit').val(decimal_places_edit[modal_id]);
            $('#js_edit').val(modal_id);
            // Меняем значение чекбокса
            $('#default_value_currencies_edit').prop('checked', status[modal_id]);
            // Выбираем установленный селект
            if (symbol_position_edit[modal_id] === 'left') {
                $('#symbol_position_currencies_edit option[value="left"]').prop('selected', true);
            } else {
                $('#symbol_position_currencies_edit option[value="right"]').prop('selected', true);
            }
        });
    </script>
    <?php
}
// Подгружаем Ajax Добавить, Редактировать, Удалить
$AJAX->action('');

?>

