/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

DROP TABLE IF EXISTS emkt_modules_providers_smsc;
CREATE TABLE emkt_modules_providers_smsc (
	id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
        login text(256) NOT NULL,
        password text(256) NOT NULL,
        sender text(256) NOT NULL);