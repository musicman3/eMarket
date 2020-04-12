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
        var invoice = $.parseJSON(orders_edit['invoice']);
        var order_total = $.parseJSON(orders_edit['order_total']);
        // Описание
        $('#client_name').html(customer_data['firstname'] + ' ' + customer_data['lastname']);
        $('#client_phone').html(customer_data['telephone']);
        $('#client_email').html(customer_data['email']);
        $('#order_date_purchased').html(orders_edit['date_purchased']);
        $('#description_order_total').html(order_total['total_with_shipping_format']);
        // Товары
        for (x = 0; x < invoice.length; x++) {
            $("#invoice").append('<tr class="bg-success">\n\
                                        <td class="text-left"><small>' + invoice[x]['name'] + '</small></td>\n\
                                        <td class="text-center"><small>' + invoice[x]['price'] + '</small></td>\n\
                                        <td class="text-center"><small>' + invoice[x]['quantity'] + ' ' + invoice[x]['unit'] + '</small></td>\n\
                                        <td class="text-right"><small>' + invoice[x]['amount'] + '</small></td>\n\
                                  </tr>');
        }

        $('#invoice_order_total_with_shipping').html(order_total['total_with_shipping_format']);
        $('#invoice_order_total').html(order_total['total_format']);
        $('#invoice_shipping_price').html(order_total['shipping_price_format']);

        $('#js_edit').val(modal_id);
    });
</script>
<?php
// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');
?>
