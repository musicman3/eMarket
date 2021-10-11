/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_tabs_reviews;
CREATE TABLE emkt_modules_tabs_reviews (
	id int NOT NULL auto_increment,
        product_id int NOT NULL,
        author varchar(256),
        stars int,
        status int,
        likes int,
        date_add datetime,
        date_edit datetime,
        reviews json,
PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;