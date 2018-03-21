/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

DROP TABLE IF EXISTS emkt_administrators;
CREATE TABLE emkt_administrators (
	id int NOT NULL auto_increment,
	login varchar(128) binary NOT NULL,
	password varchar(64) NOT NULL,
	language varchar(64) NOT NULL,
	permission varchar(20) NOT NULL,
	note varchar(256),
	status int DEFAULT '0' NOT NULL,
PRIMARY KEY (id))
ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS emkt_categories;
CREATE TABLE emkt_categories (
	id int NOT NULL auto_increment,
	name varchar(255) NOT NULL,
	image varchar(255),
	language varchar(64),
	parent_id int DEFAULT '0' NOT NULL,
	sort_category int DEFAULT '0' NOT NULL,
	date_added datetime,
	last_modified datetime,
	status int,
	PRIMARY KEY (id))
ENGINE=MyISAM DEFAULT CHARSET=utf8;
