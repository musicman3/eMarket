ALTER TABLE emkt_basic_settings ADD logo_general VARCHAR(128);
ALTER TABLE emkt_basic_settings ADD logo json;
ALTER TABLE emkt_basic_settings DROP COLUMN logo_general;
ALTER TABLE emkt_basic_settings DROP COLUMN logo;
CREATE TABLE emkt_contacts (id int NOT NULL,language varchar(64),logo json,logo_general varchar(128),status int,description text,PRIMARY KEY (language)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE emkt_about_us (id int NOT NULL,language varchar(64),logo json,logo_general varchar(128),status int,description text,PRIMARY KEY (language)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE emkt_shipping (id int NOT NULL,language varchar(64),logo json,logo_general varchar(128),status int,description text,PRIMARY KEY (language)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
