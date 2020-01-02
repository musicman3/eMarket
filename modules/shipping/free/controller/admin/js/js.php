<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (isset($shipping_zone_edit)) {
    ?>
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
            var zone_edit = $('div#ajax_data').data('zone');
            var minimum_price_edit = $('div#ajax_data').data('price');

            $('#zone_edit').val(zone_edit[modal_id]);
            $('#minimum_price_edit').val(minimum_price_edit[modal_id]);
            $('#js_edit').val(modal_id);
        });
    </script>
    <?php
}

// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');
?>


