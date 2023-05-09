/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_discount_sale;
CREATE TABLE emkt_modules_discount_sale (
	id int NOT NULL,
        name text(256),
        language text(64),
        sale_value numeric(4,2),
	date_start datetime,
        date_end datetime,
        default_set int,
        PRIMARY KEY (id, language));