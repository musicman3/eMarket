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
        <style type="text/css"><?php require_once('default.css') ?></style>
        <title>eMarket invoice</title>
    </head>
    <body>
        <header class="clearfix">
            <div class="container">
                <figure>
                    <img class="logo" src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+Cjxzdmcgd2lkdGg9IjQxcHgiIGhlaWdodD0iNDFweCIgdmlld0JveD0iMCAwIDQxIDQxIiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIj4KICAgIDwhLS0gR2VuZXJhdG9yOiBTa2V0Y2ggMy40LjEgKDE1NjgxKSAtIGh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaCAtLT4KICAgIDx0aXRsZT5MT0dPPC90aXRsZT4KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPgogICAgPGRlZnM+PC9kZWZzPgogICAgPGcgaWQ9IlBhZ2UtMSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCIgc2tldGNoOnR5cGU9Ik1TUGFnZSI+CiAgICAgICAgPGcgaWQ9IklOVk9JQ0UtMiIgc2tldGNoOnR5cGU9Ik1TQXJ0Ym9hcmRHcm91cCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTMwLjAwMDAwMCwgLTMwLjAwMDAwMCkiIGZpbGw9IiMyQThFQUMiPgogICAgICAgICAgICA8ZyBpZD0iWkFHTEFWTEpFIiBza2V0Y2g6dHlwZT0iTVNMYXllckdyb3VwIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMC4wMDAwMDAsIDE1LjAwMDAwMCkiPgogICAgICAgICAgICAgICAgPGcgaWQ9IkxPR08iIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAuMDAwMDAwLCAxNS4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNTaGFwZUdyb3VwIj4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMzkuOTI0NjM2MywxOC40NDg2MjEgTDMzLjc3MDczNTgsMTEuODQyMjkyMyBMMzMuNzcwNzM1OCw0LjIxMDUyNjgxIEMzMy43NzA3MzU4LDIuODMwOTIyMzYgMzIuNzI5MzQxMSwxLjcxMjU0NDE0IDMxLjQ0MTczNzIsMS43MTI1NDQxNCBDMzAuMTU3NDExOSwxLjcxMjU0NDE0IDI5LjExNjAxNzMsMi44MzA5MjIzNiAyOS4xMTYwMTczLDQuMjEwNTI2ODEgTDI5LjExNjAxNzMsNi44NDUxMTcwNCBMMjQuNTMzNzM3NCwxLjkyNjAzNDcxIEMyMi4yNjgwNTg1LC0wLjUwNDQxNDA5NCAxOC4zMjkwMTcxLC0wLjUwMDEyNDQ4NCAxNi4wNjg4NzEsMS45MzAzMjQzMiBMMC42ODExNDgzMjksMTguNDQ4NjIxIEMtMC4yMjY5NDY5ODQsMTkuNDI1NjYyMSAtMC4yMjY5NDY5ODQsMjEuMDA2NzY4MiAwLjY4MTE0ODMyOSwyMS45ODIwNDk0IEMxLjU5MDE2NTc3LDIyLjk1OTA5MDUgMy4wNjU3ODIyMywyMi45NTkwOTA1IDMuOTczODc3NTUsMjEuOTgyMDQ5NCBMMTkuMzU5OTYwOSw1LjQ2Mzc1Mjc1IEMxOS44NjE0OTg0LDQuOTI4NDMxNDcgMjAuNzQ0Nzk4Niw0LjkyODQzMTQ3IDIxLjI0MzQ2NzIsNS40NjIxMDI5IEwzNi42MzE5MDcxLDIxLjk4MjA0OTQgQzM3LjA4ODU2NzUsMjIuNDcwNTE1IDM3LjY4MzM0MjgsMjIuNzEzNzAyOSAzOC4yNzgxMTgsMjIuNzEzNzAyOSBDMzguODc0MDIwNCwyMi43MTM3MDI5IDM5LjQ3MDAyNTIsMjIuNDcwNTE1IDM5LjkyNTA0NjIsMjEuOTgyMDQ5NCBDNDAuODMzNTUxMywyMS4wMDY3NjgyIDQwLjgzMzU1MTMsMTkuNDI1NjYyMSAzOS45MjQ2MzYzLDE4LjQ0ODYyMSBMMzkuOTI0NjM2MywxOC40NDg2MjEgWiIgaWQ9IkZpbGwtMSI+PC9wYXRoPgogICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0yMS4xMTEzOTc0LDEwLjIwNTg2MTIgQzIwLjY2NDM2ODIsOS43MjYzMDQ4MiAxOS45NDA2OTkzLDkuNzI2MzA0ODIgMTkuNDk0ODk5NiwxMC4yMDU4NjEyIEw1Ljk1OTg0Mjk2LDI0LjczMTM1OTIgQzUuNzQ2MTEzMiwyNC45NjAzNTg0IDUuNjI1MjExNDIsMjUuMjczNjA5OSA1LjYyNTIxMTQyLDI1LjYwMDA2MDIgTDUuNjI1MjExNDIsMzYuMTk0ODQ2IEM1LjYyNTIxMTQyLDM4LjY4MDcyOTcgNy41MDI3NzUwNyw0MC42OTYxODYzIDkuODE4NDUzOTgsNDAuNjk2MTg2MyBMMTYuNTE5NDg2Myw0MC42OTYxODYzIEwxNi41MTk0ODYzLDI5LjU1NTQxMDIgTDI0LjA4NTA2ODgsMjkuNTU1NDEwMiBMMjQuMDg1MDY4OCw0MC42OTYxODYzIEwzMC43ODY2MTM1LDQwLjY5NjE4NjMgQzMzLjEwMjI5MjQsNDAuNjk2MTg2MyAzNC45Nzk3NTM2LDM4LjY4MDcyOTcgMzQuOTc5NzUzNiwzNi4xOTQ4NDYgTDM0Ljk3OTc1MzYsMjUuNjAwMDYwMiBDMzQuOTc5NzUzNiwyNS4yNzM2MDk5IDM0Ljg1OTY3MTUsMjQuOTYwMzU4NCAzNC42NDUyMjQ1LDI0LjczMTM1OTIgTDIxLjExMTM5NzQsMTAuMjA1ODYxMiBaIiBpZD0iRmlsbC0zIj48L3BhdGg+CiAgICAgICAgICAgICAgICA8L2c+CiAgICAgICAgICAgIDwvZz4KICAgICAgICA8L2c+CiAgICA8L2c+Cjwvc3ZnPg==" alt="">
                </figure>
                <div class="company-info">
                    <h2 class="title">Company Name</h2>
                    <span>455 Foggy Heights, AZ 85004, US&nbsp;</span>
                    <span class="line">&nbsp;</span>
                    <a class="phone" href="tel:602-519-0450">(602) 519-0450&nbsp;</a>
                    <span class="line">&nbsp;</span>
                    <a class="email" href="mailto:company@example.com">company@example.com</a>
                </div>
            </div>
        </header>

        <section>
            <div class="details clearfix">
                <div class="client left">
                    <p>INVOICE TO:</p>
                    <p class="name">John Doe</p>
                    <p>796 Silver Harbour,<br>TX 79273, US</p>
                    <a href="mailto:john@example.com">john@example.com</a>
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
                                <th class="no"></th>
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
                                <td class="unit units">AX 25%:</td>
                                <td class="total totals">$1,300.00</td>
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
