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
            var name_edit = <?php echo $name_edit ?>;
            var code_edit = <?php echo $code_edit ?>;
            var value_edit = <?php echo $value_edit ?>;
            var symbol_edit = <?php echo $symbol_edit ?>;
            var symbol_position_edit = <?php echo $symbol_position_edit ?>;
            var decimal_places_edit = <?php echo $decimal_places_edit ?>;
            var status = <?php echo $status_value_edit ?>;

            // Ищем классы и добавляем данные
            for (x = 0; x < name_edit.length; x++) {
                $('#name_edit' + x).val(name_edit[x][modal_id]);
                $('#code_edit' + x).val(code_edit[x][modal_id]);
            }

            $('#value_edit').val(value_edit[modal_id]);
            $('#symbol_edit').val(symbol_edit[modal_id]);
            $('#decimal_places_edit').val(decimal_places_edit[modal_id]);
            $('#js_edit').val(modal_id);
            // Меняем значение чекбокса
            $('#status_value_edit').prop('checked', status[modal_id]);
            // Выбираем установленный селект
            if (symbol_position_edit[modal_id] === 'left') {
                $('#symbol_position_edit option[value="left"]').prop('selected', true);
            } else {
                $('#symbol_position_edit option[value="right"]').prop('selected', true);
            }
        });
    </script>
    <?php
}
// Подгружаем Ajax Добавить, Редактировать, Удалить
$AJAX->action('/controller/admin/pages/settings/currencies/index.php');

?>

