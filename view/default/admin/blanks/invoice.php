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
        <title>eMarket invoice</title>
    </head>
    <body>
        <header class="clearfix">
            <div class="container">
                <div class="company-info">
                    <h2 class="title"><?php echo Valid::inPostJson('invoice_company_name') ?></h2>
                    <div><?php echo Valid::inPostJson('invoice_company_data') ?></div>
                    <div>(602) 519-0450 | company@example.com</div>
                </div>
            </div>
        </header>

        <section>
            <div class="details clearfix">
                <div class="client left">
                    <p><?php echo Valid::inPostJson('invoice_to') ?></p>
                    <p>John Doe</p>
                    <p>796 Silver Harbour,<br>TX 79273, US</p>
                    <a href="mailto:<?php echo Valid::inPostJson('invoice_email') ?>"><?php echo Valid::inPostJson('invoice_email') ?></a>
                </div>
                <div class="data right">
                    <div class="title">Invoice 3-2-1</div>
                    <div class="date">Date of Invoice: 01/06/2014<br>Due Date: 30/06/2014</div>
                </div>
            </div>
            <div class="container">
                <div class="table-wrapper">
                    <table>
                        <tbody class="head">
                            <tr class="head">
                                <th class="no">№</th>
                                <th class="desc">Description</th>
                                <th class="qty">Quantity</th>
                                <th class="unit">Unit price</th>
                                <th class="total">Total</th>
                            </tr>
                        </tbody>
                        <tbody class="body">
                            <tr>
                                <td class="no">01</td>
                                <td class="desc">Creating a recognizable design solution based</td>
                                <td class="qty">30</td>
                                <td class="unit">$40.00</td>
                                <td class="total">$1,200.00</td>
                            </tr>
                            <tr>
                                <td class="no">02</td>
                                <td class="desc">Developing a Content Management System-based design solution based</td>
                                <td class="qty">80</td>
                                <td class="unit">$40.00</td>
                                <td class="total">$3,200.00</td>
                            </tr>
                            <tr>
                                <td class="no">03</td>
                                <td class="desc">Optimize the site for search engines (SEO)</td>
                                <td class="qty">20</td>
                                <td class="unit">$40.00</td>
                                <td class="total">$800.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="no-break">
                    <table class="grand-total">
                        <tbody>
                            <tr>
                                <td class="no"></td>
                                <td class="desc"></td>
                                <td class="qty"></td>
                                <td class="unit">SUBTOTAL:</td>
                                <td class="total">$5,200.00</td>
                            </tr>
                            <tr>
                                <td class="no"></td>
                                <td class="desc"></td>
                                <td class="qty"></td>
                                <td class="unit">AX 25%:</td>
                                <td class="total">$1,300.00</td>
                            </tr>
                            <tr>
                                <td class="no"></td>
                                <td class="desc"></td>
                                <td class="qty"></td>
                                <td class="grand-total">TOTAL:</td>
                                <td class="grand-total">$6,500.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <footer>
            <div class="container">
                <div class="thanks">Thank you!</div>
                <div class="notice">
                    <div>NOTICE:</div>
                    <div>A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                </div>
                <div class="end">Invoice was created on a computer and is valid without the signature and seal.</div>
            </div>
        </footer>

    </body>
</html>
