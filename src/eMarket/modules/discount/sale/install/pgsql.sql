/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_discount_sale;
DROP SEQUENCE IF EXISTS emkt_modules_discount_sale_seq;
CREATE SEQUENCE emkt_modules_discount_sale_seq;
CREATE TABLE emkt_modules_discount_sale (
	id int NOT NULL default nextval ('emkt_modules_discount_sale_seq'),
        name varchar(256),
        language varchar(64),
        sale_value decimal(4,2),
	date_start date,
        date_end date,
        default_set int,
	PRIMARY KEY (id, language));