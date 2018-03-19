/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

DROP TABLE IF EXISTS emkt_administrators;
CREATE TABLE emkt_administrators (
	id int NOT NULL auto_increment,
	login varchar(128) binary NOT NULL,
	password varchar(64) NOT NULL,
	language varchar(128) NOT NULL,
	permission varchar(20) NOT NULL,
	note varchar(256) NOT NULL,
PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS emkt_categories;
CREATE TABLE emkt_categories (
	categories_id int NOT NULL auto_increment,
	categories_image varchar(255),
	parent_id int DEFAULT '0' NOT NULL,
	sort_order int,
	date_added datetime,
	last_modified datetime,
	PRIMARY KEY (categories_id),
KEY idx_categories_parent_id (parent_id))
ENGINE=InnoDB DEFAULT CHARSET=utf8;