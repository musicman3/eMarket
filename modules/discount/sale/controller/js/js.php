<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- Инициализация bootstrap-switch -->
<script type="text/javascript">
    $('#default_module').bootstrapSwitch();
    $('#default_module_edit').bootstrapSwitch();
</script>

<!-- Bootstrap Datepicker" -->
<script type="text/javascript" src="/ext/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<link href="/ext/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
<script type="text/javascript" src="/ext/bootstrap-datepicker/locales/bootstrap-datepicker.<?php echo lang('meta-language') ?>.min.js"></script>
<script type="text/javascript" src="/view/<?php echo \eMarket\Set::template() ?>/js/classes/smartdatepicker.js"></script>

<!-- Smart Datepicker" -->
<script type="text/javascript">
    new Smart().datepicker ('<?php echo lang('meta-language') ?>');
</script>

<?php if (isset($name_edit)) { ?>
    <!-- Загрузка данных в модальное окно -->
    <script type="text/javascript">
        $('#edit').on('show.bs.modal', function (event) {
            $('#default_module_edit').bootstrapSwitch('destroy', true);
            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
            if (modal_id === undefined) {
                modal_id = $('#js_edit').val();
            }
            // Получаем массивы данных
            var name_edit = $('div#ajax_data').data('name');
            var value_edit = $('div#ajax_data').data('value');
            var start_edit = $('div#ajax_data').data('start');
            var end_edit = $('div#ajax_data').data('end');
            var default_edit = $('div#ajax_data').data('default');

            // Ищем id и добавляем данные
            for (x = 0; x < name_edit.length; x++) {
                $('#name_module_edit_' + x).val(name_edit[x][modal_id]);
            }

            $('#sale_value_edit').val(value_edit[modal_id]);
            $('#js_edit').val(modal_id);

            // Устанавливаем Datepicker
            if (button.data('edit') !== undefined) {
                $('#start_date_edit').datepicker('setDate', new Date(start_edit[modal_id]));
                $('#end_date_edit').datepicker('setDate', new Date(end_edit[modal_id]));
            }

            // Меняем значение чекбокса
            $('#default_module_edit').prop('checked', default_edit[modal_id]);
            $('#default_module_edit').bootstrapSwitch();
        });
    </script>
    <?php
}
?>

