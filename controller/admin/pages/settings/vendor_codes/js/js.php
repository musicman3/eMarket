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
<?php if (isset($name)) { ?>
    <!-- Загрузка данных в модальное окно -->
    <script type="text/javascript">
        $('#index').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
            if (Number.isInteger(modal_id)) {
                $('#default_vendor_code').bootstrapSwitch('destroy', true);
                // Получаем массивы данных
                var name = $('div#ajax_data').data('name');
                var code = $('div#ajax_data').data('code');
                var vendor = $('div#ajax_data').data('vendor');
                
                $('#edit').val(modal_id);
                $('#add').val('');

                // Ищем id и добавляем данные
                for (x = 0; x < name.length; x++) {
                    $('#name_vendor_codes_' + x).val(name[x][modal_id]);
                    $('#vendor_code_' + x).val(code[x][modal_id]);
                }

                $('#default_vendor_code').prop('checked', vendor[modal_id]);
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
    <?php
}
// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');
?>


