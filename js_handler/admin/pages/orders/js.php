<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript">
    $('#index').on('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var modal_id = Number(button.dataset.edit);

        document.querySelector('#invoice').innerHTML = '';
        document.querySelector('#status_history').innerHTML = '';

        var orders = JSON.parse(document.querySelector('#ajax_data').dataset.orders)[modal_id];
        var customer_data = JSON.parse(orders.customer_data);
        var invoice = JSON.parse(orders.invoice);
        var order_total = JSON.parse(orders.order_total);
        var address_book = JSON.parse(customer_data.address_book);
        var history_status = JSON.parse(orders.orders_status_history);
        var shipping_method = JSON.parse(orders.shipping_method).admin;
        var payment_method = JSON.parse(orders.payment_method).admin;

        document.querySelector('#edit').value = modal_id;

        document.querySelector('#title').innerHTML = '<?php echo lang('orders_number') ?>: ' + orders.id;

        document.querySelector('#description_client_name').innerHTML = customer_data.firstname + ' ' + customer_data.lastname;
        document.querySelector('#description_client_phone').innerHTML = customer_data.telephone;
        document.querySelector('#description_client_email').innerHTML = orders.email;

        document.querySelector('#description_payment_method').innerHTML = payment_method;

        document.querySelector('#description_shipping_method').innerHTML = '<b>' + shipping_method + '</b>';
        document.querySelector('#description_shipping_country').innerHTML = address_book.zip + ', ' + address_book.country + ', ' + address_book.region;
        document.querySelector('#description_shipping_address').innerHTML = address_book.city + ', ' + address_book.address;

        document.querySelector('#description_billing_country').innerHTML = address_book.zip + ', ' + address_book.country + ', ' + address_book.region;
        document.querySelector('#description_billing_address').innerHTML = address_book.city + ', ' + address_book.address;

        document.querySelector('#description_date_purchased').innerHTML = history_status[0].admin.status + ': ' + history_status[0].admin.date;

        document.querySelector('#description_order_total').innerHTML = order_total.admin.total_to_pay_format;

        for (var x = 0; x < invoice.length; x++) {
            if (invoice[x].admin.stiker !== null && invoice[x].admin.stiker !== undefined) {
                var stiker = invoice[x].admin.stiker;
            } else {
                var stiker = '';
            }
            document.querySelector('#invoice').insertAdjacentHTML('beforeend', '<tr class="align-middle">\n\
                                        <td class="text-start"><span class="badge bg-success">' + stiker + '</span></td>\n\
                                        <td class="text-center"><small>' + invoice[x].admin.name + '</small></td>\n\
                                        <td class="text-center"><small>' + invoice[x].admin.price + '</small></td>\n\
                                        <td class="text-center"><small>' + invoice[x].data.quantity + ' ' + invoice[x].admin.unit + '</small></td>\n\
                                        <td class="text-end"><small>' + invoice[x].admin.amount + '</small></td>\n\
                                  </tr>');
        }

        document.querySelector('#invoice_shipping_method').innerHTML = '<b>' + shipping_method + '</b>';
        document.querySelector('#invoice_shipping_price').innerHTML = order_total.admin.shipping_price_format;
        document.querySelector('#invoice_order_total').innerHTML = order_total.admin.total_format;

        if (Number(order_total.data.order_total_tax) > 0) {
            document.querySelector('#invoice_taxes').innerHTML = order_total.admin.order_total_tax_format;
        }
        if (Number(order_total.data.order_total_tax) === 0) {
            document.querySelector('#invoice_taxes').innerHTML = '<?php echo lang('orders_price_including_all_taxes') ?>';
        }

        document.querySelector('#invoice_order_total_to_pay').innerHTML = order_total.admin.total_to_pay_format;

        for (x = 0; x < history_status.length; x++) {
            document.querySelector('#status_history').insertAdjacentHTML('beforeend', '<span class="badge bg-success">' + history_status[x].admin.status + '</span><span class="bi-check"></span><small> ' + history_status[x].admin.date + ' </small><br>');
        }
    });
</script>

<script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>
