/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_payment_cash;
CREATE TABLE emkt_modules_payment_cash (
	id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
        order_status int DEFAULT '1' NOT NULL,
        shipping_module text(256));