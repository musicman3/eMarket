<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Valid
};
?>

<!-- Connect css only like this: -->
<style><?php require_once ('default.css'); ?></style>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="{LOGO}">
        </div>
        <div id="company">
            <h2 class="name">{COMPANY_NAME}</h2>
            <div>455 Foggy Heights, AZ 85004, US</div>
            <div>(602) 519-0450</div>
            <div><a href="mailto:company@example.com">company@example.com</a></div>
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to">INVOICE TO:</div>
                <h2 class="name">John Doe</h2>
                <div class="address">796 Silver Harbour, TX 79273, US</div>
                <div class="email"><a href="mailto:john@example.com"><?php echo Valid::inPostJson('invoice_email') ?></a></div>
            </div>
            <div id="invoice">
                <h1>INVOICE <?php echo Valid::inPostJson('invoice_id') ?></h1>
                <div class="date">Date of Invoice: 01/06/2014</div>
                <div class="date">Due Date: 30/06/2014</div>
            </div>
        </div>
        <table border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="no">#</th>
                    <th class="desc">DESCRIPTION</th>
                    <th class="unit">UNIT PRICE</th>
                    <th class="qty">QUANTITY</th>
                    <th class="total">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="no">01</td>
                    <td class="desc"><h3>Website Design</h3>Creating a recognizable design solution based on the companys existing visual identity</td>
                    <td class="unit">$40.00</td>
                    <td class="qty">30</td>
                    <td class="total">$1,200.00</td>
                </tr>
                <tr>
                    <td class="no">02</td>
                    <td class="desc"><h3>Website Development</h3>Developing a Content Management System-based Website</td>
                    <td class="unit">$40.00</td>
                    <td class="qty">80</td>
                    <td class="total">$3,200.00</td>
                </tr>
                <tr>
                    <td class="no">03</td>
                    <td class="desc"><h3>Search Engines Optimization</h3>Optimize the site for search engines (SEO)</td>
                    <td class="unit">$40.00</td>
                    <td class="qty">20</td>
                    <td class="total">$800.00</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">SUBTOTAL</td>
                    <td>$5,200.00</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">TAX 25%</td>
                    <td>$1,300.00</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">GRAND TOTAL</td>
                    <td>$6,500.00</td>
                </tr>
            </tfoot>
        </table>
        <div id="thanks">Thank you!</div>
        <div id="notices">
            <div>NOTICE:</div>
            <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
        </div>
    </main>
    <footer>
        Invoice was created on a computer and is valid without the signature and seal.
    </footer>
</body>