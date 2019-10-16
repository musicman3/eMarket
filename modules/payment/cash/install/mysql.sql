/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_payment_cash;
CREATE TABLE emkt_modules_payment_cash (
	id int NOT NULL auto_increment,
        sort int(5),
	zones_id int(64),
	PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;