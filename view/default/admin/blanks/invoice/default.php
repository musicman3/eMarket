<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Valid
};
?>

<!doctype html>
<html dir="ltr">
<head>
<!-- Connect css only like this: -->
<style><?php require_once ('default.css'); ?></style>
</head>
<body>

<div id="app" class="container invoice">
    <div class="row">
        <!-- data -->
        <div class="col-4 data py-4">
            <div class="line mt-4 mb-4"></div>
            <h1>INVOICE</h1>

            <div class="data-box">
                <div class="data-separator d-block my-2"></div>
                <h4 class="text-muted fw-light">No.</h4>
                <h4 class="fw-bold">23123123123</h4>
            </div>
            <div class="data-box">
                <div class="data-separator d-block my-2"></div>
                <h4 class="text-muted fw-light">INVOICE DATE</h4>
                <h4 class="fw-bold">January 05, 2018</h4>
            </div>
            <div class="data-box">
                <div class="data-separator d-block my-2"></div>
                <h4 class="text-muted fw-light">DUE DATE</h4>
                <h4 class="fw-bold">January 25, 2018</h4>
            </div>
            <div class="data-box">
                <h5 class="fw-bold">TERMS</h5>
                <p>Mollit elit reprehenderit consectetur cupidatat anim qui deserunt duis. Veniam laboris id veniam in eu.</p>
            </div>
            <div class="data-box">
                <h5 class="fw-bold">PAYMENT METHODS</h5>
                <h6 class="fw-light">PAYPAL</h6>
                <p>paypal@example.com</p>
                <h6 class="fw-light">ACCOUNTING NUMBER</h6>
                <p>1234567890988</p>
                <h6 class="fw-light">QR CODE</h6>
                <img src="/images/qr.png" alt="" class="img-fluid">
            </div>
            <div class="data-box d-flex align-items-end">
                <h1 class="fw-bold text-center">My company name</h1>
            </div>
        </div>
        <!-- end data -->

        <!-- content -->
        <div class="col-4 content py-4">
            <div class="line mt-4 mb-4"></div>
            <!-- header -->
            <div class="header">
                <div class="row">
                    <div class="col-6 from">
                        <span class="d-block fw-light">FROM:</span>
                        <h3>My Company</h3>
                        <span class="d-block fw-light">123.123.12312</span>
                        <span class="d-block fw-light">Address sasd asdas</span>
                        <span class="d-block fw-light">315 234 5677</span>
                        <span class="d-block fw-light">juan@mycompany.com</span>
                    </div>
                    <div class="col-6 to">
                        <span class="d-block fw-light">TO:</span>
                        <h3>Customer</h3>
                        <span class="d-block fw-light">123.123.12312</span>
                        <span class="d-block fw-light">Address sasd asdas</span>
                        <span class="d-block fw-light">315 234 5677</span>
                        <span class="d-block fw-light">customer@people.com</span>
                    </div>
                </div>
            </div>
            <!-- end header -->

            <!-- note -->
            <div class="row my-4">
                <div class="col-12">
                    <p class="text-justify">Quis sunt mollit nostrud aliqua consectetur voluptate eiusmod proident aute laboris non reprehenderit magna qui. Esse occaecat laboris laborum dolore excepteur enim laboris.</p>
                </div>
            </div>
            <!-- end note -->

            <!-- items-header -->
            <div class="items-header">
                <div class="row mt-4 items-header fw-bold">
                    <div class="col-12 my-2">
                        <div class="line"></div>
                    </div>
                    <div class="col-6">DESCRIPTION</div>
                    <div class="col-2 text-center">PRICE</div>
                    <div class="col-2 text-center">QUANTITY</div>
                    <div class="col-2 text-end">TOTAL</div>
                    <div class="col-12 my-2">
                        <div class="line"></div>
                    </div>
                </div>
            </div>
            <!-- end items-header -->

            <!-- items -->
            <div class="items">
                <div class="row mt-2 list-content">
                    <div class="col-6">
                        <p class="without-margin">Item of the invoice</p>
                        <p class="without-margin text-muted">
                            <small>Date: 2018-02-14</small>
                        </p>
                    </div>
                    <div class="col-2 text-center">$ 2.000</div>
                    <div class="col-2 text-center">2</div>
                    <div class="col-2 text-end">$ 4.000</div>
                </div>
                <div class="row">
                    <div class="col-12 my-2">
                        <div class="line-light"></div>
                    </div>
                </div>
                <div class="row mt-2 list-content">
                    <div class="col-6">
                        <p class="without-margin">Item of the invoice</p>
                        <p class="without-margin text-muted">
                            <small>Date: 2018-02-14</small>
                        </p>
                    </div>
                    <div class="col-2 text-center">$ 2.000</div>
                    <div class="col-2 text-center">2</div>
                    <div class="col-2 text-end">$ 4.000</div>
                </div>
                <div class="row">
                    <div class="col-12 my-2">
                        <div class="line-light"></div>
                    </div>
                </div>
                <div class="row mt-2 list-content">
                    <div class="col-6">
                        <p class="without-margin">Item of the invoice</p>
                        <p class="without-margin text-muted">
                            <small>Date: 2018-02-14</small>
                        </p>
                    </div>
                    <div class="col-2 text-center">$ 2.000</div>
                    <div class="col-2 text-center">2</div>
                    <div class="col-2 text-end">$ 4.000</div>
                </div>
                <div class="row">
                    <div class="col-12 my-2">
                        <div class="line-light"></div>
                    </div>
                </div>
                <div class="row mt-2 list-content">
                    <div class="col-6">
                        <p class="without-margin">Item of the invoice</p>
                        <p class="without-margin text-muted">
                            <small>Date: 2018-02-14</small>
                        </p>
                    </div>
                    <div class="col-2 text-center">$ 2.000</div>
                    <div class="col-2 text-center">2</div>
                    <div class="col-2 text-end">$ 4.000</div>
                </div>
                <div class="row">
                    <div class="col-12 my-2">
                        <div class="line-light"></div>
                    </div>
                </div>
                <div class="row mt-2 list-content">
                    <div class="col-6">
                        <p class="without-margin">Item of the invoice</p>
                        <p class="without-margin text-muted">
                            <small>Date: 2018-02-14</small>
                        </p>
                    </div>
                    <div class="col-2 text-center">$ 2.000</div>
                    <div class="col-2 text-center">2</div>
                    <div class="col-2 text-end">$ 4.000</div>
                </div>
                <div class="row">
                   <div class="col-12 my-2">
                        <div class="line-light"></div>
                    </div>
                </div>
                <div class="row mt-2 list-content">
                    <div class="col-6">
                        <p class="without-margin">Item of the invoice</p>
                        <p class="without-margin text-muted">
                            <small>Date: 2018-02-14</small>
                        </p>
                    </div>
                    <div class="col-2 text-center">$ 2.000</div>
                    <div class="col-2 text-center">2</div>
                    <div class="col-2 text-end">$ 4.000</div>
                </div>
            </div>
            <!-- end items -->

            <!-- values -->
            <div class="values">
                <div class="row">
                    <div class="col-12 my-2">
                        <div class="line"></div>
                    </div>
                </div>
                <div class="row mt-2 list-content">
                    <div class="col-10 fw-bold">
                        SUBTOTAL
                    </div>
                    <div class="col-2 text-end fw-bold">$ 24.000</div>
                </div>
                <div class="row mt-2 list-content">
                    <div class="col-10">
                        Discount 10%
                    </div>
                    <div class="col-2 text-end">-($ 2.400)</div>
                </div>
                <div class="row mt-2 list-content">
                    <div class="col-10">
                        Taxes 19%
                    </div>
                    <div class="col-2 text-end">$ 4.104</div>
                    <div class="col-12 my-2">
                        <div class="line-end"></div>
                    </div>
                </div>
                <div class="row mt-2 list-content">
                    <div class="col-9">
                        <h3 class="fw-bold">TOTAL</h3>
                    </div>
                    <div class="col-3 text-end">
                        <h3 class="fw-bold">$ 25.704</h3>
                    </div>
                </div>
            </div>
            <!-- end values -->

            <!-- signature -->
            <div class="signature my-4">
                <div class="row">
                    <div class="col-4 offset-8 text-end">
                        <img src="/images/hj.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-12 text-end">
                        <h4 class="fw-bold">Jhon Doe</h4>
                        <span class="d-block fw-light">CEO</span>
                    </div>
                </div>
            </div>
            <!-- end signature -->

            <!-- gratitude -->
            <div class="gratitude text-center my-4">
                <p class="text-muted">If you have any question about this invoice, please contact Jhon Doe to email jhon@mycompany.com, or to the mobile phone (057) 310 671 3456.</p>
                <h2>Thank you</h2>
            </div>
            <!-- end gratitude -->

            <!-- pagination -->
            <div class="invoice-pagination text-end">
                <p class="text-muted text-end">Page 1 of 1</p>
            </div>
            <!-- end pagination -->
        </div>
        <!-- end content -->
    </div>
</div>
</body>
</html>