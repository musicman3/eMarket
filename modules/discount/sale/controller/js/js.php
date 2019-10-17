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
<script type="text/javascript">
    $('#start_date, #start_date_edit, #end_date, #end_date_edit').datepicker({
        language: "<?php echo lang('meta-language') ?>",
        autoclose: true,
        updateViewDate: false,
        clearBtn: true,
        calendarWeeks: true
    });
</script>
<script type="text/javascript">
    $('#default_weight').bootstrapSwitch();
</script>
<?php if (isset($name_edit)) { ?>
    <!-- Загрузка данных в модальное окно -->
    <script type="text/javascript">
        $('#edit').on('show.bs.modal', function (event) {
            $('#default_weight_edit').bootstrapSwitch('destroy', true);
            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
            // Получаем массивы данных
            var name_edit = $('div#ajax_data').data('name');
            var code_edit = $('div#ajax_data').data('code');
            var value_weight_edit = $('div#ajax_data').data('weight');
            var status = $('div#ajax_data').data('status');

            // Ищем id и добавляем данные
            for (x = 0; x < name_edit.length; x++) {
                $('#name_weight_edit_' + x).val(name_edit[x][modal_id]);
                $('#code_weight_edit_' + x).val(code_edit[x][modal_id]);
            }

            $('#value_weight_edit').val(value_weight_edit[modal_id]);
            $('#js_edit').val(modal_id);
            // Меняем значение чекбокса
            $('#default_weight_edit').prop('checked', status[modal_id]);
            $('#default_weight_edit').bootstrapSwitch();
        });
    </script>
<?php
}
?>

