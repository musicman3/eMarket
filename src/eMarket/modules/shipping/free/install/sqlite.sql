/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_shipping_free;
CREATE TABLE emkt_modules_shipping_free (
	id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
        minimum_price numeric(12,2),
        shipping_zone int,
        currency int);