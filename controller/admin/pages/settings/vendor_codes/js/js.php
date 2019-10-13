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
<?php if (isset($name_edit)) { ?>
    <!-- Загрузка данных в модальное окно -->
    <script type="text/javascript">
        $('#edit').on('show.bs.modal', function (event) {
            $('#default_vendor_code_edit').bootstrapSwitch('destroy', true);
            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
            // Получаем массивы данных
            var name_edit = $('div#ajax_data').data('name');
            var code_edit = $('div#ajax_data').data('code');
            var vendor_edit = $('div#ajax_data').data('vendor');

            // Ищем id и добавляем данные
            for (x = 0; x < name_edit.length; x++) {
                $('#name_vendor_codes_edit_' + x).val(name_edit[x][modal_id]);
                $('#vendor_code_edit_' + x).val(code_edit[x][modal_id]);
            }

            $('#js_edit').val(modal_id);
            $('#default_vendor_code_edit').prop('checked', vendor_edit[modal_id]);
            $('#default_vendor_code_edit').bootstrapSwitch();
        });
    </script>
    <?php
}
// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Other\Ajax::action('');

?>


