/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_tabs_reviews;
CREATE TABLE emkt_modules_tabs_reviews (
	id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
        product_id int NOT NULL,
        author text(256),
        stars int,
        status int,
        likes int,
        date_add datetime,
        date_edit datetime,
        reviews text);