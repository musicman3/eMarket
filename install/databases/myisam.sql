/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

DROP TABLE IF EXISTS emkt_administrators;
CREATE TABLE emkt_administrators (
	login varchar(128) binary NOT NULL,
	password varchar(64) NOT NULL,
	language varchar(64) NOT NULL,
	permission varchar(20) NOT NULL,
	note varchar(256),
	status int DEFAULT '0' NOT NULL,
PRIMARY KEY (login))
ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS emkt_categories;
CREATE TABLE emkt_categories (
	id int NOT NULL auto_increment,
	name varchar(256) NOT NULL,
	language varchar(64),
	parent_id int DEFAULT '0' NOT NULL,
        image varchar(256),
	date_added datetime,
	last_modified datetime,
	sort_category int DEFAULT '0' NOT NULL,
	status int,
	PRIMARY KEY (id))
ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS emkt_products;
CREATE TABLE emkt_products (
	id int DEFAULT '0' NOT NULL,
        name varchar(256) NOT NULL,
        language varchar(64) NOT NULL,
	parent_id int DEFAULT '0' NOT NULL,
	images varchar(256),
	date_added datetime,
	last_modified datetime,
        products_model int NOT NULL,
        products_type varchar(256),
        manufacturer int NOT NULL,
        price decimal(12,2) NOT NULL,
        quantity int NOT NULL,
        weight decimal(5,2) NOT NULL,
        weight_class int NOT NULL,
        tax_class int NOT NULL,
        ordered int NOT NULL default '0',
        download_file varchar(256),
        keyword varchar(256),
        tags varchar(256),
        url varchar(256),
        viewed int default '0',
        description text,
	sort_products int DEFAULT '0' NOT NULL,
        status int,
	PRIMARY KEY (id))
ENGINE=MyISAM DEFAULT CHARSET=utf8;