<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- Bootstrap Datepicker" -->
<script type="text/javascript" src="/ext/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<link href="/ext/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
<script type="text/javascript" src="/ext/bootstrap-datepicker/locales/bootstrap-datepicker.<?php echo lang('meta-language') ?>.min.js"></script>
<script type="text/javascript" src="/model/js/classes/smartdatepicker.js"></script>

<script type="text/javascript">
    new SmartDatepicker('<?php echo lang('meta-language') ?>');
    $('#default_module').bootstrapSwitch();
</script>

<!-- Загрузка данных в модальное окно -->
<script type="text/javascript">
    $('#index').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);
        var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования

        if (Number.isInteger(modal_id)) {
            $('#default_module').bootstrapSwitch('destroy', true);
            // Получаем массивы данных
            var json_data = $('div#ajax_data').data('jsondata');

            // Ищем id и добавляем данные
            for (x = 0; x < json_data['name'].length; x++) {
                $('#name_module_' + x).val(json_data['name'][x][modal_id]);
            }

            $('#sale_value').val(json_data['value'][modal_id]);
            $('#edit').val(modal_id);
            $('#add').val('');

            // Устанавливаем SmartDatepicker
            var day_start = new Date(json_data['start'][modal_id]);
            if (button.data('edit') !== undefined) {
                $('#start_date').datepicker('setDate', day_start);
                $('#end_date').datepicker('setDate', new Date(json_data['end'][modal_id]));
                if (day_start.setDate(day_start.getDate()) < new Date()) {
                    $('#start_date').datepicker('setStartDate', new Date());
                    $('#start_date').datepicker('setDate', new Date());
                }
            }

            // Меняем значение чекбокса
            $('#default_module').prop('checked', json_data['default'][modal_id]);
            $('#default_module').bootstrapSwitch();
        }

        if (!Number.isInteger(modal_id) && button.data('toggle') === 'modal') {
            $('#edit').val('');
            $('#add').val('ok');
            //Очищаем поля
            $(this).find('form').trigger('reset');
            // Меняем значение чекбокса
            $('#default_module').prop('checked', '1');
        }
    });
</script>

