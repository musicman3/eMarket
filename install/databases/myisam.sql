/****** Copyright © 2018 eMarket ******* 
    Copyright Â© 2018 eMarket    
* https://github.com/musicman3/eMarket *
****************************************/

DROP TABLE IF EXISTS csd_license;
CREATE TABLE csd_license (
	id int NOT NULL auto_increment,
	project_name varchar(255) NOT NULL,
	file_name varchar(255) NOT NULL,
	date_create varchar(20) NOT NULL,
	secret_key_1 varchar(255) NOT NULL,
	secret_key_2 varchar(255) NOT NULL,
	file_hash varchar(64) NOT NULL,
	license_status varchar(40) NOT NULL,
PRIMARY KEY (id))
ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS csd_listing;
CREATE TABLE csd_listing (
	id int NOT NULL auto_increment,
	date_create varchar(20) NOT NULL,
	date_end varchar(20) NOT NULL,
	license_status varchar(40) NOT NULL,
	license_id varchar(255) NOT NULL,
	license_key varchar(255) NOT NULL,
	license_domain varchar(255) NOT NULL,
	license_comment varchar(255) NOT NULL,
	ip varchar(40) NOT NULL,
	owner varchar(255) NOT NULL,
	email varchar(128) NOT NULL,
PRIMARY KEY (id))
ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS csd_project;
CREATE TABLE csd_project (
	id int NOT NULL auto_increment,
	project_name varchar(255) NOT NULL,
	date_create datetime,
	project_status varchar(40) NOT NULL,
PRIMARY KEY (id))
ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS csd_users;
CREATE TABLE csd_users (
	id int NOT NULL auto_increment,
	login varchar(128) binary NOT NULL,
	password varchar(64) NOT NULL,
	language varchar(128) NOT NULL,
	permission varchar(20) NOT NULL,
PRIMARY KEY (id))
ENGINE=MyISAM DEFAULT CHARSET=utf8;