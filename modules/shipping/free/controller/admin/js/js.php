<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (isset($shipping_zone)) {
    ?>
    <!-- Загрузка данных в модальное окно -->
    <script type="text/javascript">
        $('#index').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования
            if (Number.isInteger(modal_id)) {
                // Получаем массивы данных
                var zone = $('div#ajax_data').data('zone');
                var minimum_price = $('div#ajax_data').data('price');

                $('#zone').val(zone[modal_id]);
                $('#minimum_price').val(minimum_price[modal_id]);
                $('#edit').val(modal_id);
                $('#add').val('');
            } else {
                $('#edit').val('');
                $('#add').val('ok');
                //Очищаем поля
                $(this).find('form').trigger('reset');

            }
        });
    </script>
    <?php
}

// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');
?>


