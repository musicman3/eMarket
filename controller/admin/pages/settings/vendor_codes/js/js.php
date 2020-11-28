<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $('#default_vendor_code').bootstrapSwitch();
</script>
<!-- Загрузка данных в модальное окно -->
<script type="text/javascript">
    $('#index').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
        if (Number.isInteger(modal_id)) {
            $('#default_vendor_code').bootstrapSwitch('destroy', true);
            // Получаем массивы данных
            var json_data = $('div#ajax_data').data('jsondata');

            $('#edit').val(modal_id);
            $('#add').val('');

            // Ищем id и добавляем данные
            for (x = 0; x < json_data['name'].length; x++) {
                $('#name_vendor_codes_' + x).val(json_data['name'][x][modal_id]);
                $('#vendor_code_' + x).val(json_data['code'][x][modal_id]);
            }

            $('#default_vendor_code').prop('checked', json_data['default'][modal_id]);
            $('#default_vendor_code').bootstrapSwitch();
        } else {
            $('#edit').val('');
            $('#add').val('ok');
            //Очищаем поля
            $(this).find('form').trigger('reset');
            // Меняем значение чекбокса
            $('#default_vendor_code').prop('checked', '1');
        }
    });
</script>

<script type="text/javascript" src="/model/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>
