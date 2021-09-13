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
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <style type="text/css">
      html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {margin: 0;padding: 0;border: 0;font: inherit;font-size: 100%;vertical-align: middle;}
      table {border-collapse: collapse;border-spacing: 0;}
      th, td {text-align: left;font-weight: normal;}
      a img {border: none;}
      figure, footer, header, section {display: block;}
      body {font-family: 'Source Sans Pro', sans-serif;font-weight: 300;font-size: 12px;margin: 0;padding: 0;color: #777777;}
      body a {text-decoration: none;color: inherit;}
      body a:hover {color: inherit;opacity: 0.7;}
      body .container {min-width: 500px;margin: 0 auto;padding: 0 30px;}
      body .clearfix:after {content: "";display: table;clear: both;}
      body .left {float: left;}
      body .right {float: right;}
      body .helper {height: 100%;}
      header {height: 40px;margin-top: 20px;margin-bottom: 40px;padding: 0px 5px 0;}
      header figure {float: left;width: 40px;margin-right: 10px;}
      header figure img {height: 40px;}
      header .company-info {color: #BDB9B9;}
      header .company-info .title {margin-bottom: 5px;color: #2A8EAC;font-weight: 600;font-size: 2em;}
      header .company-info .line {display: inline-block;height: 9px;margin: 0 4px;border-left: 1px solid #2A8EAC;}
      section .details {min-width: 500px;margin-bottom: 40px;padding: 10px 35px;background-color: #2A8EAC;color: #ffffff;}
      section .details .client {width: 50%;line-height: 16px;}
      section .details .client .name {font-weight: 600;}
      section .details .data {width: 50%;text-align: right;}
      section .details .title {margin-bottom: 15px;font-size: 3em;font-weight: 400;text-transform: uppercase;}
      section .table-wrapper {position: relative;overflow: hidden;}
      /*section .table-wrapper:before {content: "";display: block;position: absolute;top: 33px;left: 30px;width: 90%;height: 100%;border-top: 2px solid #BDB9B9;border-left: 2px solid #BDB9B9;z-index: -1;}*/
      section .no-break {page-break-inside: avoid;}
      section table {width: 100%;margin-bottom: -20px;table-layout: fixed;border-collapse: separate;border-spacing: 5px 20px;}
      section table .no {width: 10px;}
      section table .desc {width: 55%;}
      section table .qty, section table .unit, section table .total {width: 15%;}
      section table tbody.head {border-color: inherit;}
      section table tbody.head th {text-align: center;color: white;font-weight: 600;text-transform: uppercase;}
      section table tbody.head th {padding: 15px 0 0 0;background: #BDB9B9;}
      section table tbody.head th.no {padding: 15px 0 0 0;background: none;}
      section table tbody.head th.desc {width: 115px;margin-left: -110px;}
      section table tbody.body td {padding: 15px 10px 0 10px;background: #F3F3F3;text-align: center;}
      section table tbody.body h3 {margin-bottom: 5px;color: #2A8EAC;font-weight: 600;}
      section table tbody.body .no {background-color: #2A8EAC;color: #ffffff;font-size: 1.66666666666667em;font-weight: 600;}
      section table tbody.body .desc {background-color: transparent;color: #777787;text-align: left;}
      section table tbody.body .total {color: #2A8EAC;font-weight: 600;}
      section table tbody.body tr.total td {padding: 5px 10px;background-color: transparent;border: none;color: #777777;text-align: right;}
      section table tbody.body tr.total .empty {background: white;}
      section table tbody.body tr.total .total {font-size: 1.18181818181818em;font-weight: 600;color: #2A8EAC;}
      section table.grand-total {margin-top: 40px;margin-bottom: 0;border-collapse: collapse;border-spacing: 0px 0px;margin-bottom: 40px;}
      section table.grand-total tbody td {padding: 10px;background-color: #2A8EAC;color: #ffffff;font-weight: 400;text-align: right;}
      section table.grand-total tbody td.units {padding: 0 10px 10px 10px;}
      section table.grand-total tbody td.totals {padding: 0 10px 10px 10px;}
      section table.grand-total tbody td.no, section table.grand-total tbody td.desc, section table.grand-total tbody td.qty {background-color: transparent;}
      section table.grand-total tbody td.grand-total {font-size: 1.16666666666667em;font-weight: 600;background-color: #21BCEA;padding: 10px 5px;}
      footer {margin-bottom: 20px;padding: 0 5px;}
      footer .thanks {margin-bottom: 40px;color: #2A8EAC;font-size: 1.16666666666667em;font-weight: 600;}
      footer .notice {margin-bottom: 25px;}
      footer .end {padding-top: 5px;border-top: 2px solid #2A8EAC;text-align: center;}
    </style>
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
