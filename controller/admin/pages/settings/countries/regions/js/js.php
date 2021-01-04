<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- Загрузка данных в модальное окно -->
<script type="text/javascript">
    $('#index').on('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var modal_id = Number(button.dataset.edit); // Получаем ID из data-edit при клике на кнопку редактирования
        if (Number.isInteger(modal_id)) {
            // Получаем массивы данных
            var json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsondata);
            document.querySelector('#edit').value = modal_id;
            document.querySelector('#add').value = '';

            // Ищем id и добавляем данные
            for (var x = 0; x < json_data.name.length; x++) {
                document.querySelector('#name_regions_' + x).value = json_data.name[x][modal_id];
            }

            document.querySelector('#region_code_regions').value = json_data.region_code[modal_id];
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
