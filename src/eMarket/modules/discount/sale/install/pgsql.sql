/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_discount_sale;
CREATE TABLE emkt_modules_discount_sale (
	id int NOT NULL,
        name varchar(256),
        language varchar(64),
        sale_value decimal(4,2),
	date_start timestamp(0),
        date_end timestamp(0),
        default_set int,
	PRIMARY KEY (id, language));