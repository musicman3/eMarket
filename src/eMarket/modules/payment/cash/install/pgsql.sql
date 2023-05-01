/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_payment_cash;
DROP SEQUENCE IF EXISTS emkt_modules_payment_cash_seq;
CREATE SEQUENCE emkt_modules_payment_cash_seq;
CREATE TABLE emkt_modules_payment_cash (
	id int NOT NULL default nextval ('emkt_modules_payment_cash_seq'),
        order_status int DEFAULT '1' NOT NULL,
        shipping_module varchar(256),
	PRIMARY KEY (id));