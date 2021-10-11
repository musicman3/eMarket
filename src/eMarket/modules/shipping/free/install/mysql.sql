/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_shipping_free;
CREATE TABLE emkt_modules_shipping_free (
	id int NOT NULL auto_increment,
        minimum_price decimal(12,2),
        shipping_zone int(1),
        currency int,
	PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;