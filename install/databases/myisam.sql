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
	id int NOT NULL,
	name varchar(256) NOT NULL,
	language varchar(64),
	parent_id int DEFAULT '0' NOT NULL,
        image varchar(256),
	date_added datetime,
	last_modified datetime,
	sort_category int DEFAULT '0' NOT NULL,
	status int,
	PRIMARY KEY (id, language))
ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS emkt_products;
CREATE TABLE emkt_products (
	id int DEFAULT '0' NOT NULL,
        name varchar(256) NOT NULL,
        language varchar(64),
	parent_id int DEFAULT '0' NOT NULL,
	images varchar(1024),
	date_added datetime,
	last_modified datetime,
        date_available date,
        model varchar(64), 
        type varchar(256),
        articul varchar(64),
        code varchar(256),
        product_code varchar(256),
        product_code_value varchar(256),
        manufacturer int,
        price decimal(12,2),
        quantity int,
        min_quantity int,
        unit varchar(256),
        weight decimal(5,2),
        weight_class int,
        tax_class int,
        ordered int default '0',
        download_file varchar(256),
        keyword varchar(256),
        tags varchar(256),
        url varchar(256),
        unit_lenght varchar(256),
        lenght decimal(12,2),
        width decimal(12,2),
        height decimal(12,2),
        viewed int default '0',
        description text,
	sort int DEFAULT '0',
        status int,
	PRIMARY KEY (id))
ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS emkt_taxes;
CREATE TABLE emkt_taxes (
	id int NOT NULL,
	name varchar(256) NOT NULL,
	language varchar(64),
        tax decimal(12,2),
	PRIMARY KEY (id, language))
ENGINE=MyISAM DEFAULT CHARSET=utf8;