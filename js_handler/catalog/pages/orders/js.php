<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript">
    $('#index').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);
        var modal_id = button.data('edit');
        $('#invoice').empty();
        $('#status_history').empty();

        var orders_edit = $('div#ajax_data').data('orders')[modal_id];
        var customer_data = JSON.parse(orders_edit['customer_data']);
        var invoice = JSON.parse(orders_edit['invoice']);
        var order_total = JSON.parse(orders_edit['order_total']);
        var address_book = JSON.parse(customer_data['address_book']);
        var history_status = JSON.parse(orders_edit['orders_status_history']);
        var shipping_method = JSON.parse(orders_edit['shipping_method'])['customer'];
        var payment_method = JSON.parse(orders_edit['payment_method'])['customer'];

        $('#title').html('<?php echo lang('orders_number') ?>: ' + orders_edit['id']);

        $('#description_client_name').html(customer_data['firstname'] + ' ' + customer_data['lastname']);
        $('#description_client_phone').html(customer_data['telephone']);
        $('#description_client_email').html(orders_edit['email']);

        $('#description_payment_method').html(payment_method);

        $('#description_shipping_method').html('<b>' + shipping_method + '</b>');
        $('#description_shipping_country').html(address_book['zip'] + ', ' + address_book['country'] + ', ' + address_book['region']);
        $('#description_shipping_address').html(address_book['city'] + ', ' + address_book['address']);

        $('#description_billing_country').html(address_book['zip'] + ', ' + address_book['country'] + ', ' + address_book['region']);
        $('#description_billing_address').html(address_book['city'] + ', ' + address_book['address']);

        $('#description_date_purchased').html(history_status[0]['customer']['status'] + ': ' + history_status[0]['customer']['date']);

        $('#description_order_total').html(order_total['customer']['total_to_pay_format']);

        for (x = 0; x < invoice.length; x++) {
            if (invoice[x]['customer']['stiker'] !== null && invoice[x]['customer']['stiker'] !== undefined) {
                var stiker = invoice[x]['customer']['stiker'];
            } else {
                var stiker = '';
            }
            $("#invoice").append('<tr class="bg-success text-white">\n\
                                        <td class="text-end"><span class="badge bg-success">' + stiker + '</span></td>\n\
                                        <td class="text-center"><small>' + invoice[x]['customer']['name'] + '</small></td>\n\
                                        <td class="text-center"><small>' + invoice[x]['customer']['price'] + '</small></td>\n\
                                        <td class="text-center"><small>' + invoice[x]['data']['quantity'] + ' ' + invoice[x]['customer']['unit'] + '</small></td>\n\
                                        <td class="text-end"><small>' + invoice[x]['customer']['amount'] + '</small></td>\n\
                                  </tr>');
        }

        $('#invoice_shipping_method').html('<b>' + shipping_method + '</b>');
        $('#invoice_shipping_price').html(order_total['customer']['shipping_price_format']);
        $('#invoice_order_total').html(order_total['customer']['total_format']);

        if (Number(order_total['data']['order_total_tax']) > 0) {
            $('#invoice_taxes').html(order_total['customer']['order_total_tax_format']);
        }
        if (Number(order_total['data']['order_total_tax']) === 0) {
            $('#invoice_taxes').html('<?php echo lang('orders_price_including_all_taxes') ?>');
        }

        $('#invoice_order_total_to_pay').html(order_total['customer']['total_to_pay_format']);

        for (x = 0; x < history_status.length; x++) {
            $("#status_history").append('<span class="bi-check"></span><small> ' + history_status[x]['customer']['date'] + ' </small><span class="badge bg-success">' + history_status[x]['customer']['status'] + '</span><br>');
        }

    });
</script>

