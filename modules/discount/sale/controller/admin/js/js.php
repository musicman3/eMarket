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
<script type="text/javascript" src="/view/<?php echo \eMarket\Set::template() ?>/js/classes/smartdatepicker.js"></script>

<!-- Smart Datepicker" -->
<script type="text/javascript">
    new SmartDatepicker('<?php echo lang('meta-language') ?>');
</script>

<?php if (isset($name)) { ?>
    <!-- Загрузка данных в модальное окно -->
    <script type="text/javascript">
        $('#index').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования

            if (Number.isInteger(modal_id)) {
                $('#default_module').bootstrapSwitch('destroy', true);
                // Получаем массивы данных
                var name = $('div#ajax_data').data('name');
                var value = $('div#ajax_data').data('value');
                var start = $('div#ajax_data').data('start');
                var end = $('div#ajax_data').data('end');
                var default_var = $('div#ajax_data').data('default');

                // Ищем id и добавляем данные
                for (x = 0; x < name.length; x++) {
                    $('#name_module_' + x).val(name[x][modal_id]);
                }

                $('#sale_value').val(value[modal_id]);
                $('#edit').val(modal_id);
                $('#add').val('');

                // Устанавливаем SmartDatepicker
                var day_start = new Date(start[modal_id]);
                if (button.data('edit') !== undefined) {
                    $('#start_date').datepicker('setDate', day_start);
                    $('#end_date').datepicker('setDate', new Date(end[modal_id]));
                    if (day_start.setDate(day_start.getDate()) < new Date()) {
                        $('#start_date').datepicker('setStartDate', new Date());
                        $('#start_date').datepicker('setDate', new Date());
                    }
                }

                // Меняем значение чекбокса
                $('#default_module').prop('checked', default_var[modal_id]);
                $('#default_module').bootstrapSwitch();
            }
            if (modal_id === 'add') {
                $('#edit').val('');
                $('#add').val('ok');
                //Очищаем поля
                $(this).find('form').trigger('reset');
                // Меняем значение чекбокса
                $('#default_module').prop('checked', '1');
            }
        });
    </script>
    <?php
}
?>

