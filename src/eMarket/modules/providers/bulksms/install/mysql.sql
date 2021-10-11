/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_providers_bulksms;
CREATE TABLE emkt_modules_providers_bulksms (
	id int NOT NULL auto_increment,
        login varchar(256) NOT NULL,
        password varchar(256) NOT NULL,
        sender varchar(256) NOT NULL,
	PRIMARY KEY (id))
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;