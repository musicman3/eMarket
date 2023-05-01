/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_providers_smsc;
DROP SEQUENCE IF EXISTS emkt_modules_providers_smsc_seq;
CREATE SEQUENCE emkt_modules_providers_smsc_seq;
CREATE TABLE emkt_modules_providers_smsc (
	id int NOT NULL default nextval ('emkt_modules_providers_smsc_seq'),
        login varchar(256) NOT NULL,
        password varchar(256) NOT NULL,
        sender varchar(256) NOT NULL,
	PRIMARY KEY (id));