<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $('#default_value_currencies').bootstrapSwitch();
</script>
<?php if (isset($name)) { ?>
    <!-- Загрузка данных в модальное окно -->
    <script type="text/javascript">
        $('#index').on('show.bs.modal', function (event) {
            $('#default_value_currencies').bootstrapSwitch('destroy', true);
            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
            if (Number.isInteger(modal_id)) {
                // Получаем массивы данных
                var name = $('div#ajax_data').data('name');
                var code = $('div#ajax_data').data('code');
                var iso_4217 = $('div#ajax_data').data('iso4217');
                var value = $('div#ajax_data').data('value');
                var symbol = $('div#ajax_data').data('symbol');
                var symbol_position = $('div#ajax_data').data('position');
                var decimal_places = $('div#ajax_data').data('decimal');
                var status = $('div#ajax_data').data('status');

                $('#edit').val(modal_id);
                $('#add').val('');

                // Ищем id и добавляем данные
                for (x = 0; x < name.length; x++) {
                    $('#name_currencies_' + x).val(name[x][modal_id]);
                    $('#code_currencies_' + x).val(code[x][modal_id]);
                }

                $('#iso_4217_currencies').val(iso_4217[modal_id]);
                $('#value_currencies').val(value[modal_id]);
                $('#symbol_currencies').val(symbol[modal_id]);
                $('#decimal_places_currencies').val(decimal_places[modal_id]);
                // Меняем значение чекбокса
                $('#default_value_currencies').prop('checked', status[modal_id]);
                $('#default_value_currencies').bootstrapSwitch();
                // Выбираем установленный селект
                if (symbol_position[modal_id] === 'left') {
                    $('#symbol_position_currencies option[value="left"]').prop('selected', true);
                } else {
                    $('#symbol_position_currencies option[value="right"]').prop('selected', true);
                }
            } else {
                $('#edit').val('');
                $('#add').val('ok');
                //Очищаем поля
                $('.input-sm').val('');
                // Меняем значение чекбокса
                $('#symbol_position_currencies').val('left').prop('selected', true);
                $('#default_value_currencies').prop('checked', '1');
                $('#default_value_currencies').bootstrapSwitch();
            }
        });
    </script>
    <?php
}
// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');
?>

