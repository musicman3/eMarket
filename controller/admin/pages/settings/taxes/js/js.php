<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Загрузка данных в модальное окно -->
<script type="text/javascript">
    $('#index').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);
        var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
        if (Number.isInteger(modal_id)) {
            // Получаем массивы данных
            var json_data = $('div#ajax_data').data('jsondata');

            $('#edit').val(modal_id);
            $('#add').val('');

            // Ищем id и добавляем данные
            for (x = 0; x < json_data['name'].length; x++) {
                $('#name_taxes_' + x).val(json_data['name'][x][modal_id]);
            }
            $('#rate_taxes').val(json_data['code'][modal_id]);
        } else {
            $('#edit').val('');
            $('#add').val('ok');
            //Очищаем поля
            $(this).find('form').trigger('reset');
        }
    });
</script>

<script type="text/javascript" src="/model/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax('');
</script>