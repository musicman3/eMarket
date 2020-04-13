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

        // Получаем данные из data div
        var orders_edit = $('div#ajax_data').data('orders')[modal_id];
        var customer_data = $.parseJSON(orders_edit['customer_data']);
        var invoice = $.parseJSON(orders_edit['invoice']);
        var order_total = $.parseJSON(orders_edit['order_total']);
        var address_book = $.parseJSON(customer_data['address_book']);
        // Описание
        // #Клиент
        $('#description_client_name').html(customer_data['firstname'] + ' ' + customer_data['lastname']);
        $('#description_client_phone').html(customer_data['telephone']);
        $('#description_client_email').html(customer_data['email']);
        // #Метод оплаты
        $('#description_payment_method').html(orders_edit['payment_method']);
        // #Доставка
        $('#description_shipping_method').html('<b>' + orders_edit['shipping_method'] + '</b>');
        $('#description_shipping_country').html(address_book['zip'] + ', ' + address_book['country'] + ', ' + address_book['region']);
        $('#description_shipping_address').html(address_book['city'] + ', ' + address_book['address']);
        // #Платежный адрес
        $('#description_payment_country').html(address_book['zip'] + ', ' + address_book['country'] + ', ' + address_book['region']);
        $('#description_payment_address').html(address_book['city'] + ', ' + address_book['address']);
        // #Статус
        $('#description_date_purchased').html(orders_edit['date_purchased']);
        // #Итого
        $('#description_order_total').html(order_total['total_with_shipping_format']);
        
        // Товары
        $('#invoice_shipping_method').html('<b>' + orders_edit['shipping_method'] + '</b>');
        
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
