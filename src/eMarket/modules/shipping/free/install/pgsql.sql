/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_shipping_free;
DROP SEQUENCE IF EXISTS emkt_modules_shipping_free_seq;
CREATE SEQUENCE emkt_modules_shipping_free_seq;
CREATE TABLE emkt_modules_shipping_free (
	id int NOT NULL default nextval ('emkt_modules_shipping_free_seq'),
        minimum_price decimal(12,2),
        shipping_zone int,
        currency int,
	PRIMARY KEY (id));