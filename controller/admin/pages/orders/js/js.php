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
        $('#invoice').empty();
        $('#status_history').empty();

        // Получаем данные из data div
        var orders_edit = $('div#ajax_data').data('orders')[modal_id];
        var customer_data = $.parseJSON(orders_edit['customer_data']);
        var invoice = $.parseJSON(orders_edit['invoice']);
        var order_total = $.parseJSON(orders_edit['order_total']);
        var address_book = $.parseJSON(customer_data['address_book']);
        var history_status = $.parseJSON(orders_edit['orders_status_history'])['admin'];
        var shipping_method = $.parseJSON(orders_edit['shipping_method'])['admin'];
        var payment_method = $.parseJSON(orders_edit['payment_method'])['admin'];

        // Описание
        // #Клиент
        $('#description_client_name').html(customer_data['firstname'] + ' ' + customer_data['lastname']);
        $('#description_client_phone').html(customer_data['telephone']);
        $('#description_client_email').html(customer_data['email']);
        // #Метод оплаты
        $('#description_payment_method').html(payment_method);
        // #Доставка
        $('#description_shipping_method').html('<b>' + shipping_method + '</b>');
        $('#description_shipping_country').html(address_book['zip'] + ', ' + address_book['country'] + ', ' + address_book['region']);
        $('#description_shipping_address').html(address_book['city'] + ', ' + address_book['address']);
        // #Платежный адрес
        $('#description_payment_country').html(address_book['zip'] + ', ' + address_book['country'] + ', ' + address_book['region']);
        $('#description_payment_address').html(address_book['city'] + ', ' + address_book['address']);
        // #Статус
        $('#description_date_purchased').html(history_status[0] + ': ' + orders_edit['date_purchased']);
        // #Итого
        $('#description_order_total').html(order_total['admin_total_with_shipping_format']);
        
        // Товары
        for (x = 0; x < invoice.length; x++) {
            $("#invoice").append('<tr class="bg-success">\n\
                                        <td class="text-left"><small>' + invoice[x]['admin_name'] + '</small></td>\n\
                                        <td class="text-center"><small>' + invoice[x]['admin_price'] + '</small></td>\n\
                                        <td class="text-center"><small>' + invoice[x]['quantity'] + ' ' + invoice[x]['unit'] + '</small></td>\n\
                                        <td class="text-right"><small>' + invoice[x]['admin_amount'] + '</small></td>\n\
                                  </tr>');
        }
        
        $('#invoice_shipping_method').html('<b>' + orders_edit['shipping_method'] + '</b>');
        $('#invoice_shipping_price').html(order_total['admin_shipping_price_format']);
        $('#invoice_order_total').html(order_total['admin_total_format']);
        $('#invoice_order_total_with_shipping').html(order_total['admin_total_with_shipping_format']);
        
        // История статусов
        for (x = 0; x < history_status.length; x++) {
            $("#status_history").append('<span class="glyphicon glyphicon-ok"></span> <span class="label label-success">' + history_status[x] + '</span><br>');
        }
        
        
        $('#js_edit').val(modal_id);
    });
</script>
<?php
// Подгружаем Ajax Добавить, Редактировать, Удалить
\eMarket\Ajax::action('');
?>
