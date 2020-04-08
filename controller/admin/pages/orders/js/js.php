<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!-- Загрузка данных в модальное окно -->
<script type="text/javascript">
    $('#edit').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);
        var modal_id = button.data('edit'); // Получаем ID из data-edit при клике на кнопку редактирования

        // Получаем данные из data div
        var orders_edit = $('div#ajax_data').data('orders')[modal_id];
        var customer_data = $.parseJSON(orders_edit['customer_data']);
        var invoice = $.parseJSON(orders_edit['invoice'])[0];

        $('#client_name').html(customer_data['firstname'] + ' ' + customer_data['lastname']);
        $('#client_phone').html(customer_data['telephone']);
        $('#client_email').html(customer_data['email']);
        $('#order_date_purchased').html(orders_edit['date_purchased']);
        $('#description_order_total').html(invoice['amount']);
        $('#js_edit').val(modal_id);
    });
</script>
<?php
// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');

?>
