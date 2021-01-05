<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $('#default_weight').bootstrapSwitch();
</script>

<!-- Загрузка данных в модальное окно -->
<script type="text/javascript">
    $('#index').on('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var modal_id = Number(button.dataset.edit); // Получаем ID из data-edit при клике на кнопку редактирования
        if (Number.isInteger(modal_id)) {
            $('#default_weight').bootstrapSwitch('destroy', true);
            // Получаем массивы данных
            var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsondata);

            document.querySelector('#edit').value = modal_id;
            document.querySelector('#add').value = '';

            // Ищем id и добавляем данные
            for (var x = 0; x < json_data.name.length; x++) {
                document.querySelector('#name_weight_' + x).value = json_data.name[x][modal_id];
                document.querySelector('#code_weight_' + x).value = json_data.code[x][modal_id];
            }

            document.querySelector('#value_weight').value = json_data.value[modal_id];
            // Меняем значение чекбокса
            document.querySelector('#default_weight').checked = json_data.status[modal_id];
            $('#default_weight').bootstrapSwitch();
        } else {
            document.querySelector('#edit').value = '';
            document.querySelector('#add').value = 'ok';
            //Очищаем поля
            document.querySelector('form').reset();
        }
    });
</script>

<script type="text/javascript" src="/model/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>