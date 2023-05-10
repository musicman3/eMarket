/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_tabs_reviews;
DROP SEQUENCE IF EXISTS emkt_modules_tabs_reviews_seq;
CREATE SEQUENCE emkt_modules_tabs_reviews_seq;
CREATE TABLE emkt_modules_tabs_reviews (
	id int NOT NULL default nextval ('emkt_modules_tabs_reviews_seq'),
        product_id int NOT NULL,
        author varchar(256),
        stars int,
        status int,
        likes int,
        date_add timestamp(0),
        date_edit timestamp(0),
        reviews jsonb,
PRIMARY KEY (id));