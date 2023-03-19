<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Valid
};
?>

<!DOCTYPE html>
<html>
    <head>
        <style type="text/css"><?php require_once('invoice.css') ?></style>
        <title><?php echo Valid::inPostJson('invoice_title') ?></title>
    </head>
    <body>
        <header class="clearfix">
            <div class="container">
                <div class="company-info">
                    <h2 class="title"><?php echo Valid::inPostJson('invoice_company_name') ?></h2>
                    <div><?php echo Valid::inPostJson('invoice_company_data') ?></div>
                    <div><?php echo Valid::inPostJson('invoice_company_contacts') ?></div>
                </div>
            </div>
        </header>

        <section>
            <div class="details clearfix">
                <div class="client left">
                    <p><?php echo Valid::inPostJson('invoice_to') ?></p>
                    <p><?php echo Valid::inPostJson('invoice_customer_data')['firstname'] ?> <?php echo Valid::inPostJson('invoice_customer_data')['lastname'] ?></p>
                    <p><?php echo Valid::inPostJson('invoice_customer_address_book')['country'] . ', ' . Valid::inPostJson('invoice_customer_address_book')['zip'] . ', ' . Valid::inPostJson('invoice_customer_address_book')['city'] ?></p>
                    <p><?php echo Valid::inPostJson('invoice_customer_address_book')['region'] . ', ' . Valid::inPostJson('invoice_customer_address_book')['address'] ?></p>
                    <a href="mailto:<?php echo Valid::inPostJson('invoice_email') ?>"><?php echo Valid::inPostJson('invoice_email') ?></a>
                </div>
                <div class="data right">
                    <div class="title"><?php echo Valid::inPostJson('invoice_name') . ' ' . Valid::inPostJson('invoice_id') ?></div>
                    <div class="date"><?php echo Valid::inPostJson('invoice_date_of') . ' ' . Valid::inPostJson('invoice_date_purchased') ?></div>
                </div>
            </div>
            <div class="container">
                <div class="table-wrapper">
                    <table>
                        <tbody class="head">
                            <tr class="head">
                                <th class="no"><?php echo Valid::inPostJson('invoice_no') ?></th>
                                <th class="desc"><?php echo Valid::inPostJson('invoice_description') ?></th>
                                <th class="qty"><?php echo Valid::inPostJson('invoice_quantity') ?></th>
                                <th class="unit"><?php echo Valid::inPostJson('invoice_price') ?></th>
                                <th class="total"><?php echo Valid::inPostJson('invoice_amount') ?></th>
                            </tr>
                        </tbody>
                        <tbody class="body">
                            <?php foreach (Valid::inPostJson('invoice_data') as $key => $data) {
                                ?>
                                <tr>
                                    <td class="no"><?php echo $key + 1 ?></td>
                                    <td class="desc"><?php echo $data['admin']['name'] ?></td>
                                    <td class="qty"><?php echo $data['data']['quantity'] . ' ' . $data['admin']['unit'] ?></td>
                                    <td class="unit"><?php echo $data['admin']['price'] ?></td>
                                    <td class="total"><?php echo $data['admin']['amount'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="no-break">
                    <table class="grand-total">
                        <tbody>
                            <tr>
                                <td class="desc"></td>
                                <td class="unit"><?php echo Valid::inPostJson('invoice_subtotal') ?></td>
                                <td class="total"><?php echo Valid::inPostJson('invoice_order_total')['admin']['total_format'] ?></td>
                            </tr>
                            <tr>
                                <td class="desc"></td>
                                <td class="unit"><?php echo Valid::inPostJson('invoice_estimated_taxes') ?></td>
                                <td class="total"><?php echo Valid::inPostJson('invoice_order_total')['admin']['order_total_tax_format'] ?></td>
                            </tr>
                            <tr>
                                <td class="desc"></td>
                                <td class="unit"><?php echo Valid::inPostJson('invoice_shipping') ?></td>
                                <td class="total"><?php echo Valid::inPostJson('invoice_order_total')['admin']['shipping_price_format'] ?></td>
                            </tr>
                            <tr>
                                <td class="desc"></td>
                                <td class="grand-total"><?php echo Valid::inPostJson('invoice_total') ?></td>
                                <td class="grand-total"><?php echo Valid::inPostJson('invoice_order_total')['admin']['total_to_pay_format'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <footer>
            <div class="container">
                <div class="thanks"><?php echo Valid::inPostJson('invoice_thank') ?></div>
                <div class="notice">
                    <div><?php echo Valid::inPostJson('invoice_notice') ?></div>
                    <div><?php echo Valid::inPostJson('invoice_notice_text') ?></div>
                </div>
                <div class="end"><?php echo Valid::inPostJson('invoice_end') ?></div>
            </div>
        </footer>

    </body>
</html>
