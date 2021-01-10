<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<link rel="stylesheet" href="/ext/bootstrap-switch/css/bootstrap-switch.min.css" type="text/css"/>
<script type="text/javascript" src="/ext/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $('#tax_type, #fixed').bootstrapSwitch();
</script>
<!-- Загрузка данных в модальное окно -->
<script type="text/javascript">
    $('#index').on('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var modal_id = Number(button.dataset.edit); // Получаем ID из data-edit при клике на кнопку редактирования
        if (Number.isInteger(modal_id)) {
            $('#tax_type, #fixed').bootstrapSwitch('destroy', true);
            // Получаем массивы данных
            var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsondata);

            document.querySelector('#edit').value = modal_id;
            document.querySelector('#add').value = '';

            // Ищем id и добавляем данные
            for (var x = 0; x < json_data.name.length; x++) {
                document.querySelector('#name_taxes_' + x).value = json_data.name[x][modal_id];
            }
            document.querySelector('#rate_taxes').value = json_data.rate[modal_id];
            document.querySelector('#tax_type').checked = json_data.tax_type[modal_id];
            document.querySelector('#fixed').checked = json_data.fixed[modal_id];
            $('#tax_type, #fixed').bootstrapSwitch();
            
            document.querySelector('#zones_id').innerHTML = '';

            json_data.zones.forEach((value) => {
                document.querySelector('#zones_id').insertAdjacentHTML('beforeend', '<option value="' + value.id + '">' + value.name + '</option>');
            });

            if (json_data.zones_id[modal_id] !== undefined && json_data.zones_id[modal_id] !== null) {
                document.querySelector('#zones_id option[value="' + json_data.zones_id[modal_id] + '"]').selected = true;
            }

        } else {
            
            document.querySelector('#edit').value = '';
            document.querySelector('#add').value = 'ok';
            //Очищаем поля
            document.querySelector('form').reset();
            
            var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsondata);
            document.querySelector('#zones_id').innerHTML = '';

            json_data.zones.forEach((value) => {
                document.querySelector('#zones_id').insertAdjacentHTML('beforeend', '<option value="' + value.id + '">' + value.name + '</option>');
            });

        }
    });
</script>

<script type="text/javascript" src="/model/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>