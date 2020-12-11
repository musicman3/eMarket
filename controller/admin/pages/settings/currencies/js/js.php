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
<!-- Загрузка данных в модальное окно -->
<script type="text/javascript">
    $('#index').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
        if (Number.isInteger(modal_id)) {
            $('#default_value_currencies').bootstrapSwitch('destroy', true);
            var json_data = $('div#ajax_data').data('jsondata');

            $('#edit').val(modal_id);
            $('#add').val('');

            // Ищем id и добавляем данные
            for (x = 0; x < json_data['name'].length; x++) {
                $('#name_currencies_' + x).val(json_data['name'][x][modal_id]);
                $('#code_currencies_' + x).val(json_data['code'][x][modal_id]);
            }

            $('#iso_4217_currencies').val(json_data['iso_4217'][modal_id]);
            $('#value_currencies').val(json_data['value'][modal_id]);
            $('#symbol_currencies').val(json_data['symbol'][modal_id]);
            $('#decimal_places_currencies').val(json_data['decimal_places'][modal_id]);
            // Меняем значение чекбокса
            $('#default_value_currencies').prop('checked', json_data['default_value'][modal_id]);
            $('#default_value_currencies').bootstrapSwitch();
            // Выбираем установленный селект
            if (json_data['symbol_position'][modal_id] === 'left') {
                $('#symbol_position_currencies option[value="left"]').prop('selected', true);
            } else {
                $('#symbol_position_currencies option[value="right"]').prop('selected', true);
            }
        } else {
            $('#edit').val('');
            $('#add').val('ok');
            //Очищаем поля
            $(this).find('form').trigger('reset');
            // Меняем значение чекбокса
            $('#symbol_position_currencies').val('left').prop('selected', true);
            $('#default_value_currencies').prop('checked', '1');
        }
    });
</script>

<script type="text/javascript" src="/model/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>

