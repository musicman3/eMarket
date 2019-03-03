<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<?php if (isset($name_edit)) { ?>
    <!-- Загрузка данных в модальное окно -->
    <script type="text/javascript">
        $('#edit').on('show.bs.modal', function (event) {
            
            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
            // Получаем массивы данных
            var name_edit = $('div#ajax_data').data('name');
            var alpha_2 = $('div#ajax_data').data('alpha2');
            var alpha_3 = $('div#ajax_data').data('alpha3');
            var address_format = $('div#ajax_data').data('address');

            // Ищем id и добавляем данные
            for (x = 0; x < name_edit.length; x++) {
                $('#name_countries_edit_' + x).val(name_edit[x][modal_id]);
            }

            $('#alpha_2_countries_edit').val(alpha_2[modal_id]);
            $('#alpha_3_countries_edit').val(alpha_3[modal_id]);
            $('#address_format_countries_edit').val(address_format[modal_id]);
            $('#js_edit').val(modal_id);
        });
    </script>
<?php
}
// Подгружаем Ajax Добавить, Редактировать, Удалить
$AJAX->action('');
?>
