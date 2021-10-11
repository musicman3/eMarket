/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/**
 * Orders
 *
 * @package Orders
 * @author eMarket
 * 
 */
class Orders {
    /**
     * Constructor
     *
     * @param lang {Object} (lang)
     */
    constructor(lang) {
        this.modalShow(lang);
    }

    /**
     * Modal show
     * 
     * @param lang {Object} (lang)
     */
    modalShow(lang) {
        document.querySelector('#index').addEventListener('show.bs.modal', function (event) {

            var button = event.relatedTarget;
            var modal_id = Number(button.dataset.edit);
            document.querySelector('#invoice').innerHTML = '';
            document.querySelector('#status_history').innerHTML = '';

            var orders_edit = JSON.parse(document.querySelector('#ajax_data').dataset.orders)[modal_id];

            var customer_data = JSON.parse(orders_edit.customer_data);
            var invoice = JSON.parse(orders_edit.invoice);
            var order_total = JSON.parse(orders_edit.order_total);
            var address_book = JSON.parse(customer_data.address_book);
            var history_status = JSON.parse(orders_edit.orders_status_history);
            var shipping_method = JSON.parse(orders_edit.shipping_method).customer;
            var payment_method = JSON.parse(orders_edit.payment_method).customer;

            document.querySelector('#title').innerHTML = lang['orders_number'] + ': ' + orders_edit.id;

            document.querySelector('#description_client_name').innerHTML = customer_data.firstname + ' ' + customer_data.lastname;
            document.querySelector('#description_client_phone').innerHTML = customer_data.telephone;
            document.querySelector('#description_client_email').innerHTML = orders_edit.email;

            document.querySelector('#description_payment_method').innerHTML = payment_method;

            document.querySelector('#description_shipping_method').innerHTML = '<b>' + shipping_method + '</b>';
            document.querySelector('#description_shipping_country').innerHTML = address_book.zip + ', ' + address_book.country + ', ' + address_book.region;
            document.querySelector('#description_shipping_address').innerHTML = address_book.city + ', ' + address_book.address;

            document.querySelector('#description_billing_country').innerHTML = address_book.zip + ', ' + address_book.country + ', ' + address_book.region;
            document.querySelector('#description_billing_address').innerHTML = address_book.city + ', ' + address_book.address;

            document.querySelector('#description_date_purchased').innerHTML = history_status[0].customer.status + ': ' + history_status[0].customer.date;

            document.querySelector('#description_order_total').innerHTML = order_total.customer.total_to_pay_format;

            for (var x = 0; x < invoice.length; x++) {
                if (invoice[x].customer.sticker !== null && invoice[x].customer.sticker !== undefined) {
                    var sticker = invoice[x].customer.sticker;
                } else {
                    var sticker = '';
                }
                document.querySelector('#invoice').insertAdjacentHTML('beforeend', '<tr class="align-middle">\n\
                                        <td class="text-start"><span class="badge bg-success">' + sticker + '</span></td>\n\
                                        <td class="text-center"><small>' + invoice[x].customer.name + '</small></td>\n\
                                        <td class="text-center"><small>' + invoice[x].customer.price + '</small></td>\n\
                                        <td class="text-center"><small>' + invoice[x].data.quantity + ' ' + invoice[x].customer.unit + '</small></td>\n\
                                        <td class="text-end"><small>' + invoice[x].customer.amount + '</small></td>\n\
                                  </tr>');
            }

            document.querySelector('#invoice_shipping_method').innerHTML = '<b>' + shipping_method + '</b>';
            document.querySelector('#invoice_shipping_price').innerHTML = order_total.customer.shipping_price_format;
            document.querySelector('#invoice_order_total').innerHTML = order_total.customer.total_format;

            if (Number(order_total.data.order_total_tax) > 0) {
                document.querySelector('#invoice_taxes').innerHTML = order_total.customer.order_total_tax_format;
            }
            if (Number(order_total.data.order_total_tax) === 0) {
                document.querySelector('#invoice_taxes').innerHTML = lang['orders_price_including_all_taxes'];
            }

            document.querySelector('#invoice_order_total_to_pay').innerHTML = order_total.customer.total_to_pay_format;

            for (var x = 0; x < history_status.length; x++) {
                document.querySelector('#status_history').insertAdjacentHTML('beforeend', '<span class="badge bg-success">' + history_status[x].customer.status + '</span> <span class="bi-check"></span><small> ' + history_status[x].customer.date + ' </small><br>');
            }

        });
    }
}